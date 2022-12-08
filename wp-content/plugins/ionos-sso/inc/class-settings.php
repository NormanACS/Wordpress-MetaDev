<?php
/*
Plugin Name:  IONOS SSO
Plugin URI:   https://www.ionos.com
Description:  SSO for WordPress
Version:
License:      GPLv2 or later
Author:       IONOS
Author URI:   https://www.ionos.com
Text Domain:  ionos-sso
@package ionos-sso
*/

namespace Ionos\SSO;

// Do not allow direct access!

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Settings class.
 */
class Settings {
	/**
	 * Constructor
	 */
	public function __construct() {
		if ( is_admin() ) {
			add_action( 'ionos_assistant_register_settings', array( $this, 'register_oauth_settings' ), 10, 2 );
		}
	}

	/**
	 * Creates oauth settings option for IONOS Assistant Settings Page.
	 *
	 * @param $options_group_id  // settings options_group_id.
	 * @param $branding_data  // settings branding_data.
	 */
	public function register_oauth_settings( $options_group_id, $branding_data ) {
		if ( ! isset( $branding_data['name'] ) ) {
			return null;
		}

		register_setting(
			$options_group_id,
			'ionos_sso_main_enabled',
			array( 'default' => Config::get( 'main.enabled' ) )
		);
		add_settings_section(
			'ionos_oauth_settings',
			'',
			'',
			'ionos_assistant_settings_plugin'
		);
		add_settings_field(
			'ionos_oauth_settings',
			sprintf( __( '%s - Login', 'ionos-sso' ), $branding_data['name'] ),
			array( $this, 'ionos_oauth_text' ),
			'ionos_assistant_settings_plugin',
			'ionos_oauth_settings',
			array( 'branding_data' => $branding_data )
		);
	}

	/**
	 * Echo text of settings page
	 *
	 * @param  mixed  $args  // branding information.
	 *
	 * @return void
	 */
	public function ionos_oauth_text( $args ) {
		$option = Config::get( 'main.enabled' );

		echo '<label for="ionos_oauth">';
		echo '<input id="ionos_sso_main_enabled" name="ionos_sso_main_enabled" type="checkbox" value="1" '
		     . checked( '1', $option, false ) . ' />';
		echo '<span>'
		     . sprintf( __( 'Enables the use of the %s - Login service',
				'ionos-sso' ), $args['branding_data']['name'] ) . '</span>';
		echo '</label>';
	}
}
