<?php
$unq_class = mt_rand(100000, 999999);
$blockuniqueclass = '';

if (!empty($attributes['uniqueClass'])) {
  $blockuniqueclass = $attributes['uniqueClass'];
} else {
  $blockuniqueclass = 'blockspare-posts-block-list-' . $unq_class;
}

$desingParmeter = '';
if ($attributes['trendingBackground']) {
  $desingParmeter = $attributes['bannerNineLayout'];
} else {
  $desingParmeter = 'blockspare-hover-child';
}

$numOfSlides = 4;
if ($attributes['align'] == 'center' || $attributes['align'] == '') {
  $numOfSlides = 3;
}
$alignclass = blockspare_checkalignment($attributes['align'], $attributes);
$animation_class = '';
if ($attributes['animation']) {
  $animation_class = 'blockspare-block-animation';
}

?>
<div class='<?php echo esc_attr($blockuniqueclass); ?> align<?php echo esc_attr($alignclass) ?>'>
  <?php
  $blockName = 'blockspare-banner-9';
  blockspare_banner_nine_control_slider($attributes, $blockuniqueclass, $blockName);
  ?>
  <div class='<?php echo esc_attr($animation_class) ?> blockspare-banner-wrapper blockspare-banner-9-main-wrapper <?php echo esc_attr($attributes['bannerNineLayout']) ?> <?php echo esc_attr($attributes['blockHoverEffect']) ?> <?php echo esc_attr($attributes['imageHoverEffect']) ?>' blockspare-animation="<?php echo esc_attr($attributes['animation']) ?>">


    <div class='blockspare-banner-col-wrap'>
      <?php
      blockspare_get_slider_template($attributes);
      blocspare_get_editor_template($attributes, '2', 'banner-9');
      blocspare_get_vertical_trending_template($attributes, $desingParmeter, $numOfSlides);
      ?>

    </div>
  </div>
</div>
<?php
