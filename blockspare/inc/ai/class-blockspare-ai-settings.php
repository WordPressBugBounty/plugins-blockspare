<?php

if (! defined('ABSPATH')) {
  exit;
}

/**
 * Handles the "AI" settings screen: default prompts, admin menu,
 * settings fields, and sanitization.
 */
class Blockspare_AI_Settings
{

  /**
   * Default AI settings.
   */
  private $default_settings = array(

    'generate_prompt' => 'Write a high-quality blog post about: {prompt}',

    // Max words the "Content Generation" tool should produce.
    'generate_word_limit' => 75,

    'summarize_prompt' => 'Summarize the following WordPress blog post.

Requirements:
- Identify the main topic.
- Include the most important points.
- Remove unnecessary repetition.
- Keep important facts and details.
- Do not invent or add information.
- Make the summary concise and easy to understand.
- Return clean HTML.
- Do not use Markdown.
- Do not wrap the response in a code block.

Original blog post:

{post_content}',

    // Max words the "Summarization" tool should produce.
    'summarize_word_limit' => 25,

    'qa_prompt' => 'Read the following WordPress blog post.

Generate {qa_count} of the most useful questions and answers that a reader
would want to know after reading this article.

Rules:
- Generate exactly {qa_count} questions and answers.
- Questions must be directly related to the article.
- Answers must be based ONLY on the article.
- Do not invent information.
- Do not add external information.
- Avoid duplicate or very similar questions.
- Questions should be clear and useful.
- Answers should be concise but informative.
- Return ONLY valid JSON.
- Do not use Markdown.
- Do not use ``` code blocks.

Return exactly this JSON structure:

{
    "items": [
        {
            "question": "Question 1",
            "answer": "Answer 1"
        }
    ]
}

Article:

{post_content}',

    // How many Q&A pairs to generate (max 5).
    'qa_count' => 2,
  );


  public function __construct()
  {

    $this->default_settings['language'] = $this->blockspare_get_default_language();
    add_action('admin_enqueue_scripts', array($this, 'blockspare_enqueue_editor_assets'));
    add_action('admin_menu', array($this, 'blockspare_ai_settings_menu'));
    add_action('admin_init', array($this, 'blockspare_ai_settings_init'));
  }


  public static function blockspare_get_language_fallback_map()
  {
    return array(
      'af'    => 'Afrikaans',
      'ar'    => 'Arabic',
      'bg_BG' => 'Bulgarian',
      'ca'    => 'Catalan',
      'cs_CZ' => 'Czech',
      'da_DK' => 'Danish',
      'de_DE' => 'German',
      'de_CH' => 'German (Switzerland)',
      'de_AT' => 'German (Austria)',
      'el'    => 'Greek',
      'en_GB' => 'English (UK)',
      'es_ES' => 'Spanish (Spain)',
      'es_MX' => 'Spanish (Mexico)',
      'fa_IR' => 'Persian',
      'fi'    => 'Finnish',
      'fr_FR' => 'French (France)',
      'fr_CA' => 'French (Canada)',
      'he_IL' => 'Hebrew',
      'hi_IN' => 'Hindi',
      'hu_HU' => 'Hungarian',
      'id_ID' => 'Indonesian',
      'it_IT' => 'Italian',
      'ja'    => 'Japanese',
      'ko_KR' => 'Korean',
      'ne_NP' => 'Nepali',
      'nl_NL' => 'Dutch',
      'nb_NO' => 'Norwegian (Bokmål)',
      'pl_PL' => 'Polish',
      'pt_BR' => 'Portuguese (Brazil)',
      'pt_PT' => 'Portuguese (Portugal)',
      'ro_RO' => 'Romanian',
      'ru_RU' => 'Russian',
      'sk_SK' => 'Slovak',
      'sv_SE' => 'Swedish',
      'th'    => 'Thai',
      'tr_TR' => 'Turkish',
      'uk'    => 'Ukrainian',
      'vi'    => 'Vietnamese',
      'zh_CN' => 'Chinese (China)',
      'zh_TW' => 'Chinese (Taiwan)',
    );
  }

  public function blockspare_enqueue_editor_assets($hook_suffix)
  {
    $expected_hook = get_plugin_page_hookname('blockspare-ai', 'blockspare');

    if ($hook_suffix !== $expected_hook) {
      return;
    }
    remove_all_actions('admin_notices');
    remove_all_actions('all_admin_notices');
    $manual_deps = array(
      'wp-element',
      'wp-i18n',
    );

    wp_enqueue_script(
      'blockspare-ai-generator-dashboard',
      BLOCKSPARE_PLUGIN_URL . 'dist/aidashboardSettings.js',
      $manual_deps,
      '1.0.0'
    );
  }

  public function blockspare_get_default_language()
  {
    $locale = get_locale();

    if (empty($locale) || 'en_US' === $locale) {
      return 'English';
    }

    $fallback = self::blockspare_get_language_fallback_map();

    return ! empty($fallback[$locale]) ? $fallback[$locale] : 'English';
  }


  /**
   * Add AI settings menu.
   */
  public function blockspare_ai_settings_menu()
  {
$badge_count = __('New', 'blockspare'); // Dynamic count variable
    add_submenu_page(
      'blockspare',
      __('AI Settings', 'blockspare'),
      sprintf(
        __('AI Settings %s', 'blockspare'),
        '<span class="update-plugins count-' . esc_attr($badge_count) . '"><span class="plugin-count">' . esc_html($badge_count) . '</span></span>'
      ),
      'manage_options',
      'blockspare-ai',
      array($this, 'blockspare_ai_settings_page'),
      1
    );

    add_submenu_page(
      'blockspare-ai',
      __('AI Settings', 'blockspare'),
      __('AI Settings', 'blockspare'),
      'manage_options',
      'blockspare-ai',
      array($this, 'blockspare_ai_settings_page')
    );
  }


  /**
   * Register AI settings.
   */
  public function blockspare_ai_settings_init()
  {
    register_setting(
      'blockspare_ai_settings_group',
      'blockspare_ai_settings',
      array(
        'sanitize_callback' => array(
          $this,
          'blockspare_sanitize_ai_settings',
        ),
      )
    );

    /**
     * General Settings.
     */
    add_settings_section(
      'blockspare_ai_general_section',
      __('General Settings', 'blockspare'),
      array(
        $this,
        'blockspare_ai_general_section_callback'
      ),
      'blockspare-ai-general'
    );

    add_settings_field(
      'language',
      __('Default Language', 'blockspare'),
      array($this, 'blockspare_language_field'),
      'blockspare-ai-general',
      'blockspare_ai_general_section'
    );

    add_settings_field(
      'ai_model_selection',
      __('AI Model', 'blockspare'),
      array($this, 'blockspare_ai_model_field'),
      'blockspare-ai-general',
      'blockspare_ai_general_section'
    );


    /**
     * Content Generation.
     */
    add_settings_section(
      'blockspare_ai_generation_section',
      __('AI Content Generation', 'blockspare'),
      function () {
        echo '<div class="notice notice-warning inline" style="margin: 0 0 15px 0;"><p>';
        esc_html_e(
          'Customizing the Content Generation prompt and word limit is a Pro feature. These fields are read-only in the free version.',
          'blockspare'
        );
        echo '</p></div>';
        echo '<p>';
        esc_html_e(
          'Customize the prompt used when generating new content.',
          'blockspare'
        );
        echo '</p>';
      },
      'blockspare-ai-generation'
    );

    add_settings_field(
      'generate_prompt',
      __('Generation Prompt', 'blockspare'),
      array($this, 'blockspare_generate_prompt_field'),
      'blockspare-ai-generation',
      'blockspare_ai_generation_section'
    );

    add_settings_field(
      'generate_word_limit',
      __('Word Limit', 'blockspare'),
      array($this, 'blockspare_generate_word_limit_field'),
      'blockspare-ai-generation',
      'blockspare_ai_generation_section'
    );


    /**
     * Summarization.
     */
    add_settings_section(
      'blockspare_ai_summary_section',
      __('AI Summarization', 'blockspare'),
      function () {
        echo '<div class="notice notice-warning inline" style="margin: 0 0 15px 0;"><p>';
        esc_html_e(
          'Customizing the Summarization prompt and word limit is a Pro feature. These fields are read-only in the free version.',
          'blockspare'
        );
        echo '</p></div>';
        echo '<p>';
        esc_html_e(
          'Customize the prompt used when summarizing existing content.',
          'blockspare'
        );
        echo '</p>';
      },
      'blockspare-ai-summary'
    );

    add_settings_field(
      'summarize_prompt',
      __('Summarization Prompt', 'blockspare'),
      array($this, 'blockspare_summarize_prompt_field'),
      'blockspare-ai-summary',
      'blockspare_ai_summary_section'
    );

    add_settings_field(
      'summarize_word_limit',
      __('Word Limit', 'blockspare'),
      array($this, 'blockspare_summarize_word_limit_field'),
      'blockspare-ai-summary',
      'blockspare_ai_summary_section'
    );


    /**
     * Helpful Q&A.
     */
    add_settings_section(
      'blockspare_ai_qa_section',
      __('AI Key Q&A', 'blockspare'),
      function () {
        echo '<div class="notice notice-warning inline" style="margin: 0 0 15px 0;"><p>';
        esc_html_e(
          'Customizing Helpful Q&A prompt and question count is a Pro feature. These fields are read-only in the free version.',
          'blockspare'
        );
        echo '</p></div>';
        echo '<p>';
        esc_html_e(
          'Customize the prompt used to generate helpful questions and answers.',
          'blockspare'
        );
        echo '</p>';
      },
      'blockspare-ai-qa'
    );

    add_settings_field(
      'qa_prompt',
      __('Helpful Q&A Prompt', 'blockspare'),
      array($this, 'blockspare_qa_prompt_field'),
      'blockspare-ai-qa',
      'blockspare_ai_qa_section'
    );

    add_settings_field(
      'qa_count',
      __('Number of Questions', 'blockspare'),
      array($this, 'blockspare_qa_count_field'),
      'blockspare-ai-qa',
      'blockspare_ai_qa_section'
    );
  }


  /**
   * Get AI settings with defaults.
   */
  public function get_ai_settings()
  {
    $settings = get_option('blockspare_ai_settings', array());

    if (! is_array($settings)) {
      $settings = array();
    }

    return wp_parse_args(
      $settings,
      $this->default_settings
    );
  }


  private function blockspare_get_language_list()
  {
    $languages = array(
      'en_US' => __('English', 'blockspare'),
    );

    $languages = array_merge($languages, $this->blockspare_get_language_fallback_map());

    if (! function_exists('wp_get_available_translations')) {
      require_once ABSPATH . 'wp-admin/includes/translation-install.php';
    }

    $translations = wp_get_available_translations();

    if (is_array($translations)) {
      foreach ($translations as $locale => $translation) {
        if (! isset($languages[$locale]) && ! empty($translation['english_name'])) {
          $languages[$locale] = $translation['english_name'];
        }
      }
    }

    asort($languages);

    return $languages;
  }

  public function blockspare_ai_general_section_callback()
  {

    $generation_url = add_query_arg(
      array(
        'page' => 'blockspare-ai',
        'tab'  => 'generation',
      ),
      admin_url('admin.php')
    );

    $summarization_url = add_query_arg(
      array(
        'page' => 'blockspare-ai',
        'tab'  => 'summary',
      ),
      admin_url('admin.php')
    );

    $qa_url = add_query_arg(
      array(
        'page' => 'blockspare-ai',
        'tab'  => 'qa',
      ),
      admin_url('admin.php')
    ); ?>
    <div class="blockspare-ai-tabs" style="display: flex; gap: 20px;">

      <a href="admin.php?page=blockspare-ai&tab=generation"
        class="active"
        style="display: flex; flex-direction: row; gap:15px">
        <span>
          <img src="<?php echo esc_url(BLOCKSPARE_PLUGIN_URL . 'assets/icons/generator.svg'); ?>" />
        </span>
        <span>
          <h3>AI Content Generation</h3>
          <span style="font-size: 12px; font-weight: 400; color: #646970;">
            Create new content with AI using your preferred provider and model. Simply describe what you want to generate, and let AI help you create engaging, relevant, and high-quality content.
          </span>
        </span>
      </a>

      <a href="admin.php?page=blockspare-ai&tab=summary"
        style="display: flex; flex-direction: row; gap:15px">
        <span>
          <img src="<?php echo esc_url(BLOCKSPARE_PLUGIN_URL . 'assets/icons/summary-check.svg'); ?>" />
        </span>
        <span>
          <h3>AI Summarization</h3>
          <span style="font-size: 12px; font-weight: 400; color: #646970;">
            Use AI to quickly summarize your content and extract the most important points, making long articles and posts easier to understand and review.
          </span>
        </span>
      </a>

      <a href="admin.php?page=blockspare-ai&tab=qa"
        style="display: flex; flex-direction: row; gap:15px">
        <span>
          <img src="<?php echo esc_url(BLOCKSPARE_PLUGIN_URL . 'assets/icons/comments-question.svg'); ?>" />
        </span>
        <span>
          <h3>AI Key Q&A</h3>
          <span style="font-size: 12px; font-weight: 400; color: #646970;">
            Automatically identify relevant questions and answers from your content with AI. Highlight the most useful information to make your content easier to understand and navigate.
          </span>
        </span>
      </a>

    </div>

    <p>
      Use your AI connectors to generate content, summarize posts, and find useful questions and answers.
    </p>

    <p style="margin-top: 15px;">
      <a href="options-connectors.php" class="button button-primary">
        Configure Connectors
      </a>
    </p>

  <?php }


  /**
   * Default language field.
   */
  public function blockspare_language_field()
  {
    //$settings  = $this->get_ai_settings();
    $language  = $this->blockspare_get_default_language();
    $languages = $this->blockspare_get_language_list();

  ?>

    <select
      name="blockspare_ai_settings[language]"
      class="regular-text"
      disabled>

      <?php foreach ($languages as $locale => $label) : ?>
        <option value="<?php echo esc_attr($label); ?>" <?php selected($language, $label); ?>>
          <?php echo esc_html($label); ?>
        </option>
      <?php endforeach; ?>

    </select>

    <p class="description">
      <?php esc_html_e(
        'The selected language will be used by the AI content tools. Default: Site Langauge.',
        'blockspare'
      ); ?>
    </p>

  <?php
  }

  /**
   * AI Model selection dropdown field.
   */
  public function blockspare_ai_model_field()
  {
    $settings      = $this->get_ai_settings();
    $current_prov  = isset($settings['ai_provider']) ? $settings['ai_provider'] : '';
    $current_model = isset($settings['ai_model']) ? $settings['ai_model'] : '';

    $options = array('' => __('Select Model', 'blockspare'));

    if (class_exists('WordPress\AiClient\AiClient')) {
      try {
        $registry = \WordPress\AiClient\AiClient::defaultRegistry();

        foreach ($registry->getRegisteredProviderIds() as $provider_id) {

          if (!$registry->isProviderConfigured($provider_id)) {
            continue;
          }

          $provider_class    = $registry->getProviderClassName($provider_id);
          $provider_metadata = $provider_class::metadata();
          $provider_label    = $provider_metadata->getName();

          $models = $provider_class::modelMetadataDirectory()->listModelMetadata();

          foreach ($models as $model) {

            $supports_text = false;
            foreach ($model->getSupportedCapabilities() as $capability) {
              if ($capability->isTextGeneration()) {
                $supports_text = true;
                break;
              }
            }

            if (!$supports_text) {
              continue;
            }

            $m_id   = $model->getId();
            $m_name = $model->getName();

            $combined_key           = $provider_id . '|' . $m_id;
            $options[$combined_key] = sprintf('%s - %s', $provider_label, $m_name);
          }
        }
      } catch (\Throwable $e) {
        // Log errors if necessary
      }
    }

    $selected_value = (! empty($current_prov) && ! empty($current_model))
      ? $current_prov . '|' . $current_model
      : '';

    echo '<select name="blockspare_ai_settings[ai_model_selection]" class="regular-text">';
    foreach ($options as $val => $label) {
      printf(
        '<option value="%s" %s>%s</option>',
        esc_attr($val),
        selected($selected_value, $val, false),
        esc_html($label)
      );
    }
    echo '</select>';
    printf(
      '<p class="description">%s</p>',
      esc_html__(
        'The selected model will be used by the AI content tools.',
        'blockspare'
      )
    );
  }


  /**
   * Content generation prompt field (DISABLED).
   */
  public function blockspare_generate_prompt_field()
  {
    $settings = $this->get_ai_settings();

  ?>

    <textarea
      name="blockspare_ai_settings[generate_prompt]"
      rows="10"
      class="large-text"
      disabled><?php echo esc_textarea($settings['generate_prompt']); ?></textarea>

    <p class="description">
      <?php esc_html_e(
        'Available placeholders: {prompt}, {language}',
        'blockspare'
      ); ?>
    </p>

  <?php
  }


  /**
   * Content generation word limit field (DISABLED).
   */
  public function blockspare_generate_word_limit_field()
  {
    $settings = $this->get_ai_settings();
    $limit    = (int) $settings['generate_word_limit'];

  ?>

    <input
      type="number"
      name="blockspare_ai_settings[generate_word_limit]"
      value="<?php echo esc_attr($limit); ?>"
      min="1"
      max="5000"
      step="1"
      class="small-text"
      disabled />

    <p class="description">
      <?php esc_html_e(
        'Maximum number of words to generate. Default: 75.',
        'blockspare'
      ); ?>
    </p>

  <?php
  }


  /**
   * Summarization prompt field (DISABLED).
   */
  public function blockspare_summarize_prompt_field()
  {
    $settings = $this->get_ai_settings();

  ?>

    <textarea
      name="blockspare_ai_settings[summarize_prompt]"
      rows="15"
      class="large-text"
      disabled><?php echo esc_textarea($settings['summarize_prompt']); ?></textarea>

    <p class="description">
      <?php esc_html_e(
        'Available placeholders: {language}, {post_content}',
        'blockspare'
      ); ?>
    </p>

  <?php
  }


  /**
   * Summarization word limit field (DISABLED).
   */
  public function blockspare_summarize_word_limit_field()
  {
    $settings = $this->get_ai_settings();
    $limit    = (int) $settings['summarize_word_limit'];

  ?>

    <input
      type="number"
      name="blockspare_ai_settings[summarize_word_limit]"
      value="<?php echo esc_attr($limit); ?>"
      min="1"
      max="5000"
      step="1"
      class="small-text"
      disabled />

    <p class="description">
      <?php esc_html_e(
        'Maximum number of words to generate for the summary. Default: 25.',
        'blockspare'
      ); ?>
    </p>

  <?php
  }


  /**
   * Helpful Q&A prompt field (DISABLED).
   */
  public function blockspare_qa_prompt_field()
  {
    $settings = $this->get_ai_settings();

  ?>

    <textarea
      name="blockspare_ai_settings[qa_prompt]"
      rows="25"
      class="large-text"
      disabled><?php echo esc_textarea($settings['qa_prompt']); ?></textarea>

    <p class="description">
      <?php esc_html_e(
        'Available placeholders: {language}, {post_content}, {qa_count}',
        'blockspare'
      ); ?>
    </p>

  <?php
  }


  /**
   * Helpful Q&A count field (DISABLED).
   */
  public function blockspare_qa_count_field()
  {
    $settings = $this->get_ai_settings();
    $count    = (int) $settings['qa_count'];

  ?>

    <select
      name="blockspare_ai_settings[qa_count]"
      class="regular-text"
      disabled>

      <?php for ($i = 1; $i <= 5; $i++) : ?>
        <option value="<?php echo esc_attr($i); ?>" <?php selected($count, $i); ?>>
          <?php echo esc_html($i); ?>
        </option>
      <?php endfor; ?>

    </select>

    <p class="description">
      <?php esc_html_e(
        'Number of questions and answers to generate (max 5). Default: 3.',
        'blockspare'
      ); ?>
    </p>

  <?php
  }


  /**
   * AI settings page rendering.
   */
  public function blockspare_ai_settings_page()
  {
    if (! current_user_can('manage_options')) {

      echo '<div class="notice notice-error inline">';
      echo '<p>' . esc_html__('You do not have permission to access this page.', 'blockspare') . '</p>';
      echo '</div>';

      return;
    }

    $tabs = array(
      'general'    => __('General', 'blockspare'),
      'generation' => __('Content Generation', 'blockspare'),
      'summary'    => __('Summarization', 'blockspare'),
      'qa'         => __('Helpful Q&A', 'blockspare'),
    );

    $active_tab = 'general';

    if (isset($_GET['tab']) && array_key_exists($_GET['tab'], $tabs)) {
      $active_tab = sanitize_key(wp_unslash($_GET['tab']));
    }

  ?>

    <div class="wrap">

      <h1>
        <?php esc_html_e('AI Settings', 'blockspare'); ?>
      </h1>

      <h2 class="nav-tab-wrapper">
        <?php foreach ($tabs as $tab_slug => $tab_label) : ?>
          <a
            href="<?php echo esc_url(add_query_arg('tab', $tab_slug)); ?>"
            class="nav-tab <?php echo $active_tab === $tab_slug ? 'nav-tab-active' : ''; ?>">
            <?php echo esc_html($tab_label); ?>
          </a>
        <?php endforeach; ?>
      </h2>

      <form method="post" action="options.php">

        <?php settings_fields('blockspare_ai_settings_group'); ?>

        <div style="margin-top: 20px;<?php echo $active_tab === 'general' ? '' : ' display:none;'; ?>">
          <?php do_settings_sections('blockspare-ai-general'); ?>
          <?php submit_button(__('Save AI Settings', 'blockspare')); ?>
        </div>

        <div style="margin-top: 20px;<?php echo $active_tab === 'generation' ? '' : ' display:none;'; ?>">
          <?php do_settings_sections('blockspare-ai-generation'); ?>
          <?php submit_button(__('Save AI Settings', 'blockspare'), 'primary', 'submit', true, array('disabled' => 'disabled')); ?>
        </div>

        <div style="margin-top: 20px;<?php echo $active_tab === 'summary' ? '' : ' display:none;'; ?>">
          <?php do_settings_sections('blockspare-ai-summary'); ?>
          <?php submit_button(__('Save AI Settings', 'blockspare'), 'primary', 'submit', true, array('disabled' => 'disabled')); ?>
        </div>

        <div style="margin-top: 20px;<?php echo $active_tab === 'qa' ? '' : ' display:none;'; ?>">
          <?php do_settings_sections('blockspare-ai-qa'); ?>
          <?php submit_button(__('Save AI Settings', 'blockspare'), 'primary', 'submit', true, array('disabled' => 'disabled')); ?>
        </div>

      </form>

    </div>

<?php
  }


  /**
   * Sanitize AI settings and restrict modifications on locked fields.
   */
  public function blockspare_sanitize_ai_settings($input)
  {
    $existing = $this->get_ai_settings();
    $output   = $existing;

    if (! is_array($input)) {
      return $output;
    }

    /**
     * General settings (Allowed to update).
     */
    if (isset($input['language'])) {
      $output['language'] = sanitize_text_field($input['language']);
    }

    if (! empty($input['ai_model_selection']) && str_contains($input['ai_model_selection'], '|')) {
      list($provider, $model) = explode('|', $input['ai_model_selection'], 2);
      $output['ai_provider'] = sanitize_text_field($provider);
      $output['ai_model']    = sanitize_text_field($model);
    } else {
      $output['ai_provider'] = '';
      $output['ai_model']    = '';
    }

    /**
     * Locked settings in Free Plugin (Retain original values).
     */
    $output['language']             = $this->blockspare_get_default_language();
    $output['generate_prompt']    = $existing['generate_prompt'];
    $output['generate_word_limit'] = $existing['generate_word_limit'];
    $output['summarize_prompt']   = $existing['summarize_prompt'];
    $output['summarize_word_limit'] = $existing['summarize_word_limit'];
    $output['qa_prompt']          = $existing['qa_prompt'];
    $output['qa_count']           = $existing['qa_count'];

    return $output;
  }
}
