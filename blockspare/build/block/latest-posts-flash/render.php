<?php
$unq_class = mt_rand(100000, 999999);
$blockuniqueclass = '';

if (!empty($attributes['uniqueClass'])) {
  $blockuniqueclass = $attributes['uniqueClass'];
} else {
  $blockuniqueclass = 'blockspare-posts-block-list-' . $unq_class;
}



if (isset($attributes['categories']) && ! empty($attributes['categories']) && is_array($attributes['categories'])) {
  $categories = array();
  $i = 1;
  foreach ($attributes['categories'] as $key => $value) {
    $categories[] = $value['value'];
  }
} else {
  $categories = array();
}

if (isset($attributes['tags']) && ! empty($attributes['tags']) && is_array($attributes['tags'])) {
  $tags = array();
  $i = 1;
  foreach ($attributes['tags'] as $key => $value) {
    $tags[] = $value['value'];
  }
} else {
  $tags = array();
}

/* Setup the query */

$query_args = array(
  'posts_per_page' => $attributes['postsToShow'],
  'post_status' => 'publish',
  'order' => $attributes['order'],
  'orderby' => $attributes['orderBy'],
  'offset' => $attributes['offset'],
  'post_type' => $attributes['postType'],
  'ignore_sticky_posts' => 1,
);

if ($attributes['taxType'] == 'category') {
  $query_args['category__in']  = $categories;
}
if ($attributes['taxType'] == 'post_tag') {
  $query_args['tag__in']  = $tags;
}


if ($attributes['taxType'] != 'category' && $attributes['taxType'] != 'post_tag') {

  $tax_type = $attributes['taxType'];
  if ($tax_type) {
    $query_args['tax_query'][] = array(
      'taxonomy' => (isset($tax_type)) ? $tax_type : 'category',
      'field'    => 'id',
      'terms'    => $categories,
      'operator' =>  'IN',
    );
  }
}

$grid_query = new WP_Query($query_args);



$responsivelayoutTab = 1;
$responsivelayoutMobile = 1;
$verticals = false;

if ($attributes['carouselType'] == 'vertical') {
  $verticals = true;
}






