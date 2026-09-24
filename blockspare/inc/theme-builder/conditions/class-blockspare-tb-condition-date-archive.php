<?php

/**
 * Matches date-based archive views (year/month/day).
 *
 * @package Blockspare
 */

defined('ABSPATH') || exit;

class Blockspare_TB_Condition_Date_Archive implements Blockspare_TB_Condition_Interface
{

  public function get_slug()
  {
    return 'date_archive';
  }

  public function get_label()
  {
    return __('Date Archive', 'blockspare');
  }

  public function is_match($settings)
  {
    return is_date();
  }
}
