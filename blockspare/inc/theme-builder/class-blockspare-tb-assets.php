<?php

defined('ABSPATH') || exit;

class Blockspare_TB_Assets
{


  public function blocksspare_builder_enqueue($hook_suffix)
  {

    $expected_hook = get_plugin_page_hookname(Blockspare_TB_Admin_Menu::PAGE_SLUG, 'blockspare');

    if ($hook_suffix !== $expected_hook) {
      return;
    }  // Hide WordPress admin notices on Site Builder page.
    remove_all_actions('admin_notices');
    remove_all_actions('all_admin_notices');


    $this->enqueue_bundle('blocksparetb-admin', 'builder');
    // Check if the user is a Pro user
    $is_pro = apply_filters('blockspare_is_pro_user', false);
    wp_localize_script(
      'blocksparetb-admin',
      'stbldrData',
      array(
        'restUrl'     => esc_url_raw(rest_url('wp/v2/blocksparetb-templates')),
        'restRootUrl' => esc_url_raw(rest_url('blocksparetb/v1')),
        'nonce'       => wp_create_nonce('wp_rest'),
        'types'       => $this->get_type_terms(),
        'adminUrl'    => esc_url_raw(admin_url('post.php')),
        'sitebarIcon'    => BLOCKSPARE_PLUGIN_URL . 'assets/icons',
        'isPro'       => $is_pro,
        'proLink' => admin_url('admin.php?page=blockspare-pricing'),
      )
    );
  }

  private function get_type_terms()
  {
    $types = array();

    foreach (Blockspare_TB_Template_Type_Taxonomy::TYPES as $slug => $label) {
      $slug = (string) $slug; // See the matching note in Blockspare_TB_Template_Type_Taxonomy::seed_terms().
      $term = get_term_by('slug', $slug, Blockspare_TB_Template_Type_Taxonomy::SLUG);

      $types[$slug] = array(
        'id'    => $term ? (int) $term->term_id : 0,
        'label' => $label,
      );
    }

    return $types;
  }


  public function blocksspare_builder_enqueue_editor()
  {
    $screen = get_current_screen();

    if (! $screen || Blockspare_TB_Template_Post_Type::SLUG !== $screen->post_type) {
      return;
    }

    $this->enqueue_bundle('blocksparetb-editor', 'builder_editor');
  }


  private function enqueue_bundle($handle, $bundle)
  {

    $js_path = BLOCKSPARE_PLUGIN_DIR . "dist/{$bundle}.js";

    if (! file_exists($js_path)) {
      add_action(
        'admin_notices',
        function () use ($bundle) {
          printf(
            '<div class="notice notice-error"><p>%s</p></div>',
            esc_html(
              sprintf(
                /* translators: %s: bundle name, e.g. "builder" or "builder_editor" */
                __('Blockspare Site Builder: run `npm install && npm run build` in the plugin directory to compile the "%s" bundle.', 'blockspare'),
                $bundle
              )
            )
          );
        }
      );
      return;
    }

    $version = (string) filemtime($js_path);

    wp_enqueue_script(
      $handle,
      BLOCKSPARE_PLUGIN_URL . "dist/{$bundle}.js",
      $this->get_bundle_dependencies($bundle),
      $version,
      true
    );

    $css_path = BLOCKSPARE_PLUGIN_DIR . "dist/{$bundle}.css";

    if (file_exists($css_path)) {
      wp_enqueue_style(
        $handle,
        BLOCKSPARE_PLUGIN_URL . "dist/{$bundle}.css",
        array('wp-components'),
        (string) filemtime($css_path)
      );
    }
  }

  private function get_bundle_dependencies($bundle)
  {
    $common = array(
      'wp-element',
      'wp-components',
      'wp-data',
      'wp-i18n',
      'wp-api-fetch',
      'wp-url',
      'wp-compose',
      'wp-hooks',
    );

    if ('builder_editor' === $bundle) {
      // The editor panel bundle additionally needs the block-editor
      // integration packages that the dashboard bundle never touches.
      return array_merge(
        $common,
        array(
          'wp-plugins',
          'wp-edit-post',
          'wp-editor',
          'wp-block-editor',
          'wp-blocks',
          'wp-core-data',
          'wp-notices',
        )
      );
    }

    // 'builder' (the standalone dashboard) also talks to the REST
    // API for CRUD on templates, so it needs wp-core-data too.
    return array_merge($common, array('wp-core-data'));
  }
}
