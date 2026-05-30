<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Blockspare_NewSpare_Notice extends Blockspare_Setup {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$dismiss_url = wp_nonce_url(
			add_query_arg(
				'blockspare_setup_notice_dismiss',
				'newspare',
				admin_url()
			),
			'blockspare_setup_notice_dismiss_nonce',
			'_blockspare_setup_notice_dismiss_nonce'
		);

		$temporary_dismiss_url = wp_nonce_url(
			add_query_arg(
				'blockspare_setup_notice_dismiss_temporary',
				'newspare',
				admin_url()
			),
			'blockspare_setup_notice_dismiss_temporary_nonce',
			'_blockspare_setup_notice_dismiss_temporary_nonce'
		);

		parent::__construct(
			'newspare',
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

		if ( ! get_option( 'blockspare_newspare_notice_start_time' ) ) {
			update_option( 'blockspare_newspare_notice_start_time', time() );
		}
	}

	/**
	 * Set temporary dismiss time.
	 */
	private function set_temporary_dismiss_notice_time() {

		if (
			isset( $_GET['blockspare_setup_notice_dismiss_temporary'] ) &&
			'newspare' === $_GET['blockspare_setup_notice_dismiss_temporary']
		) {

			update_user_meta(
				$this->current_user_id,
				'blockspare_newspare_notice_dismiss_temporary_start_time',
				time()
			);
		}
	}

	/**
	 * Set dismiss conditions.
	 */
	public function set_dismiss_notice() {

		if (
			get_option( 'blockspare_newspare_notice_start_time' ) > strtotime( '-1 min' ) ||
			get_user_meta(
				get_current_user_id(),
				'blockspare_newspare_notice_dismiss',
				true
			) ||
			get_user_meta(
				get_current_user_id(),
				'blockspare_newspare_notice_dismiss_temporary_start_time',
				true
			) > strtotime( '-7 days' )
		) {

			add_filter(
				'blockspare_newspare_notice_dismiss',
				'__return_true'
			);

		} else {

			add_filter(
				'blockspare_newspare_notice_dismiss',
				'__return_false'
			);
		}
	}

	/**
	 * Get NewSpare action button.
	 */
	private function get_newspare_action() {

		$theme = wp_get_theme( 'newspare' );

		// Already active.
		if ( 'newspare' === get_stylesheet() ) {

			return array(
				'url'  => admin_url( 'site-editor.php' ),
				'text' => __( 'Open Site Editor', 'blockspare' ),
			);
		}

		// Installed but inactive.
		if ( $theme->exists() ) {

			return array(
				'url'  => wp_nonce_url(
					admin_url( 'themes.php?action=activate&stylesheet=newspare' ),
					'switch-theme_newspare'
				),
				'text' => __( 'Activate NewSpare', 'blockspare' ),
			);
		}

		// Not installed.
		return array(
			'url'  => wp_nonce_url(
				self_admin_url( 'update.php?action=install-theme&theme=newspare' ),
				'install-theme_newspare'
			),
			'text' => __( 'Install & Activate NewSpare', 'blockspare' ),
		);
	}

	/**
	 * Notice markup.
	 */
	public function notice_markup() {

		$action = $this->get_newspare_action();

		?>

		<div
			class="notice notice-info blockspare-notice-newspare"
			style="
				padding:24px;
				position:relative;
				border-left:4px solid #2271b1;
				background:#fff;
			"
		>

			<div
				style="
					display:flex;
					justify-content:space-between;
					gap:30px;
					align-items:flex-start;
					flex-wrap:wrap;
				"
			>

				<!-- Left Content -->
				<div style="flex:1; min-width:300px;">

					<div
						style="
							display:inline-block;
							background:#e8f2ff;
							color:#2271b1;
							padding:4px 10px;
							border-radius:30px;
							font-size:12px;
							font-weight:600;
							margin-bottom:14px;
						"
					>
						<?php esc_html_e( 'Recommended Block Theme', 'blockspare' ); ?>
					</div>

					<h2
						style="
							margin:0 0 12px;
							font-size:24px;
							line-height:1.4;
							font-weight:700;
						"
					>
						<?php esc_html_e( 'Build Faster with NewSpare 🚀', 'blockspare' ); ?>
					</h2>

					<p
						style="
							margin:0 0 16px;
							font-size:14px;
							color:#555;
							max-width:900px;
							line-height:1.8;
						"
					>
						<?php esc_html_e( 'NewSpare is a modern Full Site Editing WordPress theme built for news, magazine, blogs, and business websites. It works seamlessly with BlockSpare blocks, patterns, and starter templates — helping you launch professional websites visually with Gutenberg.', 'blockspare' ); ?>
					</p>

					<div
						style="
							display:flex;
							flex-wrap:wrap;
							gap:8px;
							margin-bottom:18px;
						"
					>

						<span style="background:#f6f7f7; padding:7px 12px; border-radius:5px; font-size:12px;">
							⚡ Full Site Editing
						</span>

						<span style="background:#f6f7f7; padding:7px 12px; border-radius:5px; font-size:12px;">
							📰 News & Magazine Ready
						</span>

						<span style="background:#f6f7f7; padding:7px 12px; border-radius:5px; font-size:12px;">
							🌙 Light & Dark Mode
						</span>

						<span style="background:#f6f7f7; padding:7px 12px; border-radius:5px; font-size:12px;">
							🛒 WooCommerce Support
						</span>

						<span style="background:#f6f7f7; padding:7px 12px; border-radius:5px; font-size:12px;">
							⚙ Gutenberg Optimized
						</span>

						<span style="background:#f6f7f7; padding:7px 12px; border-radius:5px; font-size:12px;">
							📱 Responsive Design
						</span>

					</div>

					<div
						style="
							display:flex;
							flex-wrap:wrap;
							gap:10px;
							align-items:center;
						"
					>

						<a
							class="button button-primary"
							href="<?php echo esc_url( $action['url'] ); ?>"
						>
							<?php echo esc_html( $action['text'] ); ?>
						</a>

						<a
							class="button"
							target="_blank"
							href="<?php echo esc_url( 'https://afthemes.com/products/newspare/' ); ?>"
						>
							<?php esc_html_e( 'Theme Details', 'blockspare' ); ?>
						</a>

						<a
							class="button button-secondary"
							target="_blank"
							href="<?php echo esc_url( 'https://wordpress.org/themes/newspare/' ); ?>"
						>
							<?php esc_html_e( 'Live Preview', 'blockspare' ); ?>
						</a>

					</div>

				</div>

				<!-- Right Side -->
				<div
					style="
						width:220px;
						background:#f8fbff;
						border:1px solid #dcdcde;
						border-radius:10px;
						padding:18px;
					"
				>

					<div
						style="
							font-size:13px;
							font-weight:600;
							color:#2271b1;
							margin-bottom:12px;
						"
					>
						<?php esc_html_e( 'Why NewSpare?', 'blockspare' ); ?>
					</div>

					<ul
						style="
							margin:0;
							padding-left:18px;
							color:#555;
							line-height:1.8;
							font-size:13px;
						"
					>
						<li><?php esc_html_e( 'Designed for Gutenberg', 'blockspare' ); ?></li>
						<li><?php esc_html_e( 'Works perfectly with BlockSpare', 'blockspare' ); ?></li>
						<li><?php esc_html_e( 'Professional starter sites included', 'blockspare' ); ?></li>
						<li><?php esc_html_e( 'Optimized for speed & SEO', 'blockspare' ); ?></li>
					</ul>

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
 * Initialize notice.
 */
function blockspare_newspare_notice_init() {

	if ( ! is_admin() ) {
		return;
	}

	new Blockspare_NewSpare_Notice();
}

add_action(
	'admin_init',
	'blockspare_newspare_notice_init'
);

/**
 * Redirect to Site Editor after activating NewSpare.
 */
function blockspare_newspare_redirect_to_editor() {

	if ( 'newspare' !== get_stylesheet() ) {
		return;
	}

	if ( ! isset( $_GET['activate'] ) ) {
		return;
	}

	wp_safe_redirect(
		admin_url( 'site-editor.php' )
	);

	exit;
}

add_action(
	'after_switch_theme',
	'blockspare_newspare_redirect_to_editor'
);