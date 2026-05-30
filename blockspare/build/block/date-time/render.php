<?php

$unq_class = mt_rand(100000, 999999);
$blockuniqueclass = '';
if (!empty($attributes['uniqueClass'])) {
  $blockuniqueclass = $attributes['uniqueClass'];
} else {
  $blockuniqueclass = 'blockspare-date-time-' . $unq_class;
}

$wrapperClass = $blockuniqueclass;
$mainClass = $attributes['layoutOption'] . ' ' . $attributes['layoutType'] . ' ' . $attributes['dateOrder'] . ' bs-date-time-' . $attributes['sectionAlign'] . ' ';
$mainClass .= $attributes['borderRadius'];
if ($attributes['animation']) {
  $mainClass .= ' blockspare-block-animation ';
} else {
  $mainClass .= ' ';
}
$mainClass .= $attributes['animation'] . ' ' . $attributes['blockHoverEffect'];

$separator = ',';

$alignclass = blockspare_checkalignment($attributes['align'], $attributes);

$dateClass = 'bs-date-time bs-date-wrapper blockspare-hover-item';
if ($attributes['layoutOption'] == 'date-time-style-1') {
  $dateClass .= ' blockspare-hover-text ';
}

$timeClass = 'bs-date-time bs-time-wrapper blockspare-hover-item';
if ($attributes['layoutOption'] == 'date-time-style-1') {
  $timeClass .= ' blockspare-hover-text ';
}
$date_format =  date_i18n(get_option('date_format'), current_time('timestamp'));
?>

<div class="<?php echo esc_attr($wrapperClass); ?> align<?php echo esc_attr($alignclass) ?>">
  <?php echo blockspare_date_time_style_control($blockuniqueclass, $attributes); ?>
  <div class="bs-date-time-widget <?php echo esc_attr($mainClass); ?>" bs-isenabled="<?php echo esc_attr($attributes['time']); ?>" bs-format="<?php echo esc_html($date_format); ?>">
    <?php if ($attributes['date']) { ?>
      <div class="<?php echo esc_attr($dateClass); ?>">
        <?php if ($attributes['dateIconToggle']) { ?>
          <div class='bs-icon-wrapper'>
            <i class="bs-date-icon <?php echo esc_attr($attributes['dateIcon']); ?>" aria-hidden="true"></i>
          </div>
        <?php } ?>

        <div class="bs-date">
          <?php if ($attributes['textBeforeDate'] != '') { ?>
            <span class="bs-before-date-text">
              <?php echo esc_html($attributes['textBeforeDate']); ?>
            </span>
          <?php } ?>

          <time class="bs-date-text" datetime="2025-10-27" aria-label="<?php echo esc_attr($date_format); ?>">
            <?php echo esc_html($date_format); ?>
          </time>
          <?php if ($attributes['textAfterDate'] != '') { ?>
            <span class="bs-after-date-text">
              <?php echo esc_html($attributes['textAfterDate']); ?>
            </span>
          <?php } ?>
        </div>
      </div>
    <?php } ?>

    <div class="<?php echo esc_attr($timeClass); ?>" bs-isenabled="<?php echo esc_attr($attributes['time']); ?>" bs-format="<?php echo esc_html($date_format); ?>" id="bs-date-time">
      <?php

      if ($attributes['time']) {
        if ($attributes['timeIconToggle']) { ?>
          <div class="bs-icon-wrapper">
            <i class="bs-time-icon <?php echo esc_attr($attributes['timeIcon']) ?>" aria-hidden="true"></i>
          </div>
      <?php }
      } ?>
      <span class="bs-time-text"></span>
    </div>


  </div>
</div>
<?php
