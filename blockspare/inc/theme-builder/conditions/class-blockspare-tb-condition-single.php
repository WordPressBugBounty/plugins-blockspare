<?php

/**
 * Matches single post/page/CPT views.
 *
 * @package Blockspare
 */

defined('ABSPATH') || exit;

class Blockspare_TB_Condition_Single implements Blockspare_TB_Condition_Interface
{

	public function get_slug()
	{
		return 'single';
	}

	public function get_label()
	{
		return __('Single Post/Page', 'blockspare');
	}

	/**
	 * Settings support an optional 'post_type' key, e.g. ['post_type' => 'post'].
	 * This is how we support "Single Post" and "Single Page" and future
	 * custom post types (like WooCommerce Products) with the same class,
	 * instead of writing a near-duplicate class per post type.
	 */
	public function is_match($settings)
	{
		if (! is_singular()) {
			return false;
		}

		if (! empty($settings['post_type'])) {
			return is_singular(sanitize_key($settings['post_type']));
		}

		return true;
	}
}
