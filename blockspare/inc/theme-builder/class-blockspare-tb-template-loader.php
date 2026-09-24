<?php

defined('ABSPATH') || exit;


class Blockspare_TB_Template_Loader
{

  /**
   * @var Blockspare_TB_Condition_Registry
   */
  private $conditions;

  /**
   * @param Blockspare_TB_Condition_Registry $conditions Shared condition registry.
   */
  public function __construct(Blockspare_TB_Condition_Registry $conditions)
  {
    $this->conditions = $conditions;
  }


  public function init()
  {
    add_filter('template_include', array($this, 'maybe_override_page_template'));
    add_action('get_header', array($this, 'maybe_render_header'), 1);
    add_action('get_footer', array($this, 'maybe_render_footer'), 1);

    // Block/FSE themes: intercept the core/template-part block itself.
    add_filter('render_block_core/template-part', array($this, 'maybe_override_template_part'), 10, 2);
  }


  public function maybe_override_template_part($block_content, $block)
  {
    $slug = isset($block['attrs']['slug']) ? $block['attrs']['slug'] : '';

    if (! in_array($slug, array('header', 'footer'), true)) {
      return $block_content;
    }

    $post = $this->find_matching_template($slug);

    if (null === $post) {
      return $block_content; // No match — leave the theme's own template part untouched.
    }

    // Prefer the original block's own tagName (themes sometimes set
    // this explicitly), falling back to 'header'/'footer' — which
    // conveniently match our taxonomy slugs directly.
    $tag = (! empty($block['attrs']['tagName']) && is_string($block['attrs']['tagName']))
      ? $block['attrs']['tagName']
      : $slug;

    $tag = tag_escape($tag);
    if (empty($tag)) {
      $tag = $slug;
    }

    return sprintf(
      '<%1$s class="wp-block-template-part">%2$s</%1$s>',
      $tag,
      do_blocks($post->post_content) // phpcs:ignore WordPress.Security.EscapeOutput -- do_blocks() output is core-sanitized block content.
    );
  }

  /**
   * Overrides the resolved page template for single/archive/404/search/front-page
   * template types, if a matching custom template exists.
   *
   * @param string $template Absolute path to the template PHP file WP resolved.
   * @return string
   */
  public function maybe_override_page_template($template)
  {
    $type = $this->resolve_current_page_type();

    if (null === $type) {
      return $template;
    }

    $post = $this->find_matching_template($type);

    if (null === $post) {
      return $template;
    }

    // Stash the matched post so our neutral wrapper template can render it,
    // without relying on global state elsewhere in the request lifecycle.
    global $stbldr_matched_template;
    $stbldr_matched_template = $post;

    return BLOCKSPARE_TB_PATH . 'views/page-wrapper.php';
  }

  /**
   * Renders a custom header if one matches, and tells WP to skip the theme's own.
   */
  public function maybe_render_header()
  {
    $this->render_partial_if_matched('header');
  }

  /**
   * Renders a custom footer if one matches, and tells WP to skip the theme's own.
   */
  public function maybe_render_footer()
  {
    $this->render_partial_if_matched('footer');
  }

  /**
   * Shared logic for header/footer: find a match, render it, and prevent
   * the theme's own header.php/footer.php from ALSO rendering.
   *
   * @param string $type 'header' or 'footer'.
   */
  private function render_partial_if_matched($type)
  {
    $post = $this->find_matching_template($type);

    if (null === $post) {
      return; // No match — let the theme's own header/footer render normally.
    }


    $handled_precisely = $this->suppress_known_theme_chrome($type);

    if ('footer' === $type) {

      add_action(
        'wp_footer',
        function () use ($post) {
          echo '<!-- blocksparetb:footer start -->';
          echo do_blocks($post->post_content); // phpcs:ignore WordPress.Security.EscapeOutput -- do_blocks() output is core-sanitized block content.
          echo '<!-- blocksparetb:footer end -->';
        }
      );
    } else {

      echo '<!-- blocksparetb:header start -->';
      echo do_blocks($post->post_content); // phpcs:ignore WordPress.Security.EscapeOutput -- do_blocks() output is core-sanitized block content.
      echo '<!-- blocksparetb:header end -->';
    }

    if ($handled_precisely) {
      return;
    }

    add_filter(
      'locate_template',
      function () use ($type) {
        return 'footer' === $type
          ? BLOCKSPARE_TB_PATH . 'views/empty-footer.php'
          : BLOCKSPARE_TB_PATH . 'views/empty.php';
      },
      999
    );


    add_action('wp_head', array($this, 'print_legacy_theme_hide_css'), 999);
  }


