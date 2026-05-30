<?php

/**
 * inc/init.php
 * @package Blockspare
 */

defined('ABSPATH') or die('No script kiddies please!');

class Blockspare_Init
{
  public function __construct()
  {

    // 1. Hooks
    add_action('init', [$this, 'blockspare_plugin_init']);
    add_action('admin_enqueue_scripts', [$this, 'blockspare_enqueue_editor_assets']);
    // add_action('enqueue_block_assets', [$this, 'blockspare_blocks_register_blocks']);
    add_action('enqueue_block_assets', [$this, 'blockspare_fb_enqueue_frontend_assets']);
    //add_action('enqueue_block_editor_assets', [$this, 'blockspare_fb_enqueue_frontend_assets']);
    add_action('wp_enqueue_scripts', [$this, 'blockspare_enqueue_frontend_script']);
    add_filter('block_categories_all', [$this, 'blockspare_register_custom_categories'], 10, 2);
    add_action('plugins_loaded', [$this, 'blockspare_load_dynamic_blocks']);
    add_action('rest_api_init', array($this, 'blockspare_blocks_register_api_endpoints'));
  }

  public function blockspare_plugin_init()
  {
    $this->blockspare_blocks_register_blocks();
    //$this->blockspare_fb_enqueue_frontend_assets();
    $this->blockspare_load_load_text_domain();
  }
  // ══════════════════════════════════════════════════════════════════════════
  // Helper Functions
  // ══════════════════════════════════════════════════════════════════════════
  public static function get_post_types()
  {
    static $cache = null;
    if ($cache !== null) return $cache;

    $transient = get_transient('blockspare_post_types');
    if ($transient !== false) {
      $cache = $transient;
      return $cache;
    }


    $args = ['public' => true, 'show_in_rest' => true];
    $post_types = get_post_types($args, 'objects');

    $output = [];
    foreach ($post_types as $post_type) {
      if ($post_type->name === 'attachment') continue;

      $output[] = [
        'value' => $post_type->name,
        'label' => $post_type->label,
      ];
    }

    set_transient('blockspare_post_types', $output, HOUR_IN_SECONDS);
    $cache = apply_filters('aft_blocks_post_types', $output);

    return $cache;
  }

  public static function get_taxonomies()
  {
    static $cache = null;
    if ($cache !== null) return $cache;

    $transient = get_transient('blockspare_taxonomies');
    if ($transient !== false) {
      $cache = $transient;
      return $cache;
    }

    $post_types = self::get_post_types();
    $output = [];

    foreach ($post_types as $post_type) {
      $pt = $post_type['value'];
      $taxonomies = get_object_taxonomies($pt, 'objects');

      foreach ($taxonomies as $term_slug => $term) {
        if (!$term->public || !$term->show_ui) continue;

        $terms = get_terms([
          'taxonomy' => $term_slug,
          'hide_empty' => false,
        ]);

        if (!empty($terms) && !is_wp_error($terms)) {
          foreach ($terms as $term_item) {
            $output[$pt]['terms'][$term_slug][] = [
              'value' => $term_item->term_id,
              'label' => $term_item->name,
            ];
          }
        }
      }

      $output[$pt]['taxonomy'] = $taxonomies;
    }

    set_transient('blockspare_taxonomies', $output, HOUR_IN_SECONDS);
    $cache = apply_filters('aft_blocks_taxonomies', $output);

    return $cache;
  }

  // ══════════════════════════════════════════════════════════════════════════
  // 1. Register blocks
  // ══════════════════════════════════════════════════════════════════════════
  public function blockspare_blocks_register_blocks()
  {
    $blocks = glob(BLOCKSPARE_PLUGIN_DIR . 'build/block/*/block.json');

    if ($blocks) {
      foreach ($blocks as $block) {
        register_block_type(dirname($block));
      }
    }

    wp_enqueue_style(
      'blockspare-fontawesome',
      BLOCKSPARE_PLUGIN_URL . 'assets/fontawesome/css/all.css',
      [],
      BLOCKSPARE_VERSION
    );
  }

  public function blockspare_enqueue_frontend_script()
  {
    wp_register_style(
      'slick',
      BLOCKSPARE_PLUGIN_URL . 'assets/slick/css/slick.min.css',
      array(),
      BLOCKSPARE_VERSION
    );

    wp_register_script(
      'slick',
      BLOCKSPARE_PLUGIN_URL . 'assets/slick/js/slick.min.js',
      array('jquery'),
      BLOCKSPARE_VERSION,
      true
    );
    global $post;

    if ($post && has_blocks($post->post_content)) {
      $content = $post->post_content;

      $hasCarousel = has_block('blockspare/blockspare-carousel', $content);
      $hasSlider   = has_block('blockspare/blockspare-slider', $content);
      $hasMasonry   = has_block('blockspare/blockspare-masonry', $content);

      if ($hasCarousel || $hasSlider) {
        wp_enqueue_style('slick');
        wp_enqueue_script('slick');
      }
      if ($hasMasonry) {
        wp_enqueue_script('jquery-masonry');
      }
    }




    wp_enqueue_script(
      'block_animation_script',
      BLOCKSPARE_PLUGIN_URL . 'dist/block_animation_script.js',
      ['jquery'],
      BLOCKSPARE_VERSION,
      true
    );
    wp_register_script(
      'block_pagination_script',
      BLOCKSPARE_PLUGIN_URL . 'dist/block_pagination_script.js',
      ['jquery'],
      BLOCKSPARE_VERSION,
      true
    );
    wp_localize_script('block_pagination_script', 'blocsparePagination', array(
      'ajaxurl' => admin_url('admin-ajax.php'),
      'nonce' => wp_create_nonce('blockspare-load-more-nonce'),
    ));
  }

