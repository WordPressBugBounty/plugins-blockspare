<?php

if (! defined('ABSPATH')) {
  exit;
}
//using_model_preference
/**
 * Handles the block editor assets and the REST API endpoint that
 * powers the AI content generation, summarization, and Q&A tools.
 */
class Blockspare_AI_REST_API
{

  /**
   * @var Blockspare_AI_Settings
   */
  private $settings;


  /**
   * @param Blockspare_AI_Settings $settings Settings instance, used to
   *                                          read the saved/default prompts.
   */
  public function __construct(Blockspare_AI_Settings $settings)
  {
    $this->settings = $settings;

    add_action('init', array($this, 'blockspare_register_assets'));
    add_action('enqueue_block_editor_assets', array($this, 'blockspare_enqueue_editor_assets'));
    add_action('rest_api_init', array($this, 'register_rest_routes'));
  }


  /**
   * Register the compiled JS build asset.
   */
  public function blockspare_register_assets()
  {
    $asset_file_path = plugin_dir_path(__FILE__) . 'build/index.asset.php';

    // Fallback default asset structure.
    $asset_file = file_exists($asset_file_path)
      ? include $asset_file_path
      : array(
        'dependencies' => array(),
        'version'      => '1.0',
      );

    // Define your manual dependencies.
    $manual_deps = array(
      'wp-plugins',
      'wp-editor',
      'wp-edit-post',
      'wp-element',
      'wp-components',
      'wp-data',
      'wp-blocks',
      'wp-block-editor',
      'wp-api-fetch',
      'wp-i18n',
    );

    // Merge and deduplicate dependencies.
    $merged_deps = array_unique(
      array_merge($asset_file['dependencies'], $manual_deps)
    );

    wp_register_script(
      'blockspare-ai-generator-editor',
      BLOCKSPARE_PLUGIN_URL . 'dist/aigen.js',
      $merged_deps,
      '1.0.0'
    );
  }


  /**
   * Enqueue assets only in editor screens where AI is supported.
   */
  public function blockspare_enqueue_editor_assets()
  {

    wp_enqueue_script('blockspare-ai-generator-editor');

    // Check if function exists AND if any active provider/connector is available.
    $ai_active       = function_exists('wp_ai_client_prompt');
    $has_credentials = false;
    $missing_reason  = '';

    $settings = $this->settings->get_ai_settings();
    $ai_settings_class = new Blockspare_AI_Settings();

    // echo ":sss";
    // var_dump($settings);
    $aiProvider = isset($settings['ai_provider']) ? $settings['ai_provider'] : '';
    $aiModel = isset($settings['ai_model']) ? $settings['ai_model'] : '';
    if ($ai_active) {

      // Query builder to verify if text generation model/credentials exist.
      $builder = wp_ai_client_prompt();

      $has_credentials = $builder->is_supported_for_text_generation();

      if (! $has_credentials) {
        $missing_reason = __(
          'AI features are currently unavailable. Please ensure the WordPress AI plugin is installed and active API keys/connectors are set up.',
          'blockspare'
        );
      }
    } else {

      $missing_reason = __(
        'The WordPress AI Client API (wp_ai_client_prompt) is not active.',
        'blockspare'
      );
    }

    wp_localize_script(
      'blockspare-ai-generator-editor',
      'blockspareAiPluginData',
      array(
        'isAiSupported' => $ai_active && $has_credentials,
        'missingReason' => $missing_reason,
        'havePermission' => current_user_can('manage_options'),
        'nonce'          => wp_create_nonce('wp_rest'),
        'aiProvider' => $aiProvider,
        'aiModel' => $aiModel,
        'language' => $ai_settings_class->blockspare_get_default_language(),
        'connectorLink'  => admin_url('options-connectors.php'),
        'connectorText'  => __('Configure Connectors', 'blockspare'),
        'bsAiLink'  => admin_url('admin.php?page=blockspare-ai'),
        'bsAiText'  => __('Configure AI Settings', 'blockspare'),


      )
    );

    // Feature Detection: Ensure WP AI Client API exists and supports text generation.
    if (! function_exists('wp_ai_client_prompt')) {
      return;
    }

    $builder = wp_ai_client_prompt('test');

    if (! $builder->is_supported_for_text_generation()) {
      return;
    }
  }


