<?php
/**
 * Futurio admin notify
 *
 */
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Futurio_Notify_Admin' ) ) :

	/**
	 * The Futurio admin notify
	 */
	class Futurio_Notify_Admin {

		/**
		 * Setup class.
		 *
		 */
		public function __construct() {

			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'admin_notices', array( $this, 'admin_notices' ), 99 );
			add_action( 'wp_ajax_futurio_dismiss_notice', array( $this, 'dismiss_nux' ) );
			add_action( 'admin_menu', array( $this, 'add_menu' ), 5 );
		}

		/**
		 * Enqueue scripts.
		 *
		 */
		public function enqueue_scripts() {
			global $wp_customize;

			if ( isset( $wp_customize ) || futurio_is_extra_activated() ) {
				return;
			}

			wp_enqueue_style( 'futurio-admin', get_template_directory_uri() . '/css/admin/admin.css', '', '1' );

			wp_enqueue_script( 'futurio-admin', get_template_directory_uri() . '/js/admin/admin.js', array( 'jquery', 'updates' ), '1', 'all' );

			$futurio_notify = array(
				'nonce' => wp_create_nonce( 'futurio_notice_dismiss' )
			);

			wp_localize_script( 'futurio-admin', 'futurioNUX', $futurio_notify );
		}

		/**
		 * Output admin notices.
		 *
		 */
		public function admin_notices() {
			global $pagenow;

			if ( ( 'themes.php' === $pagenow ) && isset( $_GET[ 'page' ] ) && ( 'futurio' === $_GET[ 'page' ] ) || true === (bool) get_option( 'futurio_notify_dismissed' ) || futurio_is_extra_activated() ) {
				return;
			}
			?>

			<div class="notice notice-info futurio-notice-nux is-dismissible">

				<div class="notice-content">
					<?php if ( !futurio_is_extra_activated() && current_user_can( 'install_plugins' ) && current_user_can( 'activate_plugins' ) ) : ?>
						<h2>
							<?php
							/* translators: %s: Theme name */
							printf( esc_html__( 'Thank you for installing %s.', 'futurio' ), '<strong>Futurio</strong>' );
							?>
						</h2>
                                                <p>
							<?php
							/* translators: %s: Plugin name string */
							printf( esc_html__( 'To take full advantage of all the features this theme has to offer, please install and activate the %s plugin.', 'futurio' ), '<strong>Futurio Extra</strong>' );
							?>
						</p>
						<p>
							<a href="<?php echo esc_url( admin_url( 'themes.php?page=futurio' ) ); ?>" class="button button-primary" style="text-decoration: none;">
								<?php
								/* translators: %s: Theme name */
								printf( esc_html__( 'Get started with %s', 'futurio' ), 'Futurio' );
								?>
							</a>
						</p>
					<?php endif; ?>
				</div>
			</div>
			<?php
		}

		public function add_menu() {
			if ( isset( $wp_customize ) || futurio_is_extra_activated() ) {
				return;
			}
			add_theme_page(
			'Futurio', 'Futurio', 'edit_theme_options', 'futurio', array( $this, 'admin_page' )
			);
		}

		public function admin_page() {


			if ( futurio_is_extra_activated() ) {
				return;
			}
			?>

			<div class="notice notice-info sf-notice-nux">
				<span class="sf-icon">
					<?php echo '<img src="' . esc_url( get_template_directory_uri() ) . '/img/futurio-logo.png" width="250" />'; ?>
				</span>

				<div class="notice-content">
					<?php if ( !futurio_is_extra_activated() && current_user_can( 'install_plugins' ) && current_user_can( 'activate_plugins' ) ) : ?>
						<h2>
							<?php
							/* translators: %s: Theme name */
							printf( esc_html__( 'Thank you for installing %s.', 'futurio' ), '<strong>Futurio</strong>' );
							?>
						</h2>
						<p>
							<?php
							/* translators: %s: Plugin name string */
							printf( esc_html__( 'To take full advantage of all the features this theme has to offer, please install and activate the %s plugin.', 'futurio' ), '<strong>Futurio Extra</strong>' );
							?>
						</p>
						<p><?php Futurio_Plugin_Install::install_plugin_button( 'futurio-extra', 'futurio-extra.php', 'Futurio Extra', array( 'sf-nux-button' ), __( 'Activated', 'futurio' ), __( 'Activate', 'futurio' ), __( 'Install', 'futurio' ) ); ?></p>
					<?php endif; ?>


				</div>
			</div>
			<?php
		}

		/**
		 * AJAX dismiss notice.
		 *
		 * @since 2.2.0
		 */
		public function dismiss_nux() {
			$nonce = !empty( $_POST[ 'nonce' ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'nonce' ] ) ) : false;

			if ( !$nonce || !wp_verify_nonce( $nonce, 'futurio_notice_dismiss' ) || !current_user_can( 'manage_options' ) ) {
				die();
			}

			update_option( 'futurio_notify_dismissed', true );
		}

	}

	endif;

return new Futurio_Notify_Admin();
