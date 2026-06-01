<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Blockspare_Setup {

    public $name;
    public $type;
    public $dismiss_url;
    public $temporary_dismiss_url;
    public $pricing_url;
    public $current_user_id;

    /**
     * Constructor.
     */
    public function __construct( $name, $type, $dismiss_url, $temporary_dismiss_url ) {

        $this->name                   = $name;
        $this->type                   = $type;
        $this->dismiss_url            = $dismiss_url;
        $this->temporary_dismiss_url  = $temporary_dismiss_url;
        $this->pricing_url            = 'https://www.blockspare.com/';
        $this->current_user_id        = get_current_user_id();

        add_action( 'admin_notices', array( $this, 'notice' ) );

        $this->dismiss_notice();
        $this->dismiss_notice_temporary();
    }

    /**
     * Display notice.
     */
    public function notice() {

        if ( ! current_user_can( 'publish_posts' ) ) {
            return;
        }

        $current_screen = get_current_screen();

        if ( ! $current_screen ) {
            return;
        }

        if (
            'dashboard' !== $current_screen->id &&
            'themes' !== $current_screen->id &&
            'plugins' !== $current_screen->id
        ) {
            return;
        }

        if ( ! $this->is_dismiss_notice() ) {
            $this->notice_markup();
        }
    }

    /**
     * Check if notice dismissed.
     */
    private function is_dismiss_notice() {
        return apply_filters( 'blockspare_' . $this->name . '_notice_dismiss', false );
    }

    /**
     * Notice markup.
     */
    public function notice_markup() {
        echo '';
    }

    /**
     * Permanently dismiss notice.
     */
    public function dismiss_notice() {

        if (
            isset( $_GET['blockspare_setup_notice_dismiss'] ) &&
            isset( $_GET['_blockspare_setup_notice_dismiss_nonce'] )
        ) {

            if (
                ! wp_verify_nonce(
                    wp_unslash( $_GET['_blockspare_setup_notice_dismiss_nonce'] ),
                    'blockspare_setup_notice_dismiss_nonce'
                )
            ) {
                wp_die( esc_html__( 'Action failed. Please refresh the page and retry.', 'blockspare' ) );
            }

            if ( ! current_user_can( 'publish_posts' ) ) {
                wp_die( esc_html__( 'Cheatin&#8217; huh?', 'blockspare' ) );
            }

            $dismiss_notice = sanitize_text_field( wp_unslash( $_GET['blockspare_setup_notice_dismiss'] ) );

            // FIX: Match current notice name dynamically instead of hardcoded 'setup'
            if ( $this->name === $dismiss_notice ) {
                update_user_meta(
                    $this->current_user_id,
                    'blockspare_' . $dismiss_notice . '_notice_dismiss',
                    'yes'
                );
                
                wp_safe_redirect( remove_query_arg( array( 'blockspare_setup_notice_dismiss', '_blockspare_setup_notice_dismiss_nonce' ) ) );
                exit;
            }
        }
    }

    /**
     * Temporarily dismiss notice.
     */
    public function dismiss_notice_temporary() {

        if (
            isset( $_GET['blockspare_setup_notice_dismiss_temporary'] ) &&
            isset( $_GET['_blockspare_setup_notice_dismiss_temporary_nonce'] )
        ) {

            if (
                ! wp_verify_nonce(
                    wp_unslash( $_GET['_blockspare_setup_notice_dismiss_temporary_nonce'] ),
                    'blockspare_setup_notice_dismiss_temporary_nonce'
                )
            ) {
                wp_die( esc_html__( 'Action failed. Please refresh the page and retry.', 'blockspare' ) );
            }

            if ( ! current_user_can( 'publish_posts' ) ) {
                wp_die( esc_html__( 'Cheatin&#8217; huh?', 'blockspare' ) );
            }

            $dismiss_notice = sanitize_text_field( wp_unslash( $_GET['blockspare_setup_notice_dismiss_temporary'] ) );

            // FIX: Match current notice name dynamically instead of hardcoded 'setup'
            if ( $this->name === $dismiss_notice ) {
                update_user_meta(
                    $this->current_user_id,
                    'blockspare_' . $dismiss_notice . '_notice_dismiss_temporary',
                    'yes'
                );
                
                wp_safe_redirect( remove_query_arg( array( 'blockspare_setup_notice_dismiss_temporary', '_blockspare_setup_notice_dismiss_temporary_nonce' ) ) );
                exit;
            }
        }
    }
}

class Blockspare_Setup_Notice extends Blockspare_Setup {

    /**
     * Constructor.
     */
    public function __construct() {

        $dismiss_url = wp_nonce_url(
            add_query_arg(
                'blockspare_setup_notice_dismiss',
                'setup',
                admin_url()
            ),
            'blockspare_setup_notice_dismiss_nonce',
            '_blockspare_setup_notice_dismiss_nonce'
        );

        $temporary_dismiss_url = wp_nonce_url(
            add_query_arg(
                'blockspare_setup_notice_dismiss_temporary',
                'setup',
                admin_url()
            ),
            'blockspare_setup_notice_dismiss_temporary_nonce',
            '_blockspare_setup_notice_dismiss_temporary_nonce'
        );

        parent::__construct(
            'setup',
            'info',
            $dismiss_url,
            $temporary_dismiss_url
        );

        $this->set_notice_time();
        $this->set_temporary_dismiss_notice_time();
        $this->set_dismiss_notice();
    }

