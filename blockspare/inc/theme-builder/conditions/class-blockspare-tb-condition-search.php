<?php

/**
 * Matches search results pages.
 *
 * @package Blockspare
 */

defined('ABSPATH') || exit;

class Blockspare_TB_Condition_Search implements Blockspare_TB_Condition_Interface
{

	public function get_slug()
	{
		return 'search';
	}

	public function get_label()
	{
		return __('Search Results', 'blockspare');
	}

	public function is_match($settings)
	{
		return is_search();
	}
}
