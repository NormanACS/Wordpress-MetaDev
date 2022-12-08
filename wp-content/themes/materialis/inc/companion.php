<?php

namespace Materialis;

class Companion_Plugin {
	public static $plugin_state;
	public static $config = array();
	private static $instance = false;
	private static $slug;

	public function __construct( $config ) {
		self::$config = $config;
		self::$slug   = $config['slug'];
		add_action( 'tgmpa_register', array( __CLASS__, 'tgma_register' ) );
		add_action( 'wp_ajax_companion_disable_popup', array( __CLASS__, 'companion_disable_popup' ) );

		if ( get_template() === get_stylesheet() ) {

			if ( ! get_option( 'materialis_companion_disable_popup', false ) ) {
				if ( ! apply_filters( 'materialis_is_companion_installed', false ) ) {
					global $pagenow;
					if ( $pagenow !== "update.php" ) {
						add_action( 'admin_notices', array( __CLASS__, 'plugin_notice' ) );
						add_action( 'admin_head', function () {
							wp_enqueue_style( 'materialis_customizer.css',
								get_template_directory_uri() . '/customizer/css/companion-install.css' );
						} );
					}
				}
			}
		}

	}

	public static function plugin_notice() {
		?>
        <div class="notice notice-success is-dismissible materialis-welcome-notice">
            <div class="notice-content-wrapper">
				<?php materialis_require( "/customizer/start-with-frontpage.php" ); ?>
            </div>
        </div>
		<?php
	}

	public static function companion_disable_popup() {
		$nonce = isset( $_POST['companion_disable_popup_wpnonce'] ) ? $_POST['companion_disable_popup_wpnonce'] : '';

		$nonce = wp_unslash( $nonce );

		if ( ! wp_verify_nonce( $nonce, "companion_disable_popup" ) ) {
			die( "wrong nonce" );
		}

		$value  = isset( $_POST['value'] ) ? $_POST['value'] : false;
		$value  = wp_unslash( $value );
		$value  = intval( $value );
		$option = isset( $_POST['option'] ) ? wp_unslash( $_POST['option'] ) : "materialis_companion_disable_popup";

		update_option( $option, $value );
	}

	public static function tgma_register() {
		self::$plugin_state = self::get_plugin_state( self::$slug );
	}

	public static function get_plugin_state( $plugin_slug ) {
		$tgmpa     = \TGM_Plugin_Activation::get_instance();
		$installed = $tgmpa->is_plugin_installed( $plugin_slug );

		return array(
			'installed' => $installed,
			'active'    => $installed && $tgmpa->is_plugin_active( $plugin_slug ),
		);
	}

	public static function output_companion_message() {
		wp_enqueue_style( 'materialis_customizer_css',
			get_template_directory_uri() . '/customizer/css/companion-install.css' );
		wp_enqueue_script( 'materialis_customizer_js',
			get_template_directory_uri() . '/customizer/js/companion-install.js', array( 'jquery' ), false, true );
		?>
        <div id="extend-themes-companion-popover" style="display:none">
            <div class="extend-themes-companion-popover-close dashicons dashicons-no-alt"></div>
            <div class="extend-themes-companion-popover-wrapper">
                <p class="extend-themes-companion-popover-message">
					<?php esc_html_e( 'Please Install the Materialis Companion Plugin to Enable All the Theme Features',
						'materialis' ) ?>
                </p>
                <div class="extend-themes-companion-popover-actions">
					<?php
					if ( \Materialis\Companion_Plugin::$plugin_state['installed'] ) {
						$link  = \Materialis\Companion_Plugin::get_activate_link();
						$label = esc_html__( 'Activate now', 'materialis' );
					} else {
						$link  = \Materialis\Companion_Plugin::get_install_link();
						$label = esc_html__( 'Install now', 'materialis' );
					}
					printf( '<a class="install-now button button-large button-orange" href="%1$s">%2$s</a>',
						esc_url( $link ), $label );
					?>
                </div>
            </div>
        </div>
		<?php
	}

	public static function get_activate_link( $slug = false ) {
		if ( ! $slug ) {
			$slug = self::$slug;
		}
		$tgmpa = \TGM_Plugin_Activation::get_instance();
		$path  = $tgmpa->plugins[ $slug ]['file_path'];

		return add_query_arg( array(
			'action'        => 'activate',
			'plugin'        => rawurlencode( $path ),
			'plugin_status' => 'all',
			'paged'         => '1',
			'_wpnonce'      => wp_create_nonce( 'activate-plugin_' . $path ),
		), network_admin_url( 'plugins.php' ) );
	}

	public static function get_install_link( $slug = false ) {
		if ( ! $slug ) {
			$slug = self::$slug;
		}

		return add_query_arg(
			array(
				'action'   => 'install-plugin',
				'plugin'   => $slug,
				'_wpnonce' => wp_create_nonce( 'install-plugin_' . $slug ),
			),
			network_admin_url( 'update.php' )
		);
	}

	public static function check_companion( $wp_customize ) {
		$plugin_state = self::$plugin_state;

		if ( ! $plugin_state ) {
			return;
		}

		if ( ! $plugin_state['installed'] || ! $plugin_state['active'] ) {
			$wp_customize->add_setting( 'companion_install', array(
				'default'           => '',
				'sanitize_callback' => 'esc_attr',
			) );


			if ( ! $plugin_state['installed'] ) {
				$wp_customize->add_control(
					new Install_Companion_Control(
						$wp_customize,
						'materialis_page_content',
						array(
							'section'      => 'page_content',
							'settings'     => 'companion_install',
							'label'        => self::$config['install_label'],
							'msg'          => self::$config['install_msg'],
							'plugin_state' => $plugin_state,
							'slug'         => self::$slug,
						)
					)
				);
			} else {
				$wp_customize->add_control(
					new Activate_Companion_Control(
						$wp_customize,
						'materialis_page_content',
						array(
							'section'      => 'page_content',
							'settings'     => 'companion_install',
							'label'        => self::$config['activate_label'],
							'msg'          => self::$config['activate_msg'],
							'plugin_state' => $plugin_state,
							'slug'         => self::$slug,
						)
					)
				);
			}

			Companion_Plugin::show_companion_popup( $plugin_state );
		}
	}

	public static function show_companion_popup() {

		add_action( 'customize_controls_print_footer_scripts',
			array( '\Materialis\Companion_Plugin', 'output_companion_message' ) );
	}

	// static functions

	public static function init( $config ) {
		Companion_Plugin::getInstance( $config );
	}

	public static function getInstance( $config ) {
		if ( ! self::$instance ) {
			self::$instance = new Companion_Plugin( $config );
		}

		return self::$instance;
	}
}
