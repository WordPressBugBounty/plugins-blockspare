<?php

/**
 * Matches the 404 (not found) view.
 *
 * @package Blockspare
 */

defined('ABSPATH') || exit;

class Blockspare_TB_Condition_404 implements Blockspare_TB_Condition_Interface
{

	public function get_slug()
	{
		return '404';
	}

	public function get_label()
	{
		return __('404 Page', 'blockspare');
	}

	public function is_match($settings)
	{
		return is_404();
	}
}
