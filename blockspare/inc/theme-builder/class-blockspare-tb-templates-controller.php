<?php


defined('ABSPATH') || exit;

class Blockspare_TB_Templates_Controller extends WP_REST_Posts_Controller
{

  const ALLOWED_CONDITION_TYPES = array(
    'entire_site',
    'front_page',
    'single',
    'archive',
    'category',
    'author',
    'tag',
    'date_archive',
    'search',
    '404',
    // ... add the rest of your real types here
  );

  public function __construct()
  {
    parent::__construct(Blockspare_TB_Template_Post_Type::SLUG);
  }

  /**
   * Registers routes (parent's CRUD routes) plus our custom meta fields.
   */
  public function register_routes()
  {
    parent::register_routes();
    $this->register_condition_fields();
  }


  public function get_items_permissions_check($request)
  {
    return current_user_can('edit_pages');
  }

  public function get_item_permissions_check($request)
  {
    return current_user_can('edit_pages');
  }

  /**
   * Shared write-permission check.
   */
  private function can_edit_post($post)
  {
    return current_user_can('edit_post', $post->ID);
  }

  private function permission_error()
  {
    return new WP_Error(
      'stbldr_rest_cannot_edit',
      __('Sorry, you are not allowed to edit this template.', 'blockspare'),
      array('status' => rest_authorization_required_code())
    );
  }

  private function read_permission_error()
  {
    return new WP_Error(
      'stbldr_rest_cannot_read',
      __('Sorry, you are not allowed to view this template.', 'blockspare'),
      array('status' => rest_authorization_required_code())
    );
  }

  private function register_condition_fields()
  {
    register_rest_field(
      Blockspare_TB_Template_Post_Type::SLUG,
      'conditions',
      array(
        'get_callback'    => function ($post) {

          if (! current_user_can('edit_pages')) {
            return $this->read_permission_error();
          }

          $raw     = get_post_meta($post['id'], '_stbldr_conditions', true);
          $decoded = $raw ? json_decode($raw, true) : null;
          return is_array($decoded) ? $decoded : array(
            'include' => array(),
            'exclude' => array(),
          );
        },
        'update_callback' => function ($value, $post) {
          if (! $this->can_edit_post($post)) {
            return $this->permission_error();
          }

          $sanitized = $this->sanitize_conditions_payload($value);
          update_post_meta($post->ID, '_stbldr_conditions', wp_json_encode($sanitized));
          return true;
        },
        'schema'          => array(
          'description' => __('Include/exclude display condition rules.', 'blockspare'),
          'type'        => 'object',
        ),
      )
    );

    register_rest_field(
      Blockspare_TB_Template_Post_Type::SLUG,
      'priority',
      array(
        'get_callback'    => function ($post) {
          if (! current_user_can('edit_pages')) {
            return $this->read_permission_error();
          }

          $value = get_post_meta($post['id'], '_stbldr_priority', true);
          return '' === $value ? 10 : (int) $value;
        },
        'update_callback' => function ($value, $post) {
          if (! $this->can_edit_post($post)) {
            return $this->permission_error();
          }

          update_post_meta($post->ID, '_stbldr_priority', absint($value));
          return true;
        },
        'schema'          => array(
          'description' => __('Lower number = higher priority when multiple templates match.', 'blockspare'),
          'type'        => 'integer',
        ),
      )
    );
  }

  private function sanitize_conditions_payload($value)
  {
    $value = is_array($value) ? $value : array();

    $clean = array(
      'include' => array(),
      'exclude' => array(),
    );

    foreach (array('include', 'exclude') as $bucket) {
      foreach ((array) (isset($value[$bucket]) ? $value[$bucket] : array()) as $rule) {
        if (! is_array($rule) || empty($rule['type'])) {
          continue;
        }

        $type = sanitize_key($rule['type']);

        if (! in_array($type, self::ALLOWED_CONDITION_TYPES, true)) {
          continue;
        }

        $settings = array();
        foreach ((array) (isset($rule['settings']) ? $rule['settings'] : array()) as $key => $val) {
          if (is_array($val)) {
            continue;
          }

          if (is_bool($val)) {
            $settings[sanitize_key($key)] = $val;
          } elseif (is_numeric($val)) {
            $settings[sanitize_key($key)] = absint($val);
          } else {
            $settings[sanitize_key($key)] = sanitize_text_field((string) $val);
          }
        }

        $clean[$bucket][] = array(
          'type'     => $type,
          'settings' => $settings,
        );
      }
    }

    return $clean;
  }
}