  /**
   * Register custom REST API Endpoint wrapper for wp_ai_client_prompt.
   */
  public function register_rest_routes()
  {
    register_rest_route(
      'blockspare/v1',
      '/generate-content',
      array(
        'methods'             => 'POST',
        'callback'            => array($this, 'handle_generation_request'),
        'permission_callback' => array($this, 'check_permissions'),
        'args'                => array(

          'action' => array(
            'required'          => true,
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'enum'              => array(
              'generate',
              'summarize',
              'highlight_qa',
            ),
          ),

          'prompt' => array(
            'required'          => false,
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_textarea_field',
          ),

          'post_id' => array(
            'required'          => true,
            'type'              => 'integer',
            'sanitize_callback' => 'absint',
          ),
        ),
      )
    );
  }


  /**
   * Permission check ensuring user can edit the requested post.
   */
  public function check_permissions(WP_REST_Request $request)
  {
    // 1. Verify user capability to manage options
    if (! current_user_can('manage_options')) {
      return new WP_Error(
        'rest_forbidden',
        __('You do not have permission to access this endpoint.', 'blockspare'),
        array('status' => 403)
      );
    }

    // 2. Ensure post ID exists and user can edit this post
    $post_id = $request->get_param('post_id');
    if (! current_user_can('edit_post', $post_id)) {
      return new WP_Error(
        'rest_cannot_edit',
        __('You are not allowed to edit this post.', 'blockspare'),
        array('status' => 403)
      );
    }
    return true;
  }

  private function blockspare_words_to_max_tokens($word_limit, $language = 'English')
  {
    $word_limit = absint($word_limit);

    if ($word_limit < 1) {
      $word_limit = 1;
    }

    // Non-Latin / token-heavy scripts get a much larger multiplier and
    // floor. This list covers the languages most likely to need it;
    // extend it if you add other non-Latin languages to the settings.
    $heavy_script_languages = array(
      'hindi',
      'nepali',
      'chinese',
      'japanese',
      'korean',
      'arabic',
      'persian',
      'hebrew',
      'thai',
      'russian',
      'ukrainian',
      'bulgarian',
      'greek',
    );

    $is_heavy_script = in_array(strtolower($language), $heavy_script_languages, true);

    $multiplier = $is_heavy_script ? 5 : 2.5;
    $floor      = $is_heavy_script ? 1536 : 512;

    $tokens = (int) ceil($word_limit * $multiplier);

    return max($floor, min($tokens, 8192));
  }


  /**
   * Starts a prompt builder and applies the admin's saved
   * provider/model preference, if one was configured.
   *
   * Falls back to the site default provider/model when the setting
   * is empty (i.e. the "Default (System Default)" option was chosen).
   *
   * @param string $prompt   The initial prompt text.
   * @param array  $settings The already-loaded AI settings array.
   * @return WP_AI_Client_Prompt_Builder
   */
  private function get_ai_prompt_builder($prompt, $settings)
  {
    $builder = wp_ai_client_prompt($prompt);

    $provider = ! empty($settings['ai_provider']) ? $settings['ai_provider'] : '';
    $model    = ! empty($settings['ai_model']) ? $settings['ai_model'] : '';

    if (! empty($provider)) {
      $builder = $builder->using_provider($provider);

      if (! empty($model)) {
        $builder = $builder->using_model_preference($model);
      }
    }


    return $builder;
  }