  // ══════════════════════════════════════════════════════════════════════════
  // 2. Editor-only assets
  // ══════════════════════════════════════════════════════════════════════════
  public function blockspare_enqueue_editor_assets()
  {

    global $pagenow;

    // ✅ Prevent unnecessary loading
    if (!in_array($pagenow, ['post.php', 'post-new.php', 'widgets.php'])) {
      return;
    }

    wp_register_script(
      'blockspare-category',
      BLOCKSPARE_PLUGIN_URL . 'dist/block_category.js',
      [
        'wp-blocks',
        'wp-i18n',
        'wp-element',
        'wp-components',
        'wp-block-editor',
        'wp-api-fetch',
      ],
      BLOCKSPARE_VERSION,
      true
    );





    $blockspare_priview_img_url = BLOCKSPARE_PLUGIN_URL . 'assets/blockspare-placeholder-img.jpg';
    $blockspare_food_img_url    = BLOCKSPARE_PLUGIN_URL . 'assets/blockspare-placeholder-img-square.jpg';
    $blockspare_promo_img       = BLOCKSPARE_PLUGIN_URL . 'assets/banner-promo-1120-wu-1.png';
    $date                       = wp_kses_post(date_i18n(get_option('date_format')));
    $date_format                = date_i18n(get_option('date_format'), current_time('timestamp'));

    $open_design = isset($_GET['blockspare_show_intro']) && $_GET['blockspare_show_intro'] === 'true';

    $blockData = '';
    if (isset($_GET['blockspare_create_block'])) {
      $blockName  = sanitize_text_field($_GET['blockspare_create_block']);
      $filterdata = apply_filters('blockspare_template_library', []);

      foreach ($filterdata as $block) {
        if (isset($block['key']) && $block['key'] === $blockName) {
          $blockData = $block['content'];
          break;
        }
      }
    }

    global $pagenow;
    $loadscripton = ($pagenow === 'widgets.php' || is_customize_preview());

    $blockspare_current_wp_version = get_bloginfo('version');


    $globals = [
      'srcUrl'            => untrailingslashit(plugins_url('/', BLOCKSPARE_BASE_DIR . '/build/')),
      'rest_url'          => esc_url(rest_url()),
      'nonce'             => wp_create_nonce('wp_rest'),
      'img'               => $blockspare_priview_img_url,
      'menu_img_url'      => $blockspare_food_img_url,
      'block_key'         => '',
      'homeUrl'           => home_url(),
      'blogUrl'           => get_site_url(),
      'postTypes'         => self::get_post_types(),
      'taxonomies'        => self::get_taxonomies(),
      'postQueryEndpoint' => 'aft/v1/post-query',
      'config'            => '',
      'configuration'     => '',
      'settings'          => '',
      'bs_date'           => $date,
      'promo_img'         => $blockspare_promo_img,
      'imagePath'         => 'https:raw.githubusercontent.com/afthemes/blockspare-demo-data/master/blocks/new/',
      'open_design'       => $open_design,
      'date_format'       => $date_format,
      'blockData'         => $blockData,
      'template_link'     => admin_url('edit.php?post_type=bs_templates'),
      'newTemlateUrl'     => admin_url('post-new.php?post_type=bs_templates&blockspare_create_block&blockspare_show_intro=true'),
      'loadscripton'      => $loadscripton,
      'wpversion'         => (version_compare($blockspare_current_wp_version, '6.6') >= 0) ? 'true' : 'false',
      'inspector_imgs' => BLOCKSPARE_PLUGIN_URL . 'assets/images',
      'upgradeUrl' => 'https://afthemes.com/blockspare-pro/',

    ];

    // Attach globals to wp-blocks (WordPress default Gutenberg handle)
    wp_add_inline_script(
      'wp-blocks',
      'var blockspare_globals = ' . wp_json_encode($globals) . ';',
      'before' // make sure it runs before wp-blocks executes
    );

    wp_enqueue_script('blockspare-category');

    wp_enqueue_style(
      'blockspare-panel',
      BLOCKSPARE_PLUGIN_URL . 'dist/panel.css',
      ['wp-edit-blocks'],
      BLOCKSPARE_VERSION
    );
    wp_enqueue_style(
      'blockspare-animation-blocks',
      BLOCKSPARE_PLUGIN_URL . 'dist/block_animation.css',
      [],
      BLOCKSPARE_VERSION
    );
    if (is_admin()):
      wp_enqueue_script(
        'blockspare-design-btn',
        BLOCKSPARE_PLUGIN_URL . 'dist/block_design_btn.js',
        array('blockspare-category'),
        BLOCKSPARE_VERSION,
        true
      );
    endif;


    wp_localize_script('blockspare-category', 'cbvData', [
      'isLoggedIn' => is_user_logged_in(),
    ]);
  }

