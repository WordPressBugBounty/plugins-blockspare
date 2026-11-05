<?php

defined('ABSPATH') || exit;

if (!class_exists('Templatespare_Starter_Sites')) {

  class Templatespare_Starter_Sites
  {
    const templatespare_old_version = '2.3.0';
    private $theme_slug;
    private $theme_name;
    public function __construct()
    {
      $theme = wp_get_theme();
      $this->theme_name = $theme->get('Name');
      $this->theme_slug = $theme->get_template();
      $this->templatespare_render_starter_sites();
    }

    public function templatespare_render_starter_sites()
    {
      $templatespare_installed = $this->templatespare_get_plugin_file('templatespare');
      $templatespare_version = '';

      if (!empty($templatespare_installed)) {
        $plugin_data = get_plugin_data(
          WP_PLUGIN_DIR . '/' . $templatespare_installed
        );

        $templatespare_version = $plugin_data['Version'] ?? '';
      }

      $templatespare_active = is_plugin_active('templatespare/templatespare.php');

      $install = [];
      $activate = [];

      if (empty($templatespare_installed)) {
        $install = ['templatespare'];
      } elseif (!$templatespare_active) {
        $activate = ['templatespare'];
      }

      $plugin_update = (
        !empty($templatespare_version) &&
        version_compare($templatespare_version, self::templatespare_old_version, '<')
      );

      // Templatespare is installed, active, and up to date.
      if (!empty($templatespare_installed) && $templatespare_active && !$plugin_update) {
?>
        <div id="blockspare-templatespare-template-collcetion">
          <div class="blockspare-dashboard">

            <?php $this->blockspare_render_header();
            ?>
            <div id="templatespare-template-collcetion-dashboard" selectedLanguage=""
              selectedBuilder="elementor">
              <footer class="bs-footer">
                <?php $this->blockspare_render_footer()
                ?>
              </footer>
            </div>

          </div>

        <?php
        return;
      }

      wp_enqueue_style('templatespare');

      if ($templatespare_active && $plugin_update) {
        $class = admin_url('plugins.php');

        $message = __(
          'The Templatespare plugin should be updated to the latest version',
          'blockspare'
        );
      } else {
        $class = 'false';

        $message = __(
          'Import a Starter Site, Personalize, and Live it in 3 Easy Steps!',
          'blockspare'
        );
      }
      wp_enqueue_script('block_admin_plugin_install');
      // Starter site notice.
        ?>

        <div id="templatespare-plugin-install-activate" data-class=<?php echo $class; ?> current-theme=<?php echo esc_attr($this->theme_slug) ?> install=<?php echo json_encode($install); ?> activate=<?php echo json_encode($activate); ?> data-plugin-page='bspare-demo-import' message='<?php echo $message; ?>' ispro=''></div>

      <?php
    }


    public function templatespare_get_plugin_file($plugin_slug)
    {
      require_once(ABSPATH . '/wp-admin/includes/plugin.php'); // Load plugin lib
      $plugins = get_plugins();

      foreach ($plugins as $plugin_file => $plugin_info) {

        // Get the basename of the plugin e.g. [askismet]/askismet.php
        $slug = dirname(plugin_basename($plugin_file));

        if ($slug) {
          if ($slug == $plugin_slug) {
            return $plugin_file; // If $slug = $plugin_name
          }
        }
      }
      return null;
    }

    private function blockspare_get_footer_data()
    {
      $footer_data = array(
        'brand_text' => 'The Gutenberg Block Plugin built for news, magazine & blog websites.',

        'columns'    => array(
          array(
            'title' => 'Resources',
            'links' => array(
              array('label' => 'Documentation',   'url' => 'https://blockspare.com/docs/'),
              array('label' => 'Video Tutorials', 'url' => 'https://www.youtube.com/@blockspare/videos'),
              array('label' => 'Support',         'url' => 'https://afthemes.com/supports/'),
              array('label' => 'Changelog',       'url' => 'https://wordpress.org/plugins/blockspare/#developers'),
            ),
          ),
          array(
            'title' => 'Company',
            'links' => array(
              array('label' => 'About AF Themes', 'url' => 'https://afthemes.com/'),
              array('label' => 'Our Themes',      'url' => 'https://afthemes.com/products/category/pro/'),
              array('label' => 'Blog',            'url' => 'https://afthemes.com/blog/'),
            ),
          ),
          array(
            'title' => 'Community',
            'links' => array(
              array('label' => 'Facebook Group',    'url' => 'https://www.facebook.com/afthemes/'),
              array('label' => 'Youtube Channel',   'url' => 'https://www.youtube.com/@blockspare'),
              array('label' => 'Follow on Twitter', 'url' => 'https://x.com/afthemes'),
            ),
          ),
        ),

        'subscribe'  => array(
          'title'       => 'Ready for Full Site Editing?',
          'emoji'       => array(
            'alt' => '🚀',
            'src' => 'https://s.w.org/images/core/emoji/17.0.2/svg/1f680.svg',
          ),
          'description' => 'Build a faster, modern news or magazine website with NewSpare—a powerful Full Site Editing (FSE) WordPress theme designed for publishers and bloggers.',
          'button_text' => 'Get NewSpare →',
        ),
      );

      /**
       * Allow other code to modify the footer data.
       */
      return apply_filters('blockspare_footer_data', $footer_data);
    }

    /**
     * Get header tabs data.
     *
     * @return array
     */
    private function blockspare_get_header_data()
    {
      $header_data = array(
        'tabs' => array(
          array(
            'label' => 'Home',
            'icon'  => 'dashicons-admin-home',
            'url'   => admin_url('admin.php?page=blockspare'),
            'page'  => 'blockspare',
          ),
          array(
            'label' => 'AI Settings',
            'icon'  => 'dashicons-superhero',
            'url'   => admin_url('admin.php?page=blockspare-ai'),
            'page'  => 'blockspare-ai',
          ),
          array(
            'label' => 'Site Builder',
            'icon'  => 'dashicons-hammer',
            'url'   => admin_url('admin.php?page=blockspare-theme-builder'),
            'page'  => 'blockspare-theme-builder',
          ),
          array(
            'label' => 'Starter Templates',
            'icon'  => 'dashicons-excerpt-view',
            'url'   => admin_url('admin.php?page=bspare-starter-sites'),
            'page'  => 'bspare-starter-sites',
          ),
          array(
            'label' => 'All Blocks',
            'icon'  => 'dashicons-screenoptions',
            'url'   => admin_url('admin.php?page=bs-blocks'),
            'page'  => 'bs-blocks',
          ),
          array(
            'label'     => 'My Templates',
            'icon'      => 'dashicons-store',
            'url'       => admin_url('edit.php?post_type=bs_templates'),
            'post_type' => 'bs_templates',
          ),
          array(
            'label' => 'Changelog',
            'icon'  => 'dashicons-info',
            'url'   => admin_url('admin.php?page=bs-change-log'),
            'page'  => 'bs-change-log',
          ),
          array(
            'label'    => 'Docs',
            'icon'     => 'dashicons-media-text',
            'url'      => 'https://blockspare.com/docs/',
            'external' => true,
          ),
          array(
            'label'    => 'Supports',
            'icon'     => 'dashicons-hammer',
            'url'      => 'https://afthemes.com/supports/',
            'external' => true,
          ),
        ),
      );

      /**
       * Allow other code to modify the header data.
       */
      return apply_filters('blockspare_header_data', $header_data);
    }

    function blockspare_is_active_tab($tab)
    {
      if (! empty($tab['external'])) {
        return false;
      }

      $current_page      = isset($_GET['page']) ? sanitize_key(wp_unslash($_GET['page'])) : '';
      $current_post_type = isset($_GET['post_type']) ? sanitize_key(wp_unslash($_GET['post_type'])) : '';

      if (! empty($tab['page']) && $tab['page'] === $current_page) {
        return true;
      }

      if (! empty($tab['post_type']) && $tab['post_type'] === $current_post_type) {
        return true;
      }

      return false;
    }

    /**
     * Render the header.
     */
    function blockspare_render_header()
    {
      $header_data = $this->blockspare_get_header_data();
      ?>
        <header>
          <div class="blockspare-dashboard__container">
            <div class="navigation-wrapper">
              <div class="plugin-logo"></div>
              <div class="bs-tab-list">
                <?php foreach ($header_data['tabs'] as $tab) : ?>
                  <?php
                  $classes = 'bs-tab';
                  if ($this->blockspare_is_active_tab($tab)) {
                    $classes .= ' bs-active-tab';
                  }
                  $target = ! empty($tab['external']) ? '_blank' : '_self';
                  ?>
                  <a href="<?php echo esc_url($tab['url']); ?>"
                    target="<?php echo esc_attr($target); ?>"
                    <?php echo ('_blank' === $target) ? 'rel="noopener noreferrer"' : ''; ?>
                    class="<?php echo esc_attr($classes); ?>">
                    <i class="dashicons <?php echo esc_attr($tab['icon']); ?>"></i>
                    <?php echo esc_html($tab['label']); ?>
                  </a>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </header>
      <?php
    }


    public function  blockspare_render_footer()
    {
      $footer_data = self::blockspare_get_footer_data();
      ?>
        <footer class="bs-footer">
          <div class="bs-footer-top navigation-wrapper">

            <div class="bs-footer-brand plugin-logo">
              <p><?php echo esc_html($footer_data['brand_text']); ?></p>
            </div>

            <?php foreach ($footer_data['columns'] as $column) : ?>
              <div class="bs-footer-links">
                <h4><?php echo esc_html($column['title']); ?></h4>
                <ul>
                  <?php foreach ($column['links'] as $link) : ?>
                    <li>
                      <a href="<?php echo esc_url($link['url']); ?>" target="_blank" rel="noopener noreferrer">
                        <?php echo esc_html($link['label']); ?>
                      </a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php endforeach; ?>

            <div class="bs-footer-subscribe">
              <h4>
                <?php echo esc_html($footer_data['subscribe']['title']); ?>
                <img draggable="false" role="img" class="emoji"
                  alt="<?php echo esc_attr($footer_data['subscribe']['emoji']['alt']); ?>"
                  src="<?php echo esc_url($footer_data['subscribe']['emoji']['src']); ?>">
              </h4>
              <p><?php echo esc_html($footer_data['subscribe']['description']); ?></p>
              <button class="components-button is-primary">
                <?php echo esc_html($footer_data['subscribe']['button_text']); ?>
              </button>
            </div>

          </div>
        </footer>
  <?php
    }
  }
}
