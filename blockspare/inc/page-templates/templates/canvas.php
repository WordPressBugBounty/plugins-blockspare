<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Detect true block-theme environment.
 */
function blockspare_is_true_block_theme() {
	return function_exists( 'wp_is_block_theme' )
		&& wp_is_block_theme()
		&& file_exists( get_theme_file_path( 'theme.json' ) );
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php if ( ! current_theme_supports( 'title-tag' ) ) : ?>
		<title><?php echo wp_get_document_title(); ?></title>
	<?php endif; ?>

	<?php wp_head(); ?>

	<?php
	// Force global styles for block themes (WP 6.9+)
	if ( blockspare_is_true_block_theme() ) {
		if ( function_exists( 'wp_get_global_stylesheet' ) ) {
			echo '<style id="global-styles-inline-css">' . wp_get_global_stylesheet() . '</style>';
		}
		if ( function_exists( 'wp_get_layout_stylesheet' ) ) {
			echo '<style id="global-styles-inline-layout-css">' . wp_get_layout_stylesheet() . '</style>';
		}
	}
	?>
</head>
<body <?php body_class( 'blockspare-blank-canvas' ); ?>>

<div class="blockspare-page-section">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
	endif;
	?>
</div>

<?php
// For classic themes, call wp_footer() once
if ( ! did_action( 'wp_footer' ) ) {
	wp_footer();
}
?>
</body>
</html>
