<?php
if (!function_exists('blockspare_checkalignment')) {
  function blockspare_checkalignment($alignment = '', $attributes = '')
  {
    $align_class = $alignment == '' ? 'center' : $alignment;
    $align_class .= ' ' . blockspare_visibility_classes($attributes);
    return trim($align_class);
  }
}

function blockspare_visibility_classes($attributes)
{
  $classes = [];

  if (!empty($attributes['hideOnDesktop'])) {
    $classes[] = 'blockspare-hide-frontend-desktop';
  }
  if (!empty($attributes['hideOnTablet'])) {
    $classes[] = 'blockspare-hide-frontend-tablet';
  }
  if (!empty($attributes['hideOnMobile'])) {
    $classes[] = 'blockspare-hide-frontend-mobile';
  }

  return implode(' ', $classes);
}

function blockspare_minify_css($css)
{

  // Remove comments
  $css = preg_replace('!/\*.*?\*/!s', '', $css);
  // Remove whitespace
  $css = preg_replace('/\s+/', ' ', $css);
  // Remove space around symbols
  $css = str_replace([' {', '{ '], '{', $css);
  $css = str_replace([' }', '} '], '}', $css);
  $css = str_replace([' ;', '; '], ';', $css);
  $css = str_replace([' :', ': '], ':', $css);
  $css = str_replace([' ,', ', '], ',', $css);
  return trim($css);
}

function blockspare_visibility_css($attributes, $blockuniqueclass)
{
  $css = '';

  if (!empty($attributes['hideOnDesktop'])) {
    $css .= '@media (min-width: 1025px) {';
    $css .= '.' . $blockuniqueclass . '.blockspare-hide-frontend-desktop {';
    $css .= 'display: none !important;';
    $css .= '}}';
  }

  if (!empty($attributes['hideOnTablet'])) {
    $css .= '@media (min-width: 768px) and (max-width: 1024px) {';
    $css .= '.' . $blockuniqueclass . '.blockspare-hide-frontend-tablet {';
    $css .= 'display: none !important;';
    $css .= '}}';
  }

  if (!empty($attributes['hideOnMobile'])) {
    $css .= '@media (max-width: 767px) {';
    $css .= '.' . $blockuniqueclass . '.blockspare-hide-frontend-mobile {';
    $css .= 'display: none !important;';
    $css .= '}}';
  }

  return $css;
}

add_action('wp_ajax_blockspare_templatespare_plugin_installer_activation', 'blockspare_templatespare_plugin_installer_activation');

function blockspare_templatespare_plugin_installer_activation()
{

  if (! current_user_can('install_plugins'))
    wp_die(__('Sorry, you are not allowed to install plugins on this site.', 'blockspare'));


  $nonce = $_POST["nonce"];

  // Check our nonce, if they don't match then bounce!
  if (! wp_verify_nonce($nonce, 'aft_installer_nonce'))
    wp_die(__('Error - unable to verify nonce, please try again.', 'blockspare'));

  $install = isset($_POST['install']) ? $_POST['install'] : '';
  $activate = isset($_POST['activate']) ? $_POST['activate'] : '';
  $page =  isset($_POST['page']) ? $_POST['page'] : '';
  if (is_array($install)) {
    $sanitinzed_plugins = array_map('sanitize_key', $install);
  } else {
    $sanitinzed_plugins = sanitize_key($install);
  }
  $is_active = 'false';
  if (is_array($activate)) {
    $is_active = 'true';
    $sanitinzed_activate = array_map('sanitize_key', $activate);
  } else {
    $is_active = 'true';
    $sanitinzed_activate = array(sanitize_key($activate));
  }



  // Include required libs for installation
  require_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
  require_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');
  require_once(ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php');
  require_once(ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php');
  $data = [];
  // Get Plugin Info
  if (!empty($sanitinzed_plugins)) {
    foreach ($sanitinzed_plugins as $pl) {
      $api = plugins_api(
        'plugin_information',
        array(
          'slug' => $pl,
          'fields' => array(
            'short_description' => false,
            'sections' => false,
            'requires' => false,
            'rating' => false,
            'ratings' => false,
            'downloaded' => false,
            'last_updated' => false,
            'added' => false,
            'tags' => false,
            'compatibility' => false,
            'homepage' => false,
            'donate_link' => false,
          ),
        )
      );

      $skin     = new WP_Ajax_Upgrader_Skin();
      $upgrader = new Plugin_Upgrader($skin);

      $upgrader->install($api->download_link);


      if ($api->name) {
        $status = 'success';
        $msg = $api->name . ' successfully installed.';
      } else {
        $status = 'failed';
        $msg = 'There was an error installing ' . $api->name . '.';
      }
      array_push($sanitinzed_activate, $pl);
    }
    $json = array(
      'status' => 'success',
      'url' => site_url() . '/wp-admin/admin.php?page=' . $page
    );
  }

  $list_of_plugins = array_merge($sanitinzed_activate, $sanitinzed_activate);
  $list_of_plugins  = array_filter($sanitinzed_activate, 'strlen');

  if (!empty($list_of_plugins)) {
    $data =  blockspare_activate_plugin_list($sanitinzed_activate);
  }

  if ($data == 'success') {

    $json = array(
      'status' => 'success',
      'url' => site_url() . '/wp-admin/admin.php?page=' . $page
    );
    return wp_send_json($json);
  }
}
function blockspare_activate_plugin_list($sanitinzed_activate)
{
  $count = 0;
  $total = count($sanitinzed_activate);
  foreach ($sanitinzed_activate as $plugin) {

    // Tell TemplateSpare to skip Freemius during this AJAX activation.
    if (! defined('BLOCKSPARE_AJAX_ACTIVATION')) {
      define('BLOCKSPARE_AJAX_ACTIVATION', true);
    }

    $count++;
    if ($plugin == 'blockspare-pro') {
      //deactivate_plugins('blockspare/blockspare.php', '',false, true);
      activate_plugin('blockspare-pro/blockspare.php', '', false, true);
    } else if (!is_plugin_active($plugin . '/' . $plugin . '.php')) {
      activate_plugin($plugin . '/' . $plugin . '.php', '', false, true);
    }
  }

  return "success";
}
