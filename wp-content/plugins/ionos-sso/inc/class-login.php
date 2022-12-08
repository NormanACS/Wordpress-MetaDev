<?php

namespace Ionos\SSO;

// Do not allow direct access!
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Login class
 */
class Login {

	/**
	 * Login constructor.
	 */
	public function __construct() {
		add_action( 'login_form', array( $this, 'show_login_link' ) );
		add_filter( 'login_url', array( $this, 'add_login_url_parameter' ) );
		add_action( 'login_enqueue_scripts', array( $this, 'enqueue_sso_resources' ) );
	}

	/**
	 * Enqueue styles
	 */
	public function enqueue_sso_resources() {
		if ( Helper::is_enabled() ) {
			wp_enqueue_style(
				'ionos-sso-css',
				Helper::get_css_url( 'ionos-sso-login.css' ),
				array(),
				filemtime( Helper::get_css_path('ionos-sso-login.css') )
			);
		}
	}

	/**
	 * Add filter to transfer any "action=ionos_oauth_register" parameter to the login URL
	 *
	 * @param string $login_url
	 *
	 * @return string
	 */
	public function add_login_url_parameter( string $login_url ) {

		if ( isset( $_GET['action'] ) && $_GET['action'] === 'ionos_oauth_register' ) {
			return add_query_arg(
				array(
					'action' => 'ionos_oauth_register',
				),
				$login_url
			);
		} else {
			return $login_url;
		}
	}

	/**
	 * Build Single Sign-on link in WP Login screen
	 */
	public function show_login_link() {
		$login_html = '';

		if ( Helper::is_enabled() ) {
			$sso_login_url = add_query_arg(
				array(
					'action' => 'ionos_oauth_register',
				)
			);

			$login_html .= '<p class="submit"><input type="submit" name="wp-submit" class="button button-primary button-large" id="sso_default_login" value="'
			               . __( 'Log in via WordPress', 'ionos-sso' )
			               . '" /></p>';
			$login_html .= '<p class="sso-login-or">
					<span>
						' . __( 'OR', 'ionos-sso' ) . '
					</span>
				</p>';
			$login_html .= '<p class="sso-login-link">
					<a href="' . esc_url( $sso_login_url ) . '" id="sso-login-link" class="button button-secondary button-large">
						' . __( 'Log in via IONOS', 'ionos-sso' ) . '
					</a>
				</p>
			';
		}

		echo $login_html;
	}
}
