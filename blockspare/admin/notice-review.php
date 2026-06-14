<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Blockspare_Review_Notice extends Blockspare_Setup {

    /**
     * Constructor.
     */
    public function __construct() {

        // Setup dismissal arguments mapped to 'review' action
        $dismiss_url = wp_nonce_url(
            add_query_arg(
                'blockspare_setup_notice_dismiss',
                'review',
                admin_url()
            ),
            'blockspare_review_notice_dismiss_nonce',
            '_blockspare_review_notice_dismiss_nonce'
        );

        $temporary_dismiss_url = wp_nonce_url(
            add_query_arg(
                'blockspare_setup_notice_dismiss_temporary',
                'review',
                admin_url()
            ),
            'blockspare_review_notice_dismiss_temporary_nonce',
            '_blockspare_review_notice_dismiss_temporary_nonce'
        );

        parent::__construct(
            'review',
            'info',
            $dismiss_url,
            $temporary_dismiss_url
        );

        $this->set_notice_time();
        $this->set_temporary_dismiss_notice_time();
        $this->set_dismiss_notice();
    }

    /**
     * Set initial notice time (e.g., to delay showing it right after installation).
     */
    private function set_notice_time() {
        if ( ! get_option( 'blockspare_review_notice_start_time' ) ) {
            update_option( 'blockspare_review_notice_start_time', time() );
        }
    }

    /**
     * Set temporary dismiss time (Snooze).
     */
    private function set_temporary_dismiss_notice_time() {
        if (
            isset( $_GET['blockspare_setup_notice_dismiss_temporary'] ) &&
            'review' === $_GET['blockspare_setup_notice_dismiss_temporary']
        ) {
            update_user_meta(
                $this->current_user_id,
                'blockspare_review_notice_dismiss_temporary_start_time',
                time()
            );
        }
    }

    /**
     * Set dismiss conditions.
     */
    public function set_dismiss_notice() {
        $user_id = get_current_user_id();

        $is_permanently_dismissed = ( 'yes' === get_user_meta( $user_id, 'blockspare_review_notice_dismiss', true ) );
        
        $temporary_dismiss_time   = (int) get_user_meta( $user_id, 'blockspare_review_notice_dismiss_temporary_start_time', true );
        // Review notices usually have a longer snooze period (e.g., 7 days instead of 2)
        $is_temporarily_dismissed = ( $temporary_dismiss_time > strtotime( '-7 days' ) );

        // Delay displaying the review notice until the plugin has been active for at least 3 days
        $start_time = (int) get_option( 'blockspare_upgrade_notice_start_time', time() );
        // $is_too_early = ( $start_time > strtotime( '-3 days' ) );
        $is_too_early = ( $start_time > strtotime( '1 min' ) );

        if ( $is_permanently_dismissed || $is_temporarily_dismissed || $is_too_early ) {
            add_filter( 'blockspare_review_notice_dismiss', '__return_true' );
        } else {
            add_filter( 'blockspare_review_notice_dismiss', '__return_false' );
        }
    }

    /**
     * Notice markup.
     */
    public function notice_markup() {
        $review_url = 'https://wordpress.org/support/plugin/blockspare/reviews/?filter=5';
        ?>
        <div class="notice notice-info blockspare-notice-review" style="padding:24px; position:relative; border-left:4px solid #10b981; background:#fff;">

            <div style="display:flex; justify-content:space-between; gap:28px; align-items:flex-start; flex-wrap:wrap;">

                <div style="flex:1; min-width:300px;">

                    <div style="display:inline-flex; align-items:center; gap:4px; background:#f0fdf4; color:#15803d; padding:4px 12px; border-radius:30px; font-size:12px; font-weight:600; margin-bottom:14px;">
                        <span class="dashicons dashicons-star-filled" style="font-size:14px; width:14px; height:14px; color:#f59e0b;"></span>
                        <?php esc_html_e( 'Loving Blockspare?', 'blockspare' ); ?>
                    </div>

                    <h2 style="margin:0 0 12px; font-size:24px; line-height:1.4; font-weight:700; color:#1e293b;">
                        <?php esc_html_e( 'Share Your Experience with the WordPress Community!', 'blockspare' ); ?>
                    </h2>

                    <p style="margin:0 0 20px; font-size:14px; color:#475569; max-width:920px; line-height:1.8;">
                        <?php esc_html_e( 'We hope Blockspare is helping you build beautiful web pages effortlessly. As an independent team, your feedback keeps us motivated to push new features, keep updates free, and maintain great performance. If you enjoy using it, would you mind spending 1 minute to leave us a review?', 'blockspare' ); ?>
                    </p>

                    <div style="display:flex; flex-wrap:wrap; gap:12px; align-items:center;">

                        <a
                            class="button button-primary"
                            style="background:#10b981; border-color:#10b981; box-shadow:none; text-shadow:none;"
                            href="<?php echo esc_url( $review_url ); ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            <?php esc_html_e( 'Leave a Review', 'blockspare' ); ?>
                        </a>

                        <a
                            class="button"
                            href="<?php echo esc_url( $this->temporary_dismiss_url ); ?>"
                        >
                            <?php esc_html_e( 'Maybe later, remind me', 'blockspare' ); ?>
                        </a>

                        <a
                            class="button"
                            style="color:#64748b; text-decoration:none;"
                            href="<?php echo esc_url( $this->dismiss_url ); ?>"
                        >
                            <?php esc_html_e( 'No thanks, don\'t show again', 'blockspare' ); ?>
                        </a>

                    </div>

                </div>

                <div style="width:240px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:18px; text-align:center;">

                    <div style="font-size:32px; line-height:1; margin-bottom:10px; color:#f59e0b; display:flex; justify-content:center; gap:2px;">
                        <span class="dashicons dashicons-star-filled" style="font-size:28px; width:28px; height:28px;"></span>
                        <span class="dashicons dashicons-star-filled" style="font-size:28px; width:28px; height:28px;"></span>
                        <span class="dashicons dashicons-star-filled" style="font-size:28px; width:28px; height:28px;"></span>
                        <span class="dashicons dashicons-star-filled" style="font-size:28px; width:28px; height:28px;"></span>
                        <span class="dashicons dashicons-star-filled" style="font-size:28px; width:28px; height:28px;"></span>
                    </div>

                    <div style="font-size:13px; font-weight:600; color:#334155; margin-bottom:6px;">
                        <?php esc_html_e( 'Help Us Grow', 'blockspare' ); ?>
                    </div>

                    <p style="margin:0; color:#64748b; line-height:1.5; font-size:12px;">
                        <?php esc_html_e( 'Every review brings valuable visibility to our free plugin.', 'blockspare' ); ?>
                    </p>

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
function blockspare_review_notice_init() {

    if ( ! is_admin() ) {
        return;
    }

    new Blockspare_Review_Notice();
}

add_action( 'admin_init', 'blockspare_review_notice_init' );