<?php

defined('ABSPATH') || exit;


final class Blockspare_TB_Plugin
{

  /**
   * The single instance of this class.
   *
   * @var Blockspare_TB_Plugin|null
   */
  private static $instance = null;

  /**
   * Condition registry, shared across REST + frontend rendering.
   *
   * @var Blockspare_TB_Condition_Registry
   */
  public $conditions;

  /**
   * Get (and lazily create) the single Plugin instance.
   *
   * @return Blockspare_TB_Plugin
   */
  public static function instance()
  {
    if (null === self::$instance) {
      self::$instance = new self();
      self::$instance->setup();
    }

    return self::$instance;
  }
  private function __construct() {}


  private function setup()
  {
    // Condition engine must exist before REST + Frontend, both depend on it.
    $this->conditions = new Blockspare_TB_Condition_Registry();
    $this->conditions->register_core_conditions();

    add_action('init', array(new Blockspare_TB_Template_Post_Type(), 'register'));
    add_action('init', array(new Blockspare_TB_Template_Type_Taxonomy(), 'register'));

    $conditions = $this->conditions;
    add_action(
      'rest_api_init',
      function () use ($conditions) {
        (new Blockspare_TB_Templates_Controller())->register_routes();
        (new Blockspare_TB_Conditions_Controller($conditions))->register_routes();
      }
    );

    if (is_admin()) {
      $admin_menu = new Blockspare_TB_Admin_Menu();
      add_action('admin_menu', array($admin_menu, 'blocksspare_builder_register'));

      $assets = new Blockspare_TB_Assets();
      add_action('admin_enqueue_scripts', array($assets, 'blocksspare_builder_enqueue'));
      add_action('enqueue_block_editor_assets', array($assets, 'blocksspare_builder_enqueue_editor'));
    }


    (new Blockspare_TB_Template_Loader($this->conditions))->init();
  }

  /**
   * Prevent cloning of the instance (Singleton integrity).
   */
  private function __clone() {}

  /**
   * Prevent unserializing of the instance (Singleton integrity).
   */
  public function __wakeup()
  {
    throw new Exception('Cannot unserialize a singleton.');
  }
}
