<?php
$unq_class = mt_rand(100000, 999999);
$blockuniqueclass = '';

if (!empty($attributes['uniqueClass'])) {
  $blockuniqueclass = $attributes['uniqueClass'];
} else {
  $blockuniqueclass = 'blockspare-posts-block-list-' . $unq_class;
}

$block_class = 'blockspare-posts-block-is-full';
$design = $attributes['full'];

$blockName = 'full';

$layoutClass = true;

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
  latest_posts_style_control_full($blockuniqueclass, $attributes);
  blockspare_query_loop_and_wrapper($attributes, $block_class, $design, $blockName, '', $layoutClass);
  ?>
</div>
<?php