  /**
   * Execute AI Generation using WordPress Native API.
   */
  public function handle_generation_request(WP_REST_Request $request)
  {
    $action  = $request->get_param('action');
    $prompt  = $request->get_param('prompt');
    $post_id = absint($request->get_param('post_id'));

    /**
     * Get saved AI settings.
     *
     * If settings do not exist, get_ai_settings()
     * automatically returns the original default prompts.
     */
    $settings = $this->settings->get_ai_settings();

    $ai_settings_class = new Blockspare_AI_Settings();
    $language = $ai_settings_class->blockspare_get_default_language();

    /**
     * Word/answer limits configured on the Settings screen, with safe
     * fallbacks in case the option is missing or was tampered with.
     */
    $generate_word_limit = ! empty($settings['generate_word_limit'])
      ? absint($settings['generate_word_limit'])
      : 75;

    $summarize_word_limit = ! empty($settings['summarize_word_limit'])
      ? absint($settings['summarize_word_limit'])
      : 25;

    $qa_count = ! empty($settings['qa_count'])
      ? absint($settings['qa_count'])
      : 2;

    // Defensive clamp -- the settings sanitizer already restricts this to
    // 1-5, but re-checking here means a bad/edited option value can never
    // ask the AI for an unreasonable number of Q&A pairs.
    if ($qa_count < 1) {
      $qa_count = 1;
    } elseif ($qa_count > 5) {
      $qa_count = 5;
    }


    /**
     * Make sure the post exists.
     */
    $post = get_post($post_id);

    if (! $post) {
      return new WP_Error(
        'post_not_found',
        __('Post not found.', 'blockspare'),
        array('status' => 404)
      );
    }


    /**
     * =========================
     * GENERATE CONTENT
     * =========================
     */
    if ($action === 'generate') {

      if (empty(trim($prompt))) {
        return new WP_Error(
          'missing_prompt',
          __('Please provide a prompt.', 'blockspare'),
          array('status' => 400)
        );
      }


      /**
       * Get custom/default generation prompt.
       */
      $generate_prompt = $settings['generate_prompt'];


      /**
       * Replace dynamic placeholders.
       */
      $generate_prompt = str_replace(
        array(
          '{prompt}',
          '{language}',
          '{word_limit}',
        ),
        array(
          $prompt,
          $language,
          $generate_word_limit,
        ),
        $generate_prompt
      );


      /**
       * Generate AI content.
       */
      $response = $this->get_ai_prompt_builder($generate_prompt, $settings)
        ->using_system_instruction(
          'You are a professional blog post copywriter.
Output clean HTML paragraphs without markdown code blocks.
Write the response in ' . $language . '.
Target approximately ' . $generate_word_limit . ' words, but prioritize
writing complete, coherent, well-formed content over hitting that number
exactly -- never cut a sentence short just to stay under it.
Return ONLY the article content itself.
Do not include any commentary, notes, word counts, or quality remarks
about the article -- for example, never write things like "Word count:"
or "Quality: Professional".'
        )
        ->using_max_tokens(
          $this->blockspare_words_to_max_tokens($generate_word_limit, $language)
        )
        ->generate_text();
    }


    /**
     * =========================
     * SUMMARIZE CONTENT
     * =========================
     */
    elseif ($action === 'summarize') {

      $post_content = $post->post_content;


      /**
       * Check whether the post actually has content.
       */
      if (empty(trim(wp_strip_all_tags($post_content)))) {
        return new WP_Error(
          'empty_post_content',
          __('There is no content available to summarize.', 'blockspare'),
          array('status' => 400)
        );
      }


      /**
       * Get custom/default summarization prompt.
       */
      $summary_prompt = $settings['summarize_prompt'];


      /**
       * Replace dynamic placeholders.
       */
      $summary_prompt = str_replace(
        array(
          '{language}',
          '{post_content}',
          '{word_limit}',
        ),
        array(
          $language,
          $post_content,
          $summarize_word_limit,
        ),
        $summary_prompt
      );


      /**
       * Generate summary.
       */
      $response = $this->get_ai_prompt_builder($summary_prompt, $settings)
        ->using_system_instruction(
          'You are a professional content summarization assistant.
Your job is to accurately summarize the provided content
without adding information that does not exist in the original content.
Always respond in ' . $language . '.
Target approximately ' . $summarize_word_limit . ' words, but prioritize
writing a complete, coherent summary over hitting that number exactly --
never cut a sentence short just to stay under it.
Return ONLY the summary content itself.
Do not include any commentary, notes, word counts, or quality remarks
about the summary.'
        )
        ->using_max_tokens(
          $this->blockspare_words_to_max_tokens($summarize_word_limit, $language)
        )
        ->generate_text();
    }


    /**
     * =========================
     * HELPFUL Q&A
     * =========================
     */
    elseif ($action === 'highlight_qa') {

      return new WP_Error(
        'rest_forbidden_action',
        __('Highlight Q&A is a Pro feature and is disabled in the free version.', 'blockspare'),
        array('status' => 403)
      );
    }


    /**
     * =========================
     * INVALID ACTION
     * =========================
     */
    else {

      return new WP_Error(
        'invalid_action',
        __('Invalid AI action.', 'blockspare'),
        array('status' => 400)
      );
    }


    /**
     * Handle AI error.
     */
    if (is_wp_error($response)) {
      return new WP_Error(
        'ai_generation_failed',
        $response->get_error_message(),
        array('status' => 500)
      );
    }


    /**
     * Return AI response.
     */
    return rest_ensure_response(
      array(
        'success' => true,
        'action'  => $action,
        'post_id' => $post_id,
        'content' => $response,
      )
    );
  }
}
