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



if ($attributes['numberofSlide'] > 3) {
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
  'slidesToShow' => 1,
  'centerMode' => $centermode,
  'responsive' => array(
    array(
      'breakpoint' => 900,
      'settings' => array(
        'slidesToShow' => $responsivelayoutTab,
        'slidesToScroll' => 1,
        'infinite' => true,
        'centerMode' => false,
      ),
    ),
    array(
      'breakpoint' => 600,
      'settings' => array(
        'slidesToShow' => $responsivelayoutTab,
        'slidesToScroll' => 1,
        'centerMode' => false,
      ),
    ),
    array(
      'breakpoint' => 480,
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
  $class = "wp-block-blockspare-posts-block-blockspare-posts-block-latest-posts align" . $alignclass . " " . $attributes['blockHoverEffect'] . " " . $attributes['imageHoverEffect'] . " " . $blockuniqueclass;

  if (isset($attributes['className'])) {
    $class .= ' ' . $attributes['className'];
  }
  if ($attributes['enableBoxShadow']) {
    $class .= ' bs-has-shadow';
  }
  $list_layout_class = $attributes['slider'];


  $hoverNavClass = '';
  if ($attributes['enableNavInHover']) {
    $hoverNavClass = 'nav-on-hover';
  }
  //$list_layout_class = $attributes['design'];
  $listgridClass = 'blockspare-posts-block-is-carousel' . " blockspare-posts-block-carousel-full " . "column-" . $attributes['columns'] . ' ' . $attributes['navigationSize'] . ' ' . $attributes['navigationShape'] . ' ' . $hoverNavClass;
  $animation_class  = '';
  if ($attributes['animation']) {
    $animation_class = 'blockspare-block-animation';
  }

  /* Layout orientation class */
  $grid_class = 'blockspare-posts-block-latest-post-carousel-wrap ' . ' '  . $listgridClass . ' ' . $list_layout_class . ' has-gutter-space-' . $attributes['gutterSpace'] . ' ' . $animation_class;

  $category_class = 'blockspare-posts-block-post-category';

  if ($attributes['categoryLayoutOption'] == 'none') {
    $category_class .= ' has-no-category-style';
  }

?>

  <div class="<?php echo esc_attr($class); ?>">
    <?php echo latest_posts_style_control_slider($blockuniqueclass, $attributes); ?>
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
            $post_classes = 'blockspare-posts-block-post-single blockspare-hover-item ' . $contentOrderClass . " " . $attributes['contentOrder'];

            if ($attributes['enableEqualHeight']) {
              $post_classes .= ' bs-has-equal-height';
            }

            if ($attributes['slider'] == 'blockspare-posts-block-full-layout-6') {
              $post_classes .= ' blockspare-hover-child';
            }

            /* Add sticky class */
            if (is_sticky($post_id)) {
              $post_classes .= ' sticky';
            } else {
              $post_classes .= null;
            }



            if ($attributes['enableBackgroundColor']) {
              $post_classes .= ' has-background';
            }

          ?>

            <div id="<?php echo esc_attr($post_id); ?>"
              class="<?php echo esc_attr($post_classes) . ' ' . $has_img_class; ?>">
              <?php

              if (!empty($attributes['imageSize'])) {
                $post_thumb_size = $attributes['imageSize'];
              } ?>


              <figure class="blockspare-posts-block-post-img hover-child">
                <a href="<?php echo esc_url(get_permalink($post_id)); ?>" aria-label="<?php echo esc_attr(get_the_title($post_id)); ?>">
                  <?php
                  if (has_post_thumbnail($post_id)) {
                    echo wp_kses_post(wp_get_attachment_image($post_thumb_id, $post_thumb_size));
                  } else { ?>
                    <div class="bs-no-thumbnail-img"> </div>
                  <?php  } ?>
                </a>
                <?php
                if ($attributes['displayPostCategory']) { ?>
                  <div class="<?php echo esc_attr($category_class); ?>">
                    <?php
                    /*  if($attributes['postType']=='post'){
                                        $categories_list = get_the_category_list(' ', '', $post_id);
                                            if ( $categories_list ) {
                                                       
                                                    printf(  esc_html__( '%1$s', 'blockspare' ), $categories_list ); // WPCS: XSS OK.
                                                }
                                }
                                if($attributes['postType']!='post'){
                                        $terms = get_the_terms($post_id , $attributes['taxType'] );
                                            if($terms){
                                                    foreach($terms  as $trem){?>
                                                                <a herf= ><?php echo $trem->name; ?></a> 
                                                            <?php }
                                                        }
                                } */
                    blockspare_get_cat_tax_tags($attributes['taxType'], $post_id, $attributes['postType']);
                    ?>
                  </div>

                <?php } ?>
              </figure>

              <div
                class="blockspare-posts-block-post-content hover-child <?php echo esc_attr($attributes['contentOrder']); ?> <?php echo esc_attr($attributes['titleOnHover']) ?>">
                <div class="blockspare-posts-block-bg-overlay"></div>
                <header class="blockspare-posts-block-post-grid-header">
                  <?php
                  if ($attributes['displayPostCategory']) {  ?>
                    <div class="<?php echo esc_attr($category_class); ?>">
                      <?php
                      /* if($attributes['postType']=='post'){
                                        $categories_list = get_the_category_list(' ', '', $post_id);
                                            if ( $categories_list ) {
                                                           
                                                    printf(  esc_html__( '%1$s', 'blockspare' ), $categories_list ); // WPCS: XSS OK.
                                                }
                                }
                                if($attributes['postType']!='post'){
                                        $terms = get_the_terms($post_id , $attributes['taxType'] );
                                            if($terms){
                                                    foreach($terms  as $trem){?>
                                                                <a herf= ><?php echo $trem->name; ?></a> 
                                                            <?php }
                                                        }
                                }
                                */
                      blockspare_get_cat_tax_tags($attributes['taxType'], $post_id, $attributes['postType']);
                      ?>
                    </div>
                  <?php }
                  $title = get_the_title($post_id);
                  if (!$title) {
                    $title = __('Untitled', 'blockspare');
                  } ?>
                  <h2 class="blockspare-posts-block-post-grid-title">
                    <a href="<?php echo esc_url(get_permalink($post_id)); ?>"
                      class="blockspare-posts-block-title-link" rel="bookmark">
                      <span><?php echo ($title); ?></span></a>
                  </h2>

                  <?php
                  if (isset($attributes['postType']) && (isset($attributes['displayPostAuthor']) || isset($attributes['displayPostDate']))) { ?>
                    <div class="blockspare-posts-block-post-grid-byline">
                      <?php
                      if (isset($attributes['displayPostAuthor']) && $attributes['displayPostAuthor']) { ?>
                        <div class="blockspare-posts-block-post-grid-author">
                          <?php
                          $author_id = get_post_field('post_author', $post_id);
                          $blockspare_get_multiauthor =  new BlocksapreMultiAuthorForFrontend();
                          $blockspare_get_multiauthor->blockspare_front_by_author($post_id, $attributes['authorIcon'], $author_id);
                          ?>
                        </div>
                      <?php }

                      if (isset($attributes['displayPostDate']) && $attributes['displayPostDate']) { ?>
                        <time datetime="<?php echo esc_attr(get_the_date('c', $post_id)); ?>" class="blockspare-posts-block-post-grid-date" itemprop="datePublished"><i class="<?php echo esc_attr($attributes['dateIcon']); ?>" aria-hidden="true"></i><?php echo esc_html(get_the_date('', $post_id)); ?></time>
                      <?php }

                      if ($attributes['enableComment']) { ?>
                        <span class="comment_count"><i class='<?php echo esc_attr($attributes['commentIcon']); ?>' aria-hidden="true"></i><?php echo esc_html(get_comments_number($post_id)); ?></span>
                      <?php } ?>
                    </div>

                  <?php } ?>

                </header>

                <?php
                /* Get the excerpt */

                $excerpt = get_post_field(
                  'post_excerpt',
                  $post_id,
                  'display'
                );

                if (empty($excerpt)) {
                  $excerpt = preg_replace(
                    array(
                      '/\<figcaption>.*\<\/figcaption>/',
                      '/\[caption.*\[\/caption\]/',
                    ),
                    '',
                    get_the_content()
                  );
                }

                // Trim the excerpt if necessary.
                if (isset($attributes['excerptLength'])) {
                  $excerpt = wp_trim_words(
                    $excerpt,
                    $attributes['excerptLength']
                  );
                }

                // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- This is a WP core filter.
                $excerpt = apply_filters('the_excerpt', $excerpt);
                if ($attributes['displayPostExcerpt'] && $excerpt != null) { ?>
                  <div class="blockspare-posts-block-post-grid-excerpt">
                    <?php if (isset($attributes['displayPostExcerpt']) && $attributes['displayPostExcerpt']) { ?>
                      <div class="blockspare-posts-block-post-grid-excerpt-content"><?php echo wp_kses_post($excerpt); ?>
                      </div>
                    <?php } ?>


                    <?php

                    if (isset($attributes['displayPostLink']) && $attributes['displayPostLink']) { ?>
                      <p>
                        <a
                          class="blockspare-posts-block-post-grid-more-link blockspare-posts-block-text-link"
                          href="<?php echo esc_url(get_permalink($post_id)); ?>"
                          aria-label="<?php echo sprintf(esc_attr__('Read more about %s', 'blockspare'), esc_html(get_the_title($post_id))); ?>">
                          <span aria-hidden="true"><?php echo esc_html($attributes['readMoreText']); ?></span>
                        </a>

                      </p>

                    <?php } ?>
                  </div>
                <?php } ?>
              </div>

            </div>
          <?php } ?>
        </div>
      </div>
    </section>
  </div>
<?php }
