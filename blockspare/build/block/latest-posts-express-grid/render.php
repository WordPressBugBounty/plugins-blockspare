<?php
$unq_class = mt_rand(100000, 999999);
$blockuniqueclass = '';

if (!empty($attributes['uniqueClass'])) {
  $blockuniqueclass = $attributes['uniqueClass'];
} else {
  $blockuniqueclass = 'blockspare-posts-block-list-' . $unq_class;
}

$design = 'blockspare-posts-block-latestpost-express-grid ';


$block_class = 'blockspare-posts-block-is-express' . ' has-gutter-' . $attributes['gutterSpace'];;;
if ($attributes['enableEqualHeight']) {
  $block_class .= ' bs-has-equal-height';
}

if ($attributes['displaySpotLightExceprt']) {
  $block_class .= ' has-spotlight-excerpt ';
}
$layoutClass = false;

if ($attributes['express'] != 'blockspare-posts-block-express-grid-layout-4' && $attributes['express'] != 'blockspare-posts-block-express-grid-layout-5' && $attributes['express'] != 'blockspare-posts-block-express-grid-layout-6') {
  $layoutClass = true;
}

$design .= $attributes['express'];
$blockName = 'express';
$alignclass = blockspare_checkalignment($attributes['align'], $attributes);


/* Build the block classes */
$class = "wp-block-blockspare-posts-block-blockspare-posts-block-latest-posts align" . $alignclass . " " . $attributes['blockHoverEffect'] . " " . $attributes['imageHoverEffect'];

if (isset($attributes['className'])) {
  $class .= ' ' . $attributes['className'];
}

if ($attributes['animation']) {
  $class .= ' blockspare-block-animation';
}
$class .= ' ' . $blockuniqueclass;


?>
<div class="<?php echo esc_attr($class); ?>" blockspare-animation="<?php echo esc_attr($attributes['animation']); ?>">
  <?php
  if (isset($attributes['enablePagination']) && $attributes['enablePagination']) {
    wp_enqueue_script('block_pagination_script');
  }
  blockspare_latest_posts_style_control($blockuniqueclass, $attributes);
  blockspare_epxpress_query_loop_and_wrapper($attributes, $block_class, $design, $blockName, $layoutClass);
  ?>
</div>
<?php
