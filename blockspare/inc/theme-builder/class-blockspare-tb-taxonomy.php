<?php

/**
 * Registers the `blockspare_template_type` taxonomy.
 *
 * @package Blockspare
 */

defined('ABSPATH') || exit;


class Blockspare_TB_Template_Type_Taxonomy
{

  const SLUG = 'blockspare_template_type';


  const TYPES = array(
    'header'     => 'Header',
    'footer'     => 'Footer',
    'front_page' => 'Front Page',
    'single'     => 'Singular',
    'archive'    => 'Archive',
    'search'     => 'Search Results',
    'category'   => 'Category',
    'author'     => 'Author',
    'tag'        => 'Tag',
    'date'       => 'Date Archive',
    '404'        => '404 Page',
  );

  /**
   * Registers the taxonomy and seeds its terms.
   */
  public function register()
  {
    register_taxonomy(
      self::SLUG,
      Blockspare_TB_Template_Post_Type::SLUG,
      array(
        'labels'       => array(
          'name'          => __('Template Types', 'blockspare'),
          'singular_name' => __('Template Type', 'blockspare'),
        ),
        'public'       => false,
        'show_ui'      => false, // Managed programmatically, not by users, to keep it in sync with the 
        'show_in_rest' => true,
        'hierarchical' => false,
      )
    );

    $this->seed_terms();
  }


  private function seed_terms()
  {
    foreach (self::TYPES as $slug => $label) {
      $slug = (string) $slug;

      if (! term_exists($slug, self::SLUG)) {
        wp_insert_term($label, self::SLUG, array('slug' => $slug));
      }
    }
  }
}
