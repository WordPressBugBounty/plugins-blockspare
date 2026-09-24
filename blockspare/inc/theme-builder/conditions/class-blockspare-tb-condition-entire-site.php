<?php

/**
 * Matches every request. Used as the "apply everywhere" catch-all.
 *
 * @package Blockspare
 */

defined('ABSPATH') || exit;

class Blockspare_TB_Condition_Entire_Site implements Blockspare_TB_Condition_Interface
{

	public function get_slug()
	{
		return 'entire_site';
	}

	public function get_label()
	{
		return __('Entire Site', 'blockspare');
	}

	public function is_match($settings)
	{
		return true;
	}
}
