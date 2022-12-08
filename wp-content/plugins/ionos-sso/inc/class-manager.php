<?php

namespace Ionos\SSO;

// Do not allow direct access!
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Manager class
 */
class Manager {
	const JUMP_HOST_DOMAIN = 'webapps-sso.hosting.ionos.com';
	const WP_PSS_API = 'https://cisapi.hosting.ionos.com/%s/managed-wordpress/provisionings?domain-binding=%s';
	const DEFAULT_OAUTH_ERROR = 'The login process via SSO failed';
	const TRANSIENT_PREFIX = 'ionos_sso_';

	/**
	 * SSO constructor.
	 */
	public function __construct() {
		add_action( 'authenticate', array( $this, 'oauth' ) );
		add_action( 'wp_logout', array( $this, 'cleanup_after_logout' ) );
	}

	/**
	 * Handle oauth process.
	 *
	 * @param  \WP_User|null $user
	 *
	 * @return null | \WP_User
	 */
	public function oauth( $user ) {

		if ( $user instanceof \WP_User) {
			return $user;
		}

		if ( Helper::is_enabled() && isset( $_GET['action'] ) ) {
			switch ( $_GET['action'] ) {

				// Start signing process after recognizing the CP parameter
				case 'ionos_oauth_register':
					$this->register_domain();
					$this->oauth_authenticate();
					break;

				// Validate access after signing on CP
				case 'ionos_oauth_authenticate':
					return $this->validate_user_access();

				default:
					break;
			}
		}

		return null;
	}

	/**
	 * Validate access token coming from CP.
	 *
	 * @return null | \WP_User
	 */
	public function validate_user_access() {

		if ( ! isset( $_GET['access_token'] )
		     || ! isset( $_GET['state'] )
		     || $_GET['state'] !== get_transient( self::TRANSIENT_PREFIX . 'state' )
		) {
			$this->login_error( __( self::DEFAULT_OAUTH_ERROR, 'ionos-sso' ) );
			return null;
		}

		// Decrypt access token.
		$decoded_access_token = $this->decrypt_access_token(
			$_GET['access_token'],
			get_transient( self::TRANSIENT_PREFIX . 'iv' ),
			get_transient( self::TRANSIENT_PREFIX . 'secret' )
		);
		if ( $decoded_access_token === false ) {
			$this->login_error( __( self::DEFAULT_OAUTH_ERROR, 'ionos-sso' ) );
			return null;
		}

		// Validate access token by WordPress PSS.
		$is_valid_access_token = $this->check_customer_access_authorization( $decoded_access_token );

		// If valid, log the first admin user.
		if ( $is_valid_access_token === true ) {
			// Add user information to transient.
			delete_transient( self::TRANSIENT_PREFIX . 'state' );
			delete_transient( self::TRANSIENT_PREFIX . 'secret' );
			delete_transient( self::TRANSIENT_PREFIX . 'iv' );
			set_transient( self::TRANSIENT_PREFIX . 'access_token',
				base64_encode( $decoded_access_token ), 60 * 60 * 2 );

			return $this->get_admin_user();

		} else {
			$this->login_error( __( self::DEFAULT_OAUTH_ERROR, 'ionos-sso' ) );
		}

		return null;
	}

	/**
	 * Register Domain to JumpHost and store keys into the session.
	 * The keys are needed to encrypt access_token
	 */
	private function register_domain() {
		$oauth_register_result = $this->oauth_register();

		set_transient( self::TRANSIENT_PREFIX . 'state',
			$oauth_register_result['state'], 7200 );
		set_transient( self::TRANSIENT_PREFIX . 'secret',
			$oauth_register_result['secret'], 600 );
		set_transient( self::TRANSIENT_PREFIX . 'iv',
			$oauth_register_result['iv'], 600 );
	}

	/**
	 * Redirect to IONOS OAuth login form.
	 *
	 * @return mixed [ $state, $iv, $secret ]
	 */
	private function oauth_register() {
		//parse url parameters to array
		! empty ( $_GET['redirect_to'] )
			? parse_str(parse_url( $_GET['redirect_to'], PHP_URL_QUERY), $param_array)
			: $param_array = $_GET;

		$param_array = array_merge( $param_array, array( 'action' => 'ionos_oauth_authenticate' ) );

		try {
			$response = wp_remote_post(
				'https://' . self::JUMP_HOST_DOMAIN . '/api/wordpress/register',
				array(
					'method' => 'POST',
					'body'   => array(
						'wp_callback' => add_query_arg(
							$param_array,
							wp_login_url()
						),
						'market'      => \Ionos\SSO\Options::get_market(),
					),
				)
			);
		} catch ( Exception $e ) {
			$this->login_error( __( self::DEFAULT_OAUTH_ERROR, 'ionos-sso' ) );
			return null;
		}

		if ( is_array( $response ) && isset( $response['response'] )
		     && isset( $response['response']['code'] )
		     && 200 === $response['response']['code']
		     && is_array( $response_decoded = json_decode( $response['body'], true ) )
		     && isset( $response_decoded['state'], $response_decoded['secret'], $response_decoded['iv'] )
		) {
			return $response_decoded;
		} else {
			$this->login_error( __( self::DEFAULT_OAUTH_ERROR, 'ionos-sso' ) );
			return null;
		}
	}

