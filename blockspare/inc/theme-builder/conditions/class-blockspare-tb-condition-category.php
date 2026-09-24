<?php

/**
 * Matches category archive views, optionally a specific category.
 *
 * @package Blockspare
 */

defined('ABSPATH') || exit;

class Blockspare_TB_Condition_Category implements Blockspare_TB_Condition_Interface
{

	public function get_slug()
	{
		return 'category';
	}

	public function get_label()
	{
		return __('Category Archive', 'blockspare');
	}

	/**
	 * Settings may include 'term_id' to scope to one specific category.
	 * Absent 'term_id' means "any category archive" — this lets the UI
	 * offer both a broad rule and a fine-grained one with the same class.
	 */
	public function is_match($settings)
	{
		if (! empty($settings['term_id'])) {
			return is_category(absint($settings['term_id']));
		}

		return is_category();
	}
}
