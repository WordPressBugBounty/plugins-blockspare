<?php

/**
 * Create API fields for additional info
 */
if (!function_exists('blockspare_post_register_rest_fields')) {
  function blockspare_post_register_rest_fields()
  {

    register_rest_field(
      'post',
      'featured_image_urls',
      array(
        'get_callback' => 'blockspare_featured_image_urls',
        'update_callback' => null,
        'schema' => array(
          'description' => __('Different sized featured images', 'blockspare'),
          'type' => 'array',
        ),
      )
    );

    // Excer

    /* Add author info */
    register_rest_field(
      'post',
      'author_info',
      array(
        'get_callback' => 'blockspare_get_author_infos',
        'update_callback' => null,
        'schema' => null,
      )
    );

    /* Add author info */
    register_rest_field(
      'post',
      'category_info',
      array(
        'get_callback' => 'blockspare_get_category_infos',
        'update_callback' => null,
        'schema' => null,
      )
    );

    /* Add author info */
    register_rest_field(
      'post',
      'tag_info',
      array(
        'get_callback' => 'blockspare_get_tag_infos',
        'update_callback' => null,
        'schema' => null,
      )
    );

    register_rest_field(
      'post',
      'comment_count',
      array(
        'get_callback' => 'blockspare_get_comment_count',
        'update_callback' => null,
        'schema' => null,
      )
    );
  }

  add_action('rest_api_init', 'blockspare_post_register_rest_fields');
}


/**
 * Get author info for the rest field
 *
 * @param String $object The object type.
 * @param String $field_name Name of the field to retrieve.
 * @param String $request The current request object.
 */
if (!function_exists('blockspare_get_author_infos')) {
  function blockspare_get_author_infos($object, $field_name, $request)
  {
    if (!isset($object['author']))
      return;

    global $post;
    $author_id = get_post_field('post_author', $object['author']);
    $blocspare = new BlocksapreMultiAuthorForBackend();
    $author_data = $blocspare->blockspare_by_author($post);

    // return  $author_id;
    /* Get the author name */
    // $author_data['display_name'] = get_the_author_meta('display_name', $object['author']);

    /* Get the author link */
    // $author_data['author_link'] = get_author_posts_url($object['author']);

    /* Return the author data */
    return $author_data;
  }
}
if (!function_exists('blockspare_get_category_infos')) {
  function blockspare_get_category_infos($object, $field_name, $request)
  {
    return get_the_category_list(' ', '', $object['id']);
  }
}

if (!function_exists('blockspare_get_tag_infos')) {
  function blockspare_get_tag_infos($object, $field_name, $request)
  {

    ob_start();
    $cate_name = '';
    if (!empty($object)) {
      foreach ($object['categories'] as $cat_id) {
        $cate_name = get_cat_name($cat_id);
      }
    }
    ob_clean();
    return $cate_name;
  }
}

if (!function_exists('blockspare_get_comment_count')) {
  function blockspare_get_comment_count($object, $field_name, $reques)
  {

    return  get_comments_number($object['id']);
  }
}

if (!function_exists('blockspare_featured_image_urls')) {
  /**
   * Get the different featured image sizes that the blog will use.
   * Used in the custom REST API endpoint.
   *
   * @since 1.7
   */
  function blockspare_featured_image_urls($object, $field_name, $request)
  {
    return blockspare_featured_image_urls_from_url(!empty($object['featured_media']) ? $object['featured_media'] : '');
  }
}


if (!function_exists('blockspare_featured_image_urls_from_url')) {
  /**
   * Get the different featured image sizes that the blog will use.
   *
   * @since 2.0
   */
  function blockspare_featured_image_urls_from_url($attachment_id)
  {

    $image = wp_get_attachment_image_src($attachment_id, 'full', false);
    $sizes = get_intermediate_image_sizes();

    $imageSizes = array(
      'full' => is_array($image) ? $image : '',
    );

    foreach ($sizes as $size) {
      $imageSizes[$size] = is_array($image) ? wp_get_attachment_image_src($attachment_id, $size, false) : '';
    }

    return $imageSizes;
  }
}
