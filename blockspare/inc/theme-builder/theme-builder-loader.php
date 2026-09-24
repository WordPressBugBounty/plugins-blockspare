<?php


defined('ABSPATH') || exit;

defined('BLOCKSPARE_TB_VERSION') || define('BLOCKSPARE_TB_VERSION', '0.1.0');
defined('BLOCKSPARE_TB_PATH') || define('BLOCKSPARE_TB_PATH', BLOCKSPARE_PLUGIN_DIR . 'inc/theme-builder/');
defined('BLOCKSPARE_TB_URL') || define('BLOCKSPARE_TB_URL', BLOCKSPARE_PLUGIN_URL . 'inc/theme-builder/');
defined('BLOCKSPARE_TB_BASENAME') || define('BLOCKSPARE_TB_BASENAME', BLOCKSPARE_PLUGIN_BASE);


$blockspare_tb_files = array(
  // Post type + taxonomy.
  'class-blockspare-tb-post-type.php',
  'class-blockspare-tb-taxonomy.php',

  // Conditions engine.
  'class-blockspare-tb-condition-interface.php',
  'conditions/class-blockspare-tb-condition-entire-site.php',
  'conditions/class-blockspare-tb-condition-front-page.php',
  'conditions/class-blockspare-tb-condition-single.php',
  'conditions/class-blockspare-tb-condition-archive.php',
  'conditions/class-blockspare-tb-condition-category.php',
  'conditions/class-blockspare-tb-condition-author.php',
  'conditions/class-blockspare-tb-condition-tag.php',
  'conditions/class-blockspare-tb-condition-date-archive.php',
  'conditions/class-blockspare-tb-condition-search.php',
  'conditions/class-blockspare-tb-condition-404.php',
  'class-blockspare-tb-condition-registry.php',

  // Admin.
  'class-blockspare-tb-admin-menu.php',
  'class-blockspare-tb-assets.php',

  // Frontend.
  'class-blockspare-tb-template-loader.php',

  // REST.
  'class-blockspare-tb-templates-controller.php',
  'class-blockspare-tb-conditions-controller.php',

  // Orchestrator — must load last, it references all of the above.
  'class-blockspare-tb-plugin.php',
);

foreach ($blockspare_tb_files as $blockspare_tb_file) {
  require_once BLOCKSPARE_TB_PATH . $blockspare_tb_file;
}
unset($blockspare_tb_files, $blockspare_tb_file);


add_action('plugins_loaded', array('Blockspare_TB_Plugin', 'instance'));

register_activation_hook(
  BLOCKSPARE_BASE_FILE,
  function () {
    $post_type = new Blockspare_TB_Template_Post_Type();
    $post_type->register();

    $taxonomy = new Blockspare_TB_Template_Type_Taxonomy();
    $taxonomy->register();

    flush_rewrite_rules();
  }
);

register_deactivation_hook(
  BLOCKSPARE_BASE_FILE,
  function () {
    flush_rewrite_rules();
  }
);

add_filter('admin_url', function ($url, $path, $blog_id) {
  //blockspare_template
  if ($path === 'post-new.php?post_type=blockspare_template') {
    return admin_url('admin.php?page=blockspare-theme-builder');
  }

  return $url;
}, 10, 3);
