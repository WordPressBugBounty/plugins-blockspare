<?php
$unq_class = mt_rand(100000, 999999);
$blockuniqueclass = '';

if ($attributes['enableTwoColumn']) {
  $design = $attributes['design'] . ' list-col-2';
} else {
  $design = $attributes['design'] . ' ' . $attributes['columns'];
}

if (!empty($attributes['uniqueClass'])) {
  $blockuniqueclass = $attributes['uniqueClass'];
} else {
  $blockuniqueclass = 'blockspare-posts-block-list-' . $unq_class;
}

$hasimgclass = 'featured-img-not-enabaled';
if ($attributes['enableFeatureImage'] == true) {
  $hasimgclass = $attributes['imageSize'] . '-' . $attributes['ImageUnit'];
}
$blockName = 'post-list';
$layoutClass = false;
if ($attributes['design'] != 'blockspare-posts-block-list-layout-4' && $attributes['design'] != 'blockspare-posts-block-list-layout-5' && $attributes['design'] != 'blockspare-posts-block-list-layout-6') {
  $layoutClass = true;
}

$block_class = 'blockspare-posts-block-is-list ' . $hasimgclass . ' has-gutter-' . $attributes['gutterSpace'];
if ($attributes['displayPostExcerpt'] == true) {
  $block_class .= ' blockspare-post-expert-enabled';
}
if ($attributes['imageSize'] == 'thumbnail') {
  $block_class .= ' blockspare-has-thumbnail-image';
}

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
  blockspare_posts_style_control_list($blockuniqueclass, $attributes);
  blockspare_query_loop_and_wrapper($attributes, $block_class, $design, $blockName, '', $layoutClass);
  ?>
</div>

<?php
