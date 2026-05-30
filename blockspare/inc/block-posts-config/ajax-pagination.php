<?php
function bs_load_more()
{


  check_ajax_referer('blockspare-load-more-nonce', 'nonce');
  $bs_attributes = $_GET['postData'];
  $paged = $_GET['bspage'];
  $block_name = $_GET['blockName'];
  $updated_current_page = $paged + 1;
  $layoutClass = $_GET['layoutClass'];

  if (isset($bs_attributes['categories']) && ! empty($bs_attributes['categories']) && is_array($bs_attributes['categories'])) {
    $categories = array();
    $i = 1;
    foreach ($bs_attributes['categories'] as $key => $value) {
      $categories[] = $value['value'];
    }
  } else {
    $categories = array();
  }

  if (isset($bs_attributes['tags']) && ! empty($bs_attributes['tags']) && is_array($bs_attributes['tags'])) {
    $tags = array();
    $i = 1;
    foreach ($bs_attributes['tags'] as $key => $value) {
      $tags[] = $value['value'];
    }
  } else {
    $tags = array();
  }

  /* Setup the query */

  $query_args = array(
    'posts_per_page' => $bs_attributes['postsToShow'],
    'post_status' => 'publish',
    'offset' => ($bs_attributes['enablePagination'] == 'true') ? '' : $bs_attributes['offset'],
    'order' => $bs_attributes['order'],
    'orderby' => $bs_attributes['orderBy'],
    'post_type' => $bs_attributes['postType'],
    'paged' => $paged
  );
  //wp_send_json_success($query_args);die;
  if ('post' != $bs_attributes['postType']) {

    $tax_type =  $bs_attributes['taxType'];
    if ($tax_type) {
      if (!empty($categories)) {
        $query_args['tax_query'][] = array(
          'taxonomy' => (isset($tax_type)) ? $tax_type : 'category',
          'field'    => 'id',
          'terms'    => $categories,
          'operator' =>  'IN',
        );
      }
    }
  }

  if ('post' == $bs_attributes['postType']) {

    $tax_type =  $bs_attributes['taxType'];
    if ($tax_type) {
      if (!empty($categories)) {
        $query_args['tax_query'][] = array(
          'taxonomy' => (isset($tax_type)) ? $tax_type : 'category',
          'field'    => 'id',
          'terms'    => $categories,
          'operator' =>  'IN',
        );
      } else {

        $taxonomy = $tax_type; // this is the name of the taxonomy
        $terms = get_terms($taxonomy);
        if (!empty($terms)) {
          $query_args['tax_query'][] = array(
            'taxonomy' => (isset($tax_type)) ? $tax_type : 'category',
            'field' => 'slug',
            'terms' => wp_list_pluck($terms, 'slug')

          );
        }
      }
    }
  }
  if ($bs_attributes['taxType'] == 'category') {
    $query_args['category__in']  = $categories;
  }
  if ($bs_attributes['taxType'] == 'post_tag') {
    $query_args['tag__in']  = $tags;
  }


  // if($bs_attributes['taxType'] !='category' && $bs_attributes['taxType'] != 'post_tag'){

  //     $tax_type = $bs_attributes['taxType'];
  //     if ( $tax_type ) {
  //         $query_args['tax_query'][] = array(
  //             'taxonomy' => ( isset( $tax_type ) ) ? $tax_type : 'category',
  //             'field'    => 'id',
  //             'terms'    => $categories,
  //             'operator' =>  'IN' ,
  //         );
  //     }
  // }
  /* Setup the query */
  $grid_query = new WP_Query($query_args);

  ob_start();
  while ($grid_query->have_posts()) {
    $grid_query->the_post();

    /* Setup the post ID */
    $post_id = get_the_ID();


    /* Setup the featured image ID */
    $post_thumb_id = get_post_thumbnail_id($post_id);

    $has_img_class = '';

    if (!$post_thumb_id) {
      $has_img_class = "post-has-no-image ";
    }

    if (isset($bs_attributes['full'])) {
      if ($bs_attributes['full'] == 'blockspare-posts-block-full-layout-4') {
        $bs_attributes['enableEqualHeight'] = false;
      }
    }


    if ($bs_attributes['enableEqualHeight']) {
      $has_img_class .= 'bs-has-equal-height';
    }
    $post_classes = '';
    $contentOrderClass = '';
    if ($block_name = 'tile') {
      if ($bs_attributes['contentOrder'] == 'content-order-1') {
        $contentOrderClass .= 'contentorderone';
      }
      if ($bs_attributes['contentOrder'] == 'content-order-2') {
        $contentOrderClass .= 'contentordertwo';
      }
    } else {
      if ($bs_attributes['contentOrder'] == 'content-order-5') {
        $contentOrderClass .= 'contentorderfive';
      }
      if ($bs_attributes['contentOrder'] == 'content-order-6') {
        $contentOrderClass .= 'contentordersix';
      }
      if ($bs_attributes['enableEqualHeight']) {
        $contentOrderClass .= 'bs-has-equal-height';
      }
      if ($bs_attributes['enableBackgroundColor']) {
        $post_classes .= ' has-background';
      }
    }

    /* Setup the post classes */
    $post_classes = 'blockspare-posts-block-post-single blockspare-hover-item ' . $contentOrderClass;

    $className = '';
    if (isset($bs_attributes['full'])) {
      if ($bs_attributes['full'] == 'blockspare-posts-block-full-layout-6') {
        $post_classes .= ' blockspare-hover-child';
        $className .= 'hover-child';
      }
    }


    /* Add sticky class */
    if (is_sticky($post_id)) {
      $post_classes .= ' sticky';
    } else {
      $post_classes .= null;
    }
    if ($layoutClass) {
      $post_classes .= ' has-background';
    } else {
      $post_classes .= ' blockspare-hover-child';
    }
    $category_class = 'blockspare-posts-block-post-category';

    if ($bs_attributes['categoryLayoutOption'] == 'none') {
      $category_class .= ' has-no-category-style';
    }
    if (!empty($bs_attributes['imageSize'])) {
      $post_thumb_size = $bs_attributes['imageSize'];
    }

    $blockName =  $_GET['blockName'];

?>

    <?php if ($blockName  === 'post-tile-masonry' || $blockName  === 'post-grid-masonry') { ?>
      <div class="blockspare-posts-masonry-item-wrapper masonry-brick">

      <?php }

      ?>
      <div id="<?php echo esc_attr($post_id); ?>" class="<?php echo esc_attr($post_classes) . ' ' . $has_img_class; ?>">
        <?php

        if ($blockName  == 'tile' || $blockName == 'post-tile-masonry') {


          blockspare_post_tile_img($post_id, $category_class, $bs_attributes, $post_thumb_id, $post_thumb_size);
          blockspare_post_tile_content($bs_attributes, $post_id, $category_class, $className);
        } else if ($blockName  == 'express') {

          blockspare_express_post_image($bs_attributes, $post_id, $category_class, 'express', $className, 5);
          blockspare_express_post_content($bs_attributes, $post_id, $category_class, 'express', $className, 5);
        } else if ($blockName  == 'express-post-list') {

          blockspare_express_list_post_image($bs_attributes, $post_id, $category_class, 'express', $className, 5);
          blockspare_express_list_post_content($bs_attributes, $post_id, $category_class, 'express', $className, 5);
        } else {

          blockspare_post_image($bs_attributes, $post_id, $category_class, $blockName, $bs_attributes['enableFeatureImage']);
          blockspare_post_content($bs_attributes, $post_id, $category_class, $blockName, $className);
        }
        ?>
      </div>
      <?php if ($blockName  == 'tile' || $blockName  == 'post-grid-masonry') { ?>
      </div>
    <?php } ?>
<?php }



  $maxpages = $_GET['maxnumpages'];
  if ($maxpages > $paged) {
    $blockspare_output['more_post'] = true;
  } else {
    $blockspare_output['more_post'] = false;
  }
  $blockspare_output['current_page'] = $updated_current_page;
  $blockspare_output['content'][] = ob_get_clean();
  wp_send_json_success($blockspare_output);

  wp_die();
}

add_action('wp_ajax_bs_load_more', 'bs_load_more');
add_action('wp_ajax_nopriv_bs_load_more', 'bs_load_more');
