<?php

defined('ABSPATH') || exit;

global $stbldr_matched_template;

$blockspare_tb_is_block_theme = function_exists('wp_is_block_theme') && wp_is_block_theme();

// 1. PRE-RENDER BLOCKS: Process blocks BEFORE outputting <head> so WordPress
// registers all Interactivity API script modules and generates the importmap in wp_head().
$rendered_header = '';
$rendered_footer = '';
$rendered_content = '';

if ($stbldr_matched_template instanceof WP_Post) {
  $rendered_content = do_blocks($stbldr_matched_template->post_content);
}

if ($blockspare_tb_is_block_theme) {
  $rendered_header = do_blocks('<!-- wp:template-part {"slug":"header","theme":"' . esc_attr(get_stylesheet()) . '","tagName":"header"} /-->');
  $rendered_footer = do_blocks('<!-- wp:template-part {"slug":"footer","theme":"' . esc_attr(get_stylesheet()) . '","tagName":"footer"} /-->');
}

if ($blockspare_tb_is_block_theme) :
?>
  <!DOCTYPE html>
  <html <?php language_attributes(); ?>>

  <head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
  </head>

  <body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div class="wp-site-blocks">
      <?php echo $rendered_header; // phpcs:ignore WordPress.Security.EscapeOutput 
      ?>

      <main id="wp--skip-link--target" class="wp-block-group has-global-padding is-layout-constrained wp-block-group-is-layout-constrained" style="margin-top:var(--wp--preset--spacing--60)">
        <?php echo $rendered_content; // phpcs:ignore WordPress.Security.EscapeOutput 
        ?>
      </main>

      <?php echo $rendered_footer; // phpcs:ignore WordPress.Security.EscapeOutput 
      ?>
    </div>

    <?php wp_footer(); ?>
  </body>

  </html>
<?php
else :
  // Fallback for classic themes
  get_header();
?>
  <main id="wp--skip-link--target" class="wp-block-group has-global-padding is-layout-constrained wp-block-group-is-layout-constrained" style="margin-top:var(--wp--preset--spacing--60)">
    <?php echo $rendered_content; // phpcs:ignore WordPress.Security.EscapeOutput 
    ?>
  </main>
<?php
  get_footer();
endif;
