<?php
/**
 * Template Name: Page Builder Full Width
 *
 * A safe full-width template that works with any theme.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Detect block themes safely
function blockspare_is_true_block_theme() {
    return function_exists( 'wp_is_block_theme' )
        && wp_is_block_theme()
        && file_exists( get_theme_file_path( 'theme.json' ) );
}

// Load Header
if ( blockspare_is_true_block_theme() ) {
    block_template_part( 'header' );
} else {
    get_header();
}
?>

    <main id="main" class="site-main" role="main">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                the_content(); // Page builder content area
            endwhile;
        endif;
        ?>
    </main>


<?php
// Load Footer
if ( blockspare_is_true_block_theme() ) {
    block_template_part( 'footer' );
} else {
    get_footer();
}

// No manual wp_footer(), body, html closing
// Theme already handles it
