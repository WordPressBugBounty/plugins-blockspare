<?php
$unq_class = mt_rand(100000, 999999);
$blockuniqueclass = '';

if (!empty($attributes['uniqueClass'])) {
  $blockuniqueclass = $attributes['uniqueClass'];
} else {
  $blockuniqueclass = 'blockspare-posts-block-list-' . $unq_class;
}

$mainClass = $blockuniqueclass;
if ($attributes['animation']) {
  $mainClass .= ' blockspare-block-animation ' . $attributes['animation'];
}
$mainClass .= ' ' . $attributes['blockHoverEffect'];

$wrapClass = 'bs-popular-tags-wrapper ' . $attributes['tagStyle'];
if ($attributes['primaryIconToggle'] != true) {
  $wrapClass .= ' bs-tag-without-icon-wrapper';
}

$directionClass = 'bs-popular-taxonomies-lists ' . $attributes['directionOption'];
if ($attributes['tagStyle'] != 'popular-tag-style-1') {
  $directionClass .= ' ' . $attributes['borderRadius'];
}

$primaryIconClass = 'bs-primary-icon ' . $attributes['primaryIcon'];
$secondaryIconClass = 'bs-secondary-icon ' . $attributes['tagsIcon'];
$columnClass = '';
if ($attributes['directionOption'] == 'popular-vertical' && $attributes['column'] != 'bs-column-1') {
  $columnClass .= $attributes['column'];
} else {
  $columnClass .= 'popular-vertical';
}

$alignclass = blockspare_checkalignment($attributes['align'], $attributes);

$query = array(
  'taxonomy' => $attributes['filterOption'] == 'categories' ? 'category' : 'post_tag',
  'number' => $attributes['tagsNumber'],
  'hide_empty' => false,
);

if ($attributes['orderOption'] == 'popular') {
  $query["orderby"] = 'count';
  $query["order"] = 'DESC';
}

$tags = get_terms($query);

?>
<div class="<?php echo esc_attr($mainClass); ?> align<?php echo esc_attr($alignclass) ?>">
  <?php blockspare_popular_tags_style_control($blockuniqueclass, $attributes); ?>
  <section class="<?php echo esc_attr($wrapClass); ?>">
    <div class="<?php echo esc_attr($directionClass); ?>">
      <div class="bs-popular-tags-text">
        <?php if ($attributes['primaryIconToggle']) { ?>
          <div class="bs-primary-icon-wrapper">
            <i class="<?php echo esc_attr($primaryIconClass); ?>"></i>
          </div>
        <?php } ?>
        <div class="bs-tag-title-wrapper ">
          <span class="bs-tag-title-text">
            <?php
            echo esc_html($attributes['orderOption'] . ' ' . $attributes['filterOption']);
            ?>
          </span>
        </div>
      </div>
      <ul class="<?php echo esc_attr($columnClass); ?>">
        <?php
        foreach ($tags as $tag) {
          if ($attributes['tagsIconToggle']) {
            echo '<li><span class="bs-secondry-wrap blockspare-hover-item blockspare-hover-text"> <i class="' . esc_attr($secondaryIconClass) . '"></i><span><a class="bs-tag-wrapper" href="' . get_tag_link($tag->term_id) . '" rel="tag"><span class="bs-tag-text">' . $tag->name . '</span></a></span></span></li>';
          } else {
            echo '<li><span class="bs-secondry-wrap blockspare-hover-item blockspare-hover-text"><span><a class="bs-tag-wrapper" href="' . get_tag_link($tag->term_id) . '" rel="tag"><span class="bs-tag-text">' . $tag->name . '</span></a></span></span></li>';
          }
        }
        ?>
      </ul>
    </div>

  </section>
</div>
<?php