/* Start the loop */
if ($grid_query->have_posts()) {
  $alignclass = blockspare_checkalignment($attributes['align'], $attributes);
  /* Build the block classes */
  $class = 'align' . $alignclass;

  if (isset($attributes['class'])) {
    $class .= ' ' . $attributes['class'];
  }
  if ($attributes['animation']) {
    $class .= ' blockspare-block-animation ' . $attributes['animation'];
  }




  //$list_layout_class = $attributes['trending'];
  $listgridClass = 'blockspare-posts-block-is-carousel';

  /* Layout orientation class */
  $block_post_wrap = $blockuniqueclass . '  blockspare-posts-block-post-wrap';
  $count = 0;
  $layout_class = 'bs-flash-wrap flash-layout ' . $attributes['layoutStyle'];

  if ($attributes['fixedWidth']) {
    $layout_class .= ' has-fixed-width';
  }

  $exclusive_posts = 'bs-exclusive-posts blockspare-hover-item';
  if ($attributes['border']) {
    $exclusive_posts .= ' bs-border-enabled bs-' . $attributes['borderStyle'];
  } else {
    $exclusive_posts .= ' bs-border-disabled';
  }
  $flash_spiner_class = 'bs-spinner ';
  if ($attributes['spinnerOption'] == 'spinner-option-1') {
    $flash_spiner_class .= $attributes['spinnerStyle'];
  } else {
    $flash_spiner_class .= $attributes['animationStyle'];
  }
  $spinner_icon = $attributes['spinnerIcon'];
  $marquee_class = 'bs-marquee bs-flash-side ' . $attributes['direction'];
  if ($attributes['pauseOnHover']) {
    $marquee_class .= ' pause-on-hover';
  }
?>

  <div class="<?php echo esc_attr($class); ?> <?php echo esc_attr($attributes['blockHoverEffect']) ?>">
    <?php latest_posts_style_control_flash($blockuniqueclass, $attributes); ?>
    <section class="<?php echo esc_attr($block_post_wrap); ?>">
      <div class="<?php echo esc_attr($layout_class); ?>">
        <div class="<?php echo esc_attr($exclusive_posts); ?>">
          <div class="bs-exclusive-now">
            <?php if ($attributes['exclusiveSubtitle']) { ?>
              <span class="bs-exclusive-news-title"><span><?php echo esc_html($attributes['exclusiveSubtitleText']); ?></span></span>
            <?php } ?>
            <div class="bs-exclusive-now-txt-animation-wrap">
              <?php if ($attributes['spinner']) { ?>
                <span class="<?php echo esc_attr($flash_spiner_class); ?>">
                  <?php if ($attributes['spinnerOption'] == 'spinner-option-1') { ?>
                    <?php if ($attributes['spinnerStyle'] != 'spinner-style-4') { ?>
                      <div class="ring"></div>
                      <div class="ring"></div>
                      <div class="ring"></div>
                      <div class="ring"></div>
                    <?php } else { ?>
                      <div class="ring"></div>
                      <div class="ring"></div>
                      <div class="ring"></div>
                      <div class="ring"></div>
                    <?php } ?>
                  <?php } else { ?>
                    <i class="<?php echo esc_attr($spinner_icon); ?>" aria-hidden="true"></i>
                  <?php } ?>
                </span>
              <?php } ?>
              <span class="bs-exclusive-texts-wrapper">
                <?php echo $attributes['exclusiveText'] != "" ?  $attributes['exclusiveText'] : "Breaking News"; ?>
              </span>
            </div>
          </div>
          <div class="bs-exclusive-slides">
            <div class="<?php echo esc_attr($marquee_class); ?>">
              <div class="bs-marquee-wrapper">
                <?php while ($grid_query->have_posts()) {
                  $grid_query->the_post();

                  $count++;

                  /* Setup the post ID */
                  $post_id = get_the_ID();

                  /* Setup the featured image ID */
                  $post_thumb_id = get_post_thumbnail_id($post_id);


                  /* Setup the post classes */
                  $post_classes = 'bs-post-title ';

                ?>

                  <h2 class="<?php echo esc_attr($post_classes) ?>">
                    <?php

                    if (!empty($attributes['imageSize'])) {
                      $post_thumb_size = 'thumbnail   ';
                    } ?>
                    <a href="<?php echo esc_url(get_permalink($post_id)); ?>" rel="bookmark">
                      <span class="bs-circle-marq">
                        <?php if ($attributes['enableCount']) { ?>
                          <span class="bs-trending-no"><?php echo esc_html($count); ?></span>
                        <?php } ?>
                        <?php
                        if (has_post_thumbnail($post_id)) {
                          echo wp_kses_post(wp_get_attachment_image($post_thumb_id, $post_thumb_size));
                        } else { ?>
                          <div class="bs-no-thumbnail-img"> </div>
                        <?php  } ?>
                      </span>
                      <span class="bs-post-title">
                        <?php
                        $title = get_the_title($post_id);

                        if (!$title) {
                          $title = __('Untitled', 'blockspare');
                        }

                        echo ($title);
                        ?>
                      </span>
                    </a>
                  </h2>
                <?php } ?>
              </div>
              <div class="bs-marquee-wrapper">
                <?php while ($grid_query->have_posts()) {
                  $grid_query->the_post();

                  $count++;

                  /* Setup the post ID */
                  $post_id = get_the_ID();

                  /* Setup the featured image ID */
                  $post_thumb_id = get_post_thumbnail_id($post_id);


                  /* Setup the post classes */
                  $post_classes = 'bs-post-title ';

                ?>

                  <h2 class="<?php echo esc_attr($post_classes) ?>">
                    <?php

                    if (!empty($attributes['imageSize'])) {
                      $post_thumb_size = 'thumbnail   ';
                    } ?>
                    <a href="<?php echo esc_url(get_permalink($post_id)); ?>" rel="bookmark">
                      <span class="bs-circle-marq">
                        <?php if ($attributes['enableCount']) { ?>
                          <span class="bs-trending-no"><?php echo esc_html($count); ?></span>
                        <?php } ?>
                        <?php
                        if (has_post_thumbnail($post_id)) {
                          echo wp_kses_post(wp_get_attachment_image($post_thumb_id, $post_thumb_size));
                        } else { ?>
                          <div class="bs-no-thumbnail-img"> </div>
                        <?php  } ?>
                      </span>
                      <span class="bs-post-title">
                        <?php
                        $title = get_the_title($post_id);

                        if (!$title) {
                          $title = __('Untitled', 'blockspare');
                        }

                        echo ($title);
                        ?>
                      </span>
                    </a>
                  </h2>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
<?php }
