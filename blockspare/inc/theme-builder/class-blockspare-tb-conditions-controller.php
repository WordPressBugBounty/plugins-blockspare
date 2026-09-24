<?php

defined('ABSPATH') || exit;


class Blockspare_TB_Conditions_Controller extends WP_REST_Controller
{

  protected $namespace = 'stbldr/v1';
  protected $rest_base = 'conditions';

  /**
   * @var Blockspare_TB_Condition_Registry
   */
  private $registry;

  /**
   * @param Blockspare_TB_Condition_Registry $registry Shared condition registry.
   */
  public function __construct(Blockspare_TB_Condition_Registry $registry)
  {
    $this->registry = $registry;
  }

  public function register_routes()
  {
    register_rest_route(
      $this->namespace,
      '/' . $this->rest_base,
      array(
        array(
          'methods'             => WP_REST_Server::READABLE,
          'callback'            => array($this, 'get_items'),
          'permission_callback' => array($this, 'get_items_permissions_check'),
        ),
      )
    );
  }

  /**
   * Only users who can edit templates need to know what conditions exist.
   */
  public function get_items_permissions_check($request)
  {
    return current_user_can('edit_pages');
  }

  public function get_items($request)
  {
    $items = array();

    foreach ($this->registry->all() as $condition) {
      $items[] = array(
        'slug'  => $condition->get_slug(),
        'label' => $condition->get_label(),
      );
    }

    return rest_ensure_response($items);
  }
}
