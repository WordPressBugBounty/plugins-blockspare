<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Blockspare_Upgrade_Notice extends Blockspare_Setup {

    /**
     * Constructor.
     */
    public function __construct() {

        // FIX: Replaced 'blockspare_notice_dismiss' with 'blockspare_setup_notice_dismiss' to match parent architecture
        $dismiss_url = wp_nonce_url(
            add_query_arg(
                'blockspare_setup_notice_dismiss',
                'upgrade',
                admin_url()
            ),
            'blockspare_upgrade_notice_dismiss_nonce',
            '_blockspare_upgrade_notice_dismiss_nonce'
        );

        $temporary_dismiss_url = wp_nonce_url(
            add_query_arg(
                'blockspare_setup_notice_dismiss_temporary',
                'upgrade',
                admin_url()
            ),
            'blockspare_upgrade_notice_dismiss_temporary_nonce',
            '_blockspare_upgrade_notice_dismiss_temporary_nonce'
        );

        parent::__construct(
            'upgrade',
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
        if ( ! get_option( 'blockspare_upgrade_notice_start_time' ) ) {
            update_option( 'blockspare_upgrade_notice_start_time', time() );
        }
    }

    /**
     * Set temporary dismiss time.
     */
    private function set_temporary_dismiss_notice_time() {
        // FIX: Aligned parameter string check with parent class
        if (
            isset( $_GET['blockspare_setup_notice_dismiss_temporary'] ) &&
            'upgrade' === $_GET['blockspare_setup_notice_dismiss_temporary']
        ) {
            update_user_meta(
                $this->current_user_id,
                'blockspare_upgrade_notice_dismiss_temporary_start_time',
                time()
            );
        }
    }

    /**
     * Set dismiss conditions.
     */
    public function set_dismiss_notice() {
        $user_id = get_current_user_id();

        $is_permanently_dismissed = ( 'yes' === get_user_meta( $user_id, 'blockspare_upgrade_notice_dismiss', true ) );
        
        $temporary_dismiss_time   = (int) get_user_meta( $user_id, 'blockspare_upgrade_notice_dismiss_temporary_start_time', true );
        $is_temporarily_dismissed = ( $temporary_dismiss_time > strtotime( '-2 days' ) );

        // FIX: Evaluates user meta correctly without loops or instant expiration loops
        if ( $is_permanently_dismissed || $is_temporarily_dismissed ) {
            add_filter( 'blockspare_upgrade_notice_dismiss', '__return_true' );
        } else {
            add_filter( 'blockspare_upgrade_notice_dismiss', '__return_false' );
        }
    }

    /**
     * Notice markup.
     */
    public function notice_markup() {
        ?>
        <div class="notice notice-info blockspare-notice-upgrade" style="padding:24px; position:relative; border-left:4px solid #2271b1; background:#fff;">

            <div style="display:flex; justify-content:space-between; gap:28px; align-items:flex-start; flex-wrap:wrap;">

                <div style="flex:1; min-width:300px;">

                    <div style="display:inline-block; background:#e8f2ff; color:#2271b1; padding:4px 10px; border-radius:30px; font-size:12px; font-weight:600; margin-bottom:14px;">
                        <?php esc_html_e( 'Upgrade Available', 'blockspare' ); ?>
                    </div>

                    <h2 style="margin:0 0 12px; font-size:24px; line-height:1.4; font-weight:700;">
                        <?php esc_html_e( 'Unlock More Power with Blockspare Pro', 'blockspare' ); ?>
                    </h2>

                    <p style="margin:0 0 16px; font-size:14px; color:#555; max-width:920px; line-height:1.8;">
                        <?php esc_html_e( 'Get access to premium templates, advanced post layouts, extra design blocks, and more control over how your content looks. Blockspare Pro helps you build faster and create richer pages with less effort.', 'blockspare' ); ?>
                    </p>

                    <div style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom:18px;">

                        <span style="background:#f6f7f7; padding:7px 12px; border-radius:5px; font-size:12px;">
                            <?php esc_html_e( 'Premium Templates', 'blockspare' ); ?>
                        </span>

                        <span style="background:#f6f7f7; padding:7px 12px; border-radius:5px; font-size:12px;">
                            <?php esc_html_e( 'Advanced Post Layouts', 'blockspare' ); ?>
                        </span>

                        <span style="background:#f6f7f7; padding:7px 12px; border-radius:5px; font-size:12px;">
                            <?php esc_html_e( 'More Blocks & Sections', 'blockspare' ); ?>
                        </span>

                        <span style="background:#f6f7f7; padding:7px 12px; border-radius:5px; font-size:12px;">
                            <?php esc_html_e( 'Extra Design Controls', 'blockspare' ); ?>
                        </span>

                        <span style="background:#f6f7f7; padding:7px 12px; border-radius:5px; font-size:12px;">
                            <?php esc_html_e( 'Faster Website Building', 'blockspare' ); ?>
                        </span>

                    </div>

                    <div style="display:flex; flex-wrap:wrap; gap:10px; align-items:center;">

                        <a
                            class="button button-primary"
                            href="<?php echo esc_url( $this->pricing_url ); ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            <?php esc_html_e( 'Upgrade to Pro', 'blockspare' ); ?>
                        </a>

                        <a
                            class="button"
                            href="<?php echo esc_url( 'https://www.blockspare.com/' ); ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            <?php esc_html_e( 'View Features', 'blockspare' ); ?>
                        </a>

                        <a
                            class="button button-secondary plain"
                            href="<?php echo esc_url( $this->temporary_dismiss_url ); ?>"
                        >
                            <?php esc_html_e( 'Maybe later', 'blockspare' ); ?>
                        </a>

                        <a
                            class="button button-secondary plain"
                            href="<?php echo esc_url( 'https://afthemes.com/supports/' ); ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            <?php esc_html_e( 'Need help?', 'blockspare' ); ?>
                        </a>

                    </div>

                </div>

                <div style="width:240px; background:#f8fbff; border:1px solid #dcdcde; border-radius:12px; padding:18px;">

                    <div style="font-size:13px; font-weight:600; color:#2271b1; margin-bottom:12px;">
                        <?php esc_html_e( 'Why upgrade?', 'blockspare' ); ?>
                    </div>

                    <ul style="margin:0; padding-left:18px; color:#555; line-height:1.8; font-size:13px;">
                        <li><?php esc_html_e( 'Access premium layouts and demos', 'blockspare' ); ?></li>
                        <li><?php esc_html_e( 'Create richer post displays', 'blockspare' ); ?></li>
                        <li><?php esc_html_e( 'Get more design flexibility', 'blockspare' ); ?></li>
                        <li><?php esc_html_e( 'Build pages faster with less effort', 'blockspare' ); ?></li>
                    </ul>

                </div>

            </div>

            <a class="blockspare-notice-dismiss notice-dismiss" href="<?php echo esc_url( $this->dismiss_url ); ?>"></a>
        </div>
        <?php
    }
}

/**
 * Initialize notice.
 */
function blockspare_upgrade_notice_init() {

    if ( ! is_admin() ) {
        return;
    }

    new Blockspare_Upgrade_Notice();
}

add_action( 'admin_init', 'blockspare_upgrade_notice_init' );