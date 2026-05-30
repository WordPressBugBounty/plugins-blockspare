<?php
if ($attributes['showPresets'] == true) {
  return;
}

$unq_class = mt_rand(100000, 999999);
$blockuniqueclass = '';

if (!empty($attributes['uniqueClass'])) {
  $blockuniqueclass = $attributes['uniqueClass'];
} else {
  $blockuniqueclass = 'blockspare-posts-block-list-' . $unq_class;
}

$block_class = 'blockspare-posts-block-is-grid has-gutter-' . $attributes['gutterSpace'] . ' column-' . $attributes['columns'];
$design = $attributes['grid'];
$blockName = 'post-grid';
$layoutClass = false;
if ($attributes['grid'] != 'blockspare-posts-block-grid-layout-4' && $attributes['grid'] != 'blockspare-posts-block-grid-layout-5' && $attributes['grid'] != 'blockspare-posts-block-grid-layout-6') {
  $layoutClass = true;
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

$class .= ' ' . $blockuniqueclass; ?>
<div class="<?php echo esc_attr($class); ?>" blockspare-animation="<?php echo esc_attr($attributes['animation']); ?>">
  <?php
  if (isset($attributes['enablePagination']) && $attributes['enablePagination']) {
    wp_enqueue_script('block_pagination_script');
  }
  latest_posts_style_control_grid($blockuniqueclass, $attributes);
  blockspare_query_loop_and_wrapper($attributes, $block_class, $design, $blockName, '', $layoutClass);
  ?>
</div>
<?php