	/**
	 * Throw error message.
	 *
	 * @param  string $msg
	 */
	private function login_error( string $msg = '' ) {
		add_filter(
			'wp_login_errors',
			function ( $errors ) use ( $msg ) {
				$errors->add(
					'ionos_oauth_error',
					'<strong>Error</strong>: ' . $msg
				);
				return $errors;
			}
		);
	}

	/**
	 * Redirect to jumphost.
	 */
	private function oauth_authenticate() {
		$param = [
			'state'  => get_transient( self::TRANSIENT_PREFIX . 'state' ),
			'action' => 'ionos_oauth_authenticate',
		];
		wp_redirect( 'https://' . self::JUMP_HOST_DOMAIN . '/wordpress/login?' . http_build_query( $param ) );
	}

	/**
	 * Decrypt the access token.
	 *
	 * @param  string  $string  // String that have to decrypted.
	 * @param  string  $iv  // Individual value needed for decrypting.
	 * @param  string  $secret  // needed for decrypting.
	 *
	 * @return string|false
	 */
	private function decrypt_access_token( string $string, string $iv, string $secret ) {
		return openssl_decrypt( $string, 'AES-256-CBC', $secret, 0, $iv );
	}

	/**
	 * Validate access token via WP_PSS_API
	 *
	 * @param  string|null $access_token  // Decrypted access token.
	 *
	 * @return bool
	 */
	private function check_customer_access_authorization(
		string $access_token = null
	) {
		if ( is_null( $access_token ) ) {
			return false;
		}

		$customer_domain = parse_url( filter_var( get_home_url(),
			FILTER_VALIDATE_URL ), PHP_URL_HOST );

		$response = wp_remote_get(
			sprintf(
				self::WP_PSS_API,
				self::JUMP_HOST_DOMAIN,
				$customer_domain
			),
			array(
				'headers' => array(
					'Authorization' => 'Bearer ' . $access_token,
				),
			)
		);

		if ( isset( $response['response']['code'] )
		     && 200 === $response['response']['code']
		) {
			$provisions = json_decode( $response['body'], true );

			return $this->validate_provisioning( $provisions,
				$customer_domain );
		}

		return false;
	}

	/**
	 * @param array $provisions
	 * @param string | null $customer_domain
	 *
	 * @return bool
	 */
	private function validate_provisioning(
		array $provisions = [],
		string $customer_domain = null
	) {
		if ( empty( $provisions ) || is_null( $customer_domain ) ) {
			return false;
		}

		foreach ( $provisions as $provisioning ) {
			if ( isset( $provisioning['projects'] ) ) {
				foreach ( $provisioning['projects'] as $project ) {
					if ( isset( $project['domain_binding'] )
					     && $project['domain_binding'] === $customer_domain
					) {
						return true;
					}
				}
			}
		}

		return false;
	}

	/**
	 * Remove session parameter and revoke access token by jumphost.
	 */
	public function cleanup_after_logout() {
		$access_token = get_transient( self::TRANSIENT_PREFIX
		                               . 'access_token' );
		wp_remote_post(
			'https://' . self::JUMP_HOST_DOMAIN . '/api/wordpress/revoke',
			array(
				'headers' => array(
					'Authorization' => 'Bearer ' . $access_token,
				),
			)
		);
		delete_transient( self::TRANSIENT_PREFIX . 'state' );
		delete_transient( self::TRANSIENT_PREFIX . 'secret' );
		delete_transient( self::TRANSIENT_PREFIX . 'iv' );
	}

	/**
	 * Login first admin user
	 *
	 * @return null | \WP_User
	 */
	public function get_admin_user() {
		foreach ( get_users() as $user ) {
			if ( user_can( $user->ID, 'administrator' ) ) {
				return $user;
			}
		}
		$this->login_error( __( self::DEFAULT_OAUTH_ERROR, 'ionos-sso' ) );
		return null;
	}
}