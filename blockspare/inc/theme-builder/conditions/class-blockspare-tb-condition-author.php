<?php

/**
 * Matches author archive views, optionally a specific author.
 *
 * @package Blockspare
 */

defined('ABSPATH') || exit;

class Blockspare_TB_Condition_Author implements Blockspare_TB_Condition_Interface
{

	public function get_slug()
	{
		return 'author';
	}

	public function get_label()
	{
		return __('Author Archive', 'blockspare');
	}

	public function is_match($settings)
	{
		if (! empty($settings['user_id'])) {
			return is_author(absint($settings['user_id']));
		}

		return is_author();
	}
}
