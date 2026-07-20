<?php

if (! defined('ABSPATH')) {
  exit;
}

class Blockspare_Block_Manager
{

  /**
   * Option key for disabled blocks.
   */
  private $option_key = 'blockspare_disabled_blocks';

  public function __construct()
  {
    add_filter(
      'rest_request_after_callbacks',
      [$this, 'rest_request_after_callbacks'],
      10,
      3
    );

    add_filter(
      'allowed_block_types_all',
      [$this, 'filter_blocks'],
      10,
      2
    );

    add_action(
      'rest_api_init',
      [$this, 'register_rest_routes']
    );
  }

  /**
   * Get all Blockspare blocks.
   */
  public function get_all_blocks()
  {
    $pattern = BLOCKSPARE_PLUGIN_DIR . 'build/block/*/block.json';
    $files   = glob($pattern);

    $blocks = [];

    foreach ($files as $file) {
      $json = file_get_contents($file);
      $data = json_decode($json, true);

      if (
        isset($data['name']) &&
        strpos($data['name'], 'blockspare/') === 0
      ) {
        $blocks[] = $data['name'];
      }
    }

    sort($blocks);

    return $blocks;
  }

  /**
   * Get disabled blocks.
   */
  public function get_disabled_blocks()
  {
    return get_option(
      $this->option_key,
      []
    );
  }

  /**
   * Save disabled blocks.
   */
  private function save_disabled_blocks($blocks)
  {
    update_option(
      $this->option_key,
      $blocks
    );
  }

  /**
   * Register REST routes.
   */
  public function register_rest_routes()
  {
    register_rest_route(
      'blockspare/v1',
      '/disabled-blocks',
      [
        'methods'             => 'POST',
        'callback'            => [$this, 'save_disabled_blocks_rest'],
        'permission_callback' => function () {
          return current_user_can('manage_options');
        },
      ]
    );
  }

  /**
   * Save disabled blocks via REST.
   */
  public function save_disabled_blocks_rest($request)
  {
    $blocks = $request->get_param('blocks');

    if (! is_array($blocks)) {
      $blocks = [];
    }

    $blocks = array_map(
      'sanitize_text_field',
      $blocks
    );

    $this->save_disabled_blocks(
      $blocks
    );

    return rest_ensure_response(
      [
        'success' => true,
      ]
    );
  }

  /**
   * Remove disabled blocks from editor.
   */
  public function filter_blocks(
    $allowed_blocks,
    $editor_context
  ) {
    $disabled = $this->get_disabled_blocks();

    if ($allowed_blocks === true) {
      $registry = WP_Block_Type_Registry::get_instance();

      $allowed_blocks = array_keys(
        $registry->get_all_registered()
      );
    }

    $filtered = [];

    foreach ($allowed_blocks as $block) {

      if (
        is_object($block) &&
        isset($block->name)
      ) {
        $name = $block->name;
      } elseif (is_string($block)) {
        $name = $block;
      } else {
        continue;
      }

      // Keep non-blockspare blocks.
      if (
        strpos($name, 'blockspare/') !== 0
      ) {
        $filtered[] = $block;
        continue;
      }

      // Skip disabled blocks.
      if (
        in_array(
          $name,
          $disabled,
          true
        )
      ) {
        continue;
      }

      $filtered[] = $block;
    }

    return $filtered;
  }

  /**
   * Filter block types endpoint.
   */
  public function rest_request_after_callbacks(
    $response,
    $handler,
    $request
  ) {
    if (
      ! $request ||
      strpos(
        $request->get_route(),
        '/wp/v2/block-types'
      ) === false
    ) {
      return $response;
    }

    $disabled = $this->get_disabled_blocks();

    if (
      ! method_exists(
        $response,
        'get_data'
      )
    ) {
      return $response;
    }

    $data = $response->get_data();

    // Single block response.
    if (isset($data['name'])) {
      if (
        in_array(
          $data['name'],
          $disabled,
          true
        )
      ) {
        return new WP_REST_Response(
          null,
          404
        );
      }

      return $response;
    }

    // Collection response.
    $data = array_values(
      array_filter(
        $data,
        function ($block) use ($disabled) {
          if (! isset($block['name'])) {
            return true;
          }

          $name = $block['name'];

          if (
            strpos(
              $name,
              'blockspare/'
            ) !== 0
          ) {
            return true;
          }

          return ! in_array(
            $name,
            $disabled,
            true
          );
        }
      )
    );

    $response->set_data($data);

    return $response;
  }
}

global $blockspare_block_manager;
$blockspare_block_manager = new Blockspare_Block_Manager();