    /**
     * Set initial notice time.
     */
    private function set_notice_time() {
        if ( ! get_option( 'blockspare_setup_notice_start_time' ) ) {
            update_option( 'blockspare_setup_notice_start_time', time() );
        }
    }

    /**
     * Set temporary dismiss time.
     */
    private function set_temporary_dismiss_notice_time() {
        if (
            isset( $_GET['blockspare_setup_notice_dismiss_temporary'] ) &&
            'setup' === $_GET['blockspare_setup_notice_dismiss_temporary']
        ) {
            update_user_meta(
                $this->current_user_id,
                'blockspare_setup_notice_dismiss_temporary_start_time',
                time()
            );
        }
    }

    /**
     * Set dismiss conditions.
     */
    public function set_dismiss_notice() {
        $user_id = get_current_user_id();

        $is_permanently_dismissed = ( 'yes' === get_user_meta( $user_id, 'blockspare_setup_notice_dismiss', true ) );
        
        $temporary_dismiss_time   = (int) get_user_meta( $user_id, 'blockspare_setup_notice_dismiss_temporary_start_time', true );
        $is_temporarily_dismissed = ( $temporary_dismiss_time > strtotime( '-2 days' ) );

        // FIX: Clean, predictable condition parsing
        if ( $is_permanently_dismissed || $is_temporarily_dismissed ) {
            add_filter( 'blockspare_setup_notice_dismiss', '__return_true' );
        } else {
            add_filter( 'blockspare_setup_notice_dismiss', '__return_false' );
        }
    }

    /**
     * Notice markup.
     */
    public function notice_markup() {

        if ( ! function_exists( 'get_plugin_data' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
    
        $plugin_data = get_plugin_data( BLOCKSPARE_BASE_FILE );
        $version     = isset( $plugin_data['Version'] ) ? $plugin_data['Version'] : '';
    
        ?>
    
        <div class="notice notice-success blockspare-notice-setup" style="padding: 18px; position: relative;">
    
            <div style="display:flex; justify-content:space-between; gap:20px; align-items:flex-start;">
    
                <div style="flex:1;">
    
                    <h2 style="margin:0 0 8px; font-size:18px; line-height:1.4;">
                        <?php esc_html_e( 'Welcome to BlockSpare 👋', 'blockspare' ); ?>
                    </h2>
    
                    <p style="margin:0 0 12px; font-size:14px; color:#555;">
                    <?php esc_html_e( 'Build professional news, magazine, blog, and business websites faster using ready-made Gutenberg blocks, starter templates, and content-focused layouts.', 'blockspare' ); ?>
                    </p>
    
                    <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:10px;">
    
                        <a
                            class="button button-primary"
                            href="<?php echo esc_url( admin_url( 'post-new.php?post_type=page&blockspare_show_intro=true' ) ); ?>"
                        >
                            <?php esc_html_e( 'Get Started', 'blockspare' ); ?>
                        </a>
    
                        <a
                            class="button"
                            href="<?php echo esc_url( admin_url( 'admin.php?page=blockspare' ) ); ?>"
                        >
                            <?php esc_html_e( 'Browse Templates', 'blockspare' ); ?>
                        </a>
    
                        <a
                            class="button button-secondary"
                            href="<?php echo esc_url( 'https://blockspare.com/' ); ?>"
                            target="_blank"
                        >
                            <?php esc_html_e( 'Learn More', 'blockspare' ); ?>
                        </a>
    
                    </div>
    
                    <?php if ( $version ) : ?>
                        <p style="margin-top:10px; font-size:12px; color:#888;">
                            <?php echo esc_html( 'Version ' . $version ); ?>
                        </p>
                    <?php endif; ?>
    
                </div>
    
                <div style="min-width:120px; text-align:right;">
    
                    <div style="font-size:12px; color:#777; margin-bottom:8px;">
                        <?php esc_html_e( 'Quick Setup', 'blockspare' ); ?>
                    </div>
    
                    <div style="font-size:11px; color:#999;">
                        <?php esc_html_e( 'Takes less than 2 minutes', 'blockspare' ); ?>
                    </div>
    
                </div>
    
            </div>
    
            <a
                class="notice-dismiss"
                href="<?php echo esc_url( $this->dismiss_url ); ?>"
            ></a>
    
        </div>
    
        <?php
    }
}

/**
 * Initialize notice after WordPress admin loads.
 */
function blockspare_setup_notice_init() {

    if ( ! is_admin() ) {
        return;
    }

    new Blockspare_Setup_Notice();
}

add_action( 'admin_init', 'blockspare_setup_notice_init' );