<?php
wp_enqueue_style('slick');
wp_enqueue_script('slick');
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

$next = $attributes['carouselNextIcon'];
$prevstr = str_replace("-right", "-left", $attributes['carouselNextIcon']);

$centermode =  false;

$responsivelayoutTab = 1;
$responsivelayoutMobile = 1;


if ($attributes['numberofSlide'] > 2) {
  $responsivelayoutTab = 2;
  $responsivelayoutMobile = 1;
} else {
  $responsivelayoutTab = $attributes['numberofSlide'];
}


$carousel_args = array(

  'dots' => $attributes['showDots'],
  'loop' => true,
  'autoplay' => $attributes['enableAutoPlay'],
  'speed' => $attributes['carouselSpeed'],
  'arrows' => $attributes['showsliderNextPrev'],
  'slidesToShow' => ($attributes['postListingOption'] === 'latest-posts-block-carousel-grid') ? $attributes['numberofSlide'] : 1,
  'centerMode' => $centermode,
  'responsive' => array(
    array(
      'breakpoint' => 769,
      'settings' => array(
        'slidesToShow' => $responsivelayoutTab,
        'slidesToScroll' => 1,
        'infinite' => true,
        'centerMode' => false,
      ),
    ),

    array(
      'breakpoint' => 481,
      'settings' => array(
        'slidesToShow' => $responsivelayoutMobile,
        'slidesToScroll' => 1,
        'centerMode' => false,
      ),
    ),
  ),
);
$carousel_args_encoded = wp_json_encode($carousel_args);



/* Start the loop */
if ($grid_query->have_posts()) {
  $alignclass = blockspare_checkalignment($attributes['align'], $attributes);
  /* Build the block classes */
  $class = "wp-block-blockspare-posts-block-blockspare-posts-block-latest-posts align" . $alignclass . ' ' . $attributes['blockHoverEffect'] . ' ' . $attributes['imageHoverEffect'] . ' ' . $blockuniqueclass;

  if (isset($attributes['className'])) {
    $class .= ' ' . $attributes['className'];
  }
  if ($attributes['enableBoxShadow']) {
    $class .= ' bs-has-shadow';
  }

  $list_layout_class = $attributes['grid'];


  $hoverNavClass = '';
  if ($attributes['enableNavInHover']) {
    $hoverNavClass = 'nav-on-hover';
  }
  //$list_layout_class = $attributes['design'];
  $listgridClass = 'blockspare-posts-block-is-carousel' . " " . $attributes['navigationSize'] . ' ' . $attributes['navigationShape'] . ' ' . $hoverNavClass . ' blockspare-slides-' . $attributes['numberofSlide'];

  $animation_class  = '';
  if ($attributes['animation']) {
    $animation_class = 'blockspare-block-animation';
  }


  /* Layout orientation class */
  $grid_class = 'blockspare-posts-block-latest-post-carousel-wrap  blockspare-posts-block-latest-post-wrap' . ' '  . $listgridClass . ' ' . $list_layout_class . ' has-gutter-space-' . $attributes['gutterSpace'] . " " . $attributes['postListingOption'] . ' ' . $animation_class;

  $category_class = 'blockspare-posts-block-post-category';

  if ($attributes['categoryLayoutOption'] == 'none') {
    $category_class .= ' has-no-category-style';
  }



  $enableFeatureImage = true;
  if (isset($attributes['enableFeatureImage'])) {
    $enableFeatureImage = $attributes['enableFeatureImage'];
  }
?>

  <div class="<?php echo esc_attr($class); ?>">
    <?php echo latest_posts_style_control_carousel($blockuniqueclass, $attributes); ?>
    <section class="blockspare-posts-block-post-wrap">

      <div class="<?php echo esc_attr($grid_class); ?>" blockspare-animation="<?php echo esc_attr($attributes['animation']); ?>">
        <div class="latest-post-carousel" data-slick="<?php echo esc_attr($carousel_args_encoded); ?>"
          data-next="<?php echo esc_attr($next); ?>" data-prev="<?php echo esc_attr($prevstr); ?>">
          <?php while ($grid_query->have_posts()) {
            $grid_query->the_post();

            /* Setup the post ID */
            $post_id = get_the_ID();

            /* Setup the featured image ID */
            $post_thumb_id = get_post_thumbnail_id($post_id);

            $has_img_class = '';

            if (!$post_thumb_id) {
              $has_img_class = "post-has-no-image";
            }

            $contentOrderClass = '';
            if ($attributes['contentOrder'] == 'content-order-1') {
              $contentOrderClass .= 'contentorderone';
            }
            if ($attributes['contentOrder'] == 'content-order-2') {
              $contentOrderClass .= 'contentordertwo';
            }


            /* Setup the post classes */
            $post_classes = 'blockspare-posts-block-post-single blockspare-hover-item ' . $contentOrderClass;
            if ($attributes['enableEqualHeight']) {
              $post_classes .= ' bs-has-equal-height';
            }

            $layoutclass = false;

            if ($attributes['grid'] != 'blockspare-posts-block-grid-layout-3' && $attributes['grid'] != 'blockspare-posts-block-grid-layout-4') {
              $layoutclass = true;
            }

            if ($layoutclass) {
              $post_classes .= ' has-background';
            } else {
              $post_classes .= ' blockspare-hover-child';
            }


            /* Add sticky class */
            if (is_sticky($post_id)) {
              $post_classes .= ' sticky';
            } else {
              $post_classes .= null;
            }
          ?>
            <div>
              <div id="<?php echo esc_attr($post_id); ?>" class="<?php echo esc_attr($post_classes) . ' ' . $has_img_class; ?>">
                <?php blockspare_post_image($attributes, $post_id, $category_class, $blockName = '', $count = '', $enableFeatureImage); ?>
                <?php blockspare_post_content($attributes, $post_id, $category_class); ?>
              </div>
            </div>


          <?php } ?>
        </div>
      </div>
    </section>
  </div>
<?php }
