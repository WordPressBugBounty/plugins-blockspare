<?php


defined('ABSPATH') || exit;

interface Blockspare_TB_Condition_Interface
{

  /**
   * Unique slug for this condition, e.g. 'category', 'author'.
   *
   * @return string
   */
  public function get_slug();

  /**
   * Human-readable label for the admin UI.
   *
   * @return string
   */
  public function get_label();

  /**
   * Determines whether this condition matches the current request.
   *
   * @param array $settings Condition-specific settings, e.g. ['term_id' => 12].
   * @return bool
   */
  public function is_match($settings);
}
