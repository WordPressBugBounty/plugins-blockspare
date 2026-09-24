<?php

/**
 * Matches the site's configured front page (static or latest posts).
 *
 * @package Blockspare
 */

defined('ABSPATH') || exit;

class Blockspare_TB_Condition_Front_Page implements Blockspare_TB_Condition_Interface
{

	public function get_slug()
	{
		return 'front_page';
	}

	public function get_label()
	{
		return __('Front Page', 'blockspare');
	}

	public function is_match($settings)
	{
		return is_front_page();
	}
}