  private function suppress_known_theme_chrome($type)
  {
    // get_template() returns the PARENT theme's directory slug, so this
    // correctly detects Astra even when a child theme is active.
    $theme = get_template();

    if ('astra' !== $theme) {
      return false;
    }

    if ('header' === $type) {
      // Astra's older "Legacy" header.
      remove_action('astra_masthead', 'astra_masthead_primary_template');

      if (class_exists('Astra_Builder_Header')) {
        $header_builder = Astra_Builder_Header::get_instance();
        remove_action('astra_primary_header', array($header_builder, 'primary_header'));
        remove_action('astra_mobile_primary_header', array($header_builder, 'mobile_primary_header'));
      }
      remove_action('astra_header', 'astra_header_markup');
    } elseif ('footer' === $type) {
      remove_action('astra_footer', 'astra_footer_markup');
      if (class_exists('Astra_Builder_Footer')) {
        remove_action('astra_footer', array(Astra_Builder_Footer::get_instance(), 'footer_markup'));
      }
    }


    return true;
  }


  public function print_legacy_theme_hide_css()
  {

?>
    <style id="blocksparetb-legacy-theme-hide">
      body>header:not(.blocksparetb-content),
      body>.site-header,
      body>#masthead,
      body>#header,
      body>footer:not(.blocksparetb-content),
      body>.site-footer,
      body>#colophon,
      body>#footer {
        display: none !important;
      }
    </style>
<?php
  }

  private function resolve_current_page_type()
  {
    if (is_404()) {
      return array('404');
    }
    if (is_search()) {
      return array('search');
    }
    if (is_category()) {
      return array('category', 'archive');
    }
    if (is_tag()) {
      return array('tag', 'archive');
    }
    if (is_author()) {
      return array('author', 'archive');
    }
    if (is_date()) {
      return array('date', 'archive');
    }
    if (is_front_page()) {
      // Check 'front_page' first, but fall back to 'archive'
      return array('front_page', 'archive');
    }
    if (is_archive() || is_home()) {
      return array('archive');
    }
    if (is_singular()) {
      return array('single');
    }

    return null;
  }


  private function find_matching_template($type)
  {
    if (empty($type)) {
      return null;
    }

    $terms = (array) $type;

    $candidates = get_posts(
      array(
        'post_type'      => Blockspare_TB_Template_Post_Type::SLUG,
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
          array(
            'taxonomy' => Blockspare_TB_Template_Type_Taxonomy::SLUG,
            'field'    => 'slug',
            'terms'    => $terms,
          ),
        ),
      )
    );

    usort(
      $candidates,
      function ($a, $b) {
        $priority_a = self::get_priority($a->ID);
        $priority_b = self::get_priority($b->ID);
        return $priority_a - $priority_b; // Lower number = higher priority.
      }
    );

    foreach ($candidates as $candidate) {
      $raw     = get_post_meta($candidate->ID, '_stbldr_conditions', true);
      $ruleset = $raw ? json_decode($raw, true) : array();

      if (! is_array($ruleset)) {
        continue;
      }

      if ($this->conditions->matches($ruleset)) {
        return $candidate;
      }
    }

    return null;
  }

  /**
   * Reads a template's priority, defaulting to 10 when the meta row
   * doesn't exist yet (mirrors the default shown in the REST `priority`
   * field and the editor's Priority control).
   *
   * @param int $post_id Template post ID.
   * @return int
   */
  private static function get_priority($post_id)
  {
    $value = get_post_meta($post_id, '_stbldr_priority', true);
    return '' === $value ? 10 : (int) $value;
  }
}