  public function blockspare_fb_enqueue_frontend_assets()
  {
    wp_enqueue_style(
      'blockspare-fontawesome',
      BLOCKSPARE_PLUGIN_URL . 'assets/fontawesome/css/all.css',
      [],
      BLOCKSPARE_VERSION
    );
    wp_enqueue_style(
      'blockspare-common-latest-post',
      BLOCKSPARE_PLUGIN_URL . 'dist/lates_post_css.css',
      [],
      BLOCKSPARE_VERSION
    );

    wp_enqueue_style(
      'blockspare-common-all-blocks',
      BLOCKSPARE_PLUGIN_URL . 'dist/common_all_blocks.css',
      [],
      BLOCKSPARE_VERSION
    );
    wp_enqueue_style(
      'blockspare-animation-blocks',
      BLOCKSPARE_PLUGIN_URL . 'dist/block_animation.css',
      [],
      BLOCKSPARE_VERSION
    );
  }

  // ══════════════════════════════════════════════════════════════════════════
  // 3. Custom block categories
  // ══════════════════════════════════════════════════════════════════════════
  public function blockspare_register_custom_categories($categories)
  {
    $custom = [
      [
        'slug'  => 'blockspare-post',
        'title' => __('News and Magazine', 'blockspare'),

      ],
      [
        'slug'  => 'blockspare',
        'title' => __('Business', 'blockspare'),

      ],
      
    ];

    return array_merge($custom, $categories);
  }

  // ══════════════════════════════════════════════════════════════════════════
  // 4. Load server-side render files
  // ══════════════════════════════════════════════════════════════════════════
  public function blockspare_load_dynamic_blocks()
  {
    $this->load_layout_dependencies();
    $this->load_block_includes();
  }

  private function load_layout_dependencies()
  {
    if (PHP_VERSION_ID < 50600) {
      return;
    }

    $layout_files = [
      'inc/layout/class-image-importer.php',
      'inc/layout/functions.php',
      'inc/layout/registry.php',
      'inc/layout/components.php',
      'inc/layout/endpoints.php',
      'inc/layout/save-templates.php',
    ];

    $this->include_files($layout_files);
  }

  private function load_block_includes()
  {
    $block_files = [
      'inc/rest-api-function.php',
      'inc/latest-post-block/posts-grid/index.php',
      'inc/latest-post-block/posts-carousel-grid/index.php',
      'inc/latest-post-block/posts-slider/index.php',
      'inc/latest-post-block/posts-list/index.php',
      'inc/latest-post-block/posts-flash/index.php',
      'inc/latest-post-block/posts-express-grid/index.php',
      'inc/other-block/date-time/index.php',
      'inc/latest-post-block/posts-popular-tags/index.php',
      'inc/blockspare-functions.php',
      'inc/block-posts-config/class-post-rest-api.php',
      'inc/block-posts-config/class-multiauthor-backend.php',
      'inc/block-posts-config/class-multiauthor-frontend.php',
      'inc/block-posts-config/tax-category.php',
      'inc/block-posts-config/class-bs-post.php',
      'inc/block-posts-config/latest-post-tile-common.php',
      'inc/other-block/social-sharing/index.php',
      'inc/other-block/search/index.php',
      'inc/block-banner/frontend-render/post-category-style.php',
      'inc/block-banner/frontend-render/post-banner-config.php',
      'inc/block-banner/frontend-render/post-banner-style.php',
      'inc/block-posts-config/ajax-pagination.php',

      'inc/post-banner/banner-1/index.php',
      'inc/post-banner/banner-2/index.php',
      'inc/post-banner/banner-9/index.php',
    ];
    $this->include_files($block_files);
  }

  /**
   * Reusable file loader
   */
  private function include_files($files = [])
  {

    foreach ($files as $file) {
      $filepath = BLOCKSPARE_PLUGIN_DIR . $file;

      if (file_exists($filepath)) {
        include_once $filepath;
      }
    }
  }

  public function blockspare_blocks_register_api_endpoints()
  {

    $posts_controller = new Aft_Post_Rest_Controller();
    $posts_controller->register_routes();
  }



  // ══════════════════════════════════════════════════════════════════════════
  // 5. Load text domain
  // ══════════════════════════════════════════════════════════════════════════
  public function blockspare_load_load_text_domain()
  {
    load_plugin_textdomain(
      'blockspare',
      false,
      dirname(plugin_basename(BLOCKSPARE_BASE_FILE)) . '/languages'
    );
  }
}

// Initialize the class
new Blockspare_Init();
