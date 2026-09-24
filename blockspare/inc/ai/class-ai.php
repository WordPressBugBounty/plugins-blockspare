<?php

if (! defined('ABSPATH')) {
  exit;
}

require_once BLOCKSPARE_PLUGIN_DIR . 'inc/ai/class-blockspare-ai-settings.php';
require_once BLOCKSPARE_PLUGIN_DIR . 'inc/ai/class-blockspare-ai-rest-api.php';

/**
 * Bootstraps the AI content generation feature: wires the settings
 * screen and the REST API endpoint together.
 */
class Blockspare_AI_Content_Generator
{

  /**
   * @var Blockspare_AI_Settings
   */
  private $settings;

  /**
   * @var Blockspare_AI_REST_API
   */
  private $rest_api;


  public function __construct()
  {
    $this->settings = new Blockspare_AI_Settings();
    $this->rest_api = new Blockspare_AI_REST_API($this->settings);
  }
}

new Blockspare_AI_Content_Generator();
