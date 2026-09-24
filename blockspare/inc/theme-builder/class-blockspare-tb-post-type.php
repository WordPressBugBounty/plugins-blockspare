<?php

/**
 * Registers the `blockspare_template` custom post type.
 *
 * @package Blockspare
 */

defined('ABSPATH') || exit;


class Blockspare_TB_Template_Post_Type
{


  const SLUG = 'blockspare_template';

  /**
   * Registers the post type on `init`.
   */
  public function register()
  {
    register_post_type(
      self::SLUG,
      array(
        'labels'                => $this->labels(),
        'public'                => false, // Templates are never viewed directly at a public URL.
        'show_ui'               => true,
        'show_in_menu'          => false, // We build our own top-level admin page instead (see Blockspare_TB_Admin_Menu).
        'show_in_rest'          => true,
        'rest_base'             => 'blocksparetb-templates',
        'rest_controller_class' => 'Blockspare_TB_Templates_Controller',
        'supports'              => array(
          'title',
          'editor',
          'revisions',
          'custom-fields',
          'author'
        ),
        'capability_type'       => 'page',
        'map_meta_cap'          => true,
        'hierarchical'          => false,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'query_var'             => false,
        'rewrite'               => false,
      )
    );
    $post_type = get_post_type_object(self::SLUG);

    add_filter('rest_pre_dispatch', array($this, 'blockspare_limit_free_user_templates'), 10, 3);
  }
  /**
   * Restricts template creation via REST API to a maximum of 2 for free users.
   */
  public function blockspare_limit_free_user_templates($result, $server, $request)
  {
    // Match POST requests to the blocksparetb-templates REST endpoint
    if ('/wp/v2/blocksparetb-templates' === $request->get_route() && 'POST' === $request->get_method()) {

      $is_pro_user = apply_filters('blockspare_is_pro_user', false);

      if (!$is_pro_user) {
        $published_templates = wp_count_posts(self::SLUG);
        $total_templates     = isset($published_templates->publish) ? (int)$published_templates->publish : 0;

        if ($total_templates >= 2) {
          return new WP_Error(
            'template_limit_reached',
            __('Free users can only create up to 2 templates. Upgrade to Pro to create more.', 'blockspare'),
            array('status' => 403)
          );
        }
      }
    }

    return $result;
  }

  /**
   * Human-readable labels for the post type.
   *
   * @return array
   */
  private function labels()
  {
    return array(
      'name'          => __('Theme Templates', 'blockspare'),
      'singular_name' => __('Theme Template', 'blockspare'),
      'add_new_item'  => __('Add New Template', 'blockspare'),
      'edit_item'     => __('Edit Template', 'blockspare'),
      'all_items'     => __('All Templates', 'blockspare'),
      'search_items'  => __('Search Templates', 'blockspare'),
      'not_found'     => __('No templates found.', 'blockspare'),
    );
  }
}
