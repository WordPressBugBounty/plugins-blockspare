<?php

/**
 * Registers the plugin's top-level admin page.
 *
 * @package Blockspare
 */

defined('ABSPATH') || exit;


class Blockspare_TB_Admin_Menu
{

  const PAGE_SLUG = 'blockspare-theme-builder';

  /**
   * Registers the menu.
   */
  public function blocksspare_builder_register()
  {
    $badge_count = __('New', 'blockspare'); // Dynamic count variable
    add_submenu_page(
      'blockspare',                     // Parent Slug (The slug of your main Blockspare menu)
      __('Site Builder', 'blockspare'), // Page Title
      sprintf(
        __('Site Builder %s', 'blockspare'),
        '<span class="update-plugins count-' . esc_attr($badge_count) . '"><span class="plugin-count">' . esc_html($badge_count) . '</span></span>'
      ),
      'edit_pages',                     // Capability
      self::PAGE_SLUG,                  // Submenu Slug
      array($this, 'render'),          // Callback Function
      1
    );
  }

  /**
   * Renders the mount point. All real content is rendered by React.
   */
  public function render()
  {
    echo '<div id="blocksparetb-app" class="blocksparetb-app"></div>';
  }
}
