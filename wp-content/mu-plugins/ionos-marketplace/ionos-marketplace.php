<?php
/**
 * Plugin Name:  IONOS Marketplace
 * Plugin URI:   https://www.ionos.com
 * Description:  IONOS Marketplace offers you a list of carefully selected plugins that will add functionality to your WordPress instance and improve your user experience.
 * Version:      1.1.5
 * License:      GPLv2 or later
 * Author:       IONOS
 * Author URI:   https://www.ionos.com
 * Text Domain:  ionos-marketplace
 * Domain Path:  /languages
 */

/*
Copyright 2021 IONOS by 1&1
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Online: http://www.gnu.org/licenses/gpl.txt
*/

namespace Ionos\Marketplace;

require 'vendor/autoload.php';

class Marketplace {

	public function __construct() {
		if ( is_blog_installed() ) {
			new \Ionos\Marketplace\Plugins;
		}
	}

	public static function get_css_url( $file = '' ) {
		return plugins_url( 'css/' . $file, __FILE__ );
	}

	public static function get_css_path( $file = '' ) {
		return self::get_plugin_dir_path() . 'css/' . $file;
	}

	public static function get_js_url( $file = '' ) {
		return plugins_url( 'js/' . $file, __FILE__ );
	}

	public static function get_js_path( $file = '' ) {
		return self::get_plugin_dir_path() . 'js/' . $file;
	}

	public static function get_plugin_dir_path() {
		return plugin_dir_path( __FILE__ );
	}

}

\Ionos\Marketplace\Options::set_tenant_and_plugin_name( 'ionos', 'marketplace' );
new \Ionos\Marketplace\Marketplace;