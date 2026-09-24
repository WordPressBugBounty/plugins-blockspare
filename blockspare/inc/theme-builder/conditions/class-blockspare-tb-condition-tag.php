<?php

/**
 * Matches tag archive views, optionally a specific tag.
 *
 * @package Blockspare
 */

defined('ABSPATH') || exit;

class Blockspare_TB_Condition_Tag implements Blockspare_TB_Condition_Interface
{

	public function get_slug()
	{
		return 'tag';
	}

	public function get_label()
	{
		return __('Tag Archive', 'blockspare');
	}

	public function is_match($settings)
	{
		if (! empty($settings['term_id'])) {
			return is_tag(absint($settings['term_id']));
		}

		return is_tag();
	}
}
