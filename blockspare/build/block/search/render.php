<?php
$unq_class = mt_rand(100000, 999999);
$blockuniqueclass = '';

if (!empty($attributes['uniqueClass'])) {
  $blockuniqueclass = $attributes['uniqueClass'];
} else {
  $blockuniqueclass = 'blockspare-posts-block-list-' . $unq_class;
}

$mainClass = $blockuniqueclass;
$mainClass .= ' ' . $attributes['blockHoverEffect'];

$wrapClass = 'bs-search-wrapper bs-grid-' . $attributes['sectionAlign'];
$toggleClass = 'bs-search-' . $attributes['sectionAlign'];
if ($attributes['searchStyle'] == "icon" && $attributes['iconOption'] == "dropdown") {
  $toggleClass .= ' bs-search-dropdown-toggle';
}
if ($attributes['searchStyle'] == "icon" && $attributes['iconOption'] == "overlay") {
  $toggleClass .= ' bs-site-search-toggle';
}
if ($attributes['searchStyle'] == "form") {
  $toggleClass .= ' bs-search-form-header';
}
if ($attributes['animation']) {
  $toggleClass .= ' blockspare-block-animation ' . $attributes['animation'];
}

$iconClass = 'bs-search-icon--toggle blockspare-hover-item blockspare-hover-text ' . $attributes['searchIcon'];
$alignclass = blockspare_checkalignment($attributes['align'], $attributes);



?>
<div class="<?php echo esc_attr($mainClass); ?> align<?php echo esc_attr($alignclass) ?>">
  <?php echo  search_style_control($blockuniqueclass, $attributes); ?>
  <section class="<?php echo esc_attr($wrapClass); ?>">
    <div class="<?php echo esc_attr($toggleClass); ?>">
      <?php if ($attributes['searchStyle'] == "icon") { ?>
        <button class="<?php echo esc_attr($iconClass); ?>">
          <span class="screen-reader-text">
            <?php echo esc_html__('Enter Keyword', 'blockspare'); ?>
          </span>
        </button>
        <?php if ($attributes['iconOption'] == "dropdown") { ?>
          <div class="bs-search--toggle-dropdown">
            <div class="bs-search--toggle-dropdown-wrapper">
              <?php echo blockspare_search_html($attributes); ?>
            </div>
          </div>
        <?php } ?>
      <?php } ?>
      <?php if ($attributes['searchStyle'] == "form") { ?>
        <div class="bs-search-form--wrapper">
          <?php echo blockspare_search_html($attributes); ?>
        </div>
      <?php } ?>
    </div>
    <?php if ($attributes['searchStyle'] == "icon" && $attributes['iconOption'] == "overlay") { ?>
      <div class="bs-search--toggle">
        <div class="bs-search-toggle--wrapper">
          <?php echo blockspare_search_html($attributes); ?>
        </div>
        <button class="bs--site-search-close fas fa-times">
          <span class="screen-reader-text"> <?php echo esc_html__('Close', 'blockspare'); ?></span>
        </button>
      </div>
    <?php } ?>
  </section>
</div>
<?php
