<?php
/**
 * Plugin Name:  IONOS Login
 * Plugin URI:   https://www.ionos.com
 * Description:  IONOS Login allows you to login with your IONOS customer ID and password through the IONOS Control Panel login page. You then have an active session in both your WordPress and your Control Panel and can jump easily from one to the other.
 * Version:      2.1.2
 * License:      GPLv2 or later
 * Author:       IONOS
 * Author URI:   https://www.ionos.com
 * Text Domain:  ionos-sso
 */

namespace Ionos\SSO;

/**
 * Init plugin.
 *
 * @return void
 */
function init() {
	require_once 'inc/lib/options.php';
	Options::set_tenant_and_plugin_name('ionos', 'sso');
	require_once 'inc/lib/data-providers/cloud.php';
	require_once 'inc/lib/config.php';
	require_once 'inc/lib/updater.php';
	require_once 'inc/lib/features/disable-plugins/class-manager.php';

	require_once 'inc/class-manager.php';
	require_once 'inc/class-settings.php';
	require_once 'inc/class-helper.php';
	require_once 'inc/class-login.php';

	new Manager();
	new Settings();
	new Login();
	new Updater();
	new \Ionos\SSO\Warning( 'ionos-sso' );
}

\add_action( 'plugins_loaded', 'Ionos\SSO\init' );

/**
 * Plugin translation.
 *
 * @return void
 */
function load_textdomain() {
	if ( false !== \strpos( \plugin_dir_path( __FILE__ ), 'mu-plugins' ) ) {
		\load_muplugin_textdomain(
			'ionos-sso',
			\basename( \dirname( __FILE__ ) ) . '/languages'
		);
	} else {
		\load_plugin_textdomain(
			'ionos-sso',
			false,
			\dirname( \plugin_basename( __FILE__ ) ) . '/languages/'
		);
	}
}

\add_action( 'init', 'Ionos\SSO\load_textdomain' );
