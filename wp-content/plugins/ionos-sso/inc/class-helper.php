<?php

namespace Ionos\SSO;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Helper class
 */
class Helper {

	/**
	 * Get the url of the css folder
	 *
	 * @param string $file // css file name.
	 *
	 * @return string
	 */
	public static function get_css_url( string $file = '' ) {
		return plugins_url( 'css/' . $file, __DIR__ );
	}

	public static function get_css_path( $file = '' ) {
		return self::get_plugin_dir_path() . 'css/' . $file;
	}

	public static function get_plugin_dir_path() {
		return plugin_dir_path( __DIR__ );
	}

	/**
	 * Is the SSO enabled/authorized?
	 */
	public static function is_enabled() {
		return '1' === Config::get( 'main.enabled' ) && is_ssl();
	}
}
