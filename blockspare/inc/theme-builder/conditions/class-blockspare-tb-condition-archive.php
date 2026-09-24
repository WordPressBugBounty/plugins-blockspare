<?php

/**
 * Matches any archive view (category, tag, author, date, custom taxonomy, post type archive).
 *
 * @package Blockspare
 */

defined('ABSPATH') || exit;

class Blockspare_TB_Condition_Archive implements Blockspare_TB_Condition_Interface
{

  public function get_slug()
  {
    return 'archive';
  }

  public function get_label()
  {
    return __('Any Archive', 'blockspare');
  }

  public function is_match($settings)
  {
    return is_archive() || is_home() || is_front_page();
  }
}
