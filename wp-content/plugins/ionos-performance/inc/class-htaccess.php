<?php

namespace Ionos\Performance;

use Ionos\Performance\Config;

class Htaccess {
	/**
	 * @var string $content Content of the .htaccess-file
	 */
	private $content;

	/**
	 * @var string $version
	 */
	private $version = '0.0.0';

	/**
	 * @var bool $error;
	 */
	private $error = false;

	/**
	 * @var null|string $path Path to the .htaccess-file
	 */
	private $path;

	/**
	 * @var string $template .htaccess snippet template
	 */
	private $template = null;

	public function __construct() {
		$this->path = trailingslashit( ABSPATH ) . '.htaccess';
		if ( @is_readable( $this->path ) ) {
			$this->content = file_get_contents( $this->path );
			$this->read_version();
			$this->read_template();
			return;
		}

		$this->error = true;
	}

	/**
	 * Reads the version from the .htaccess file and sets the class attribute
	 *
	 * @return void
	 */
	private function read_version() {
		if ( preg_match( '/# IONOS_Performance Version: ([^\r\n]*)/', $this->content, $matches ) ) {
			$this->version = next( $matches );
		}
	}

	/**
	 * Reads the .htaccess snippet template and sets the class attribute
	 *
	 * @return void
	 */
	private function read_template() {
		$path = IONOS_PERFORMANCE_DIR . '/templates/template-htaccess-snippet.tpl';

		if ( is_readable( $path ) ) {
			$this->template = file_get_contents( $path );
		}
	}

	/**
	 * Checks if .htaccess contains our snippet
	 *
	 * @return bool
	 */
	private function snippet_exists() {
		return ! empty( preg_match_all( '/# START IONOS_Performance(.|\n)*?# END IONOS_Performance/', $this->content, $matches, PREG_SET_ORDER ) );
	}

	/**
	 * Removes the .htaccess snippet
	 *
	 * @return void
	 */
	private function remove_snippet() {
		$htaccess = $this->content;
		$htaccess = preg_replace( '/# START IONOS_Performance(.|\n)*?# END IONOS_Performance(\n*)/', '', $htaccess );
		if ( file_put_contents( $this->path, $htaccess ) ) {
			$this->content = $htaccess;
		}
	}

	/**
	 * Adds the snippet for hdd-caching to the .htaccess
	 *
	 * @return void
	 */
	private function insert_snippet() {
		if ( ! is_writable( $this->path ) ) {
			return;
		}

		if ( empty( $this->template ) ) {
			return;
		}

		$htaccess = $this->template;
		$htaccess = \str_replace( '{{IONOS_PERFORMANCE_CACHE_DIR}}', IONOS_PERFORMANCE_CACHE_DIR, $htaccess );
		$htaccess = \str_replace( '{{IONOS_PERFOMRANCE_HTACCESS_VERSION}}', IONOS_PERFOMRANCE_HTACCESS_VERSION, $htaccess );
		$htaccess = $htaccess . PHP_EOL . $this->content;
		if ( false !== file_put_contents( $this->path, $htaccess ) ) {
			$this->content = $htaccess;
		}
	}

	/**
	 * If necessary adds or removes snippet from .htaccess
	 *
	 * @return void
	 */
	public function maybe_update() {
		if ( $this->should_remove_snippet() ) {
			$this->remove_snippet();
			Caching::clear_cache();
			return;
		}

		if ( did_action( 'deactivate_' . IONOS_PERFORMANCE_BASE ) ) {
			return;
		}

		if ( $this->should_insert_snippet() ) {
			$this->insert_snippet();
			return;
		}

		if ( $this->should_update() ) {
			$this->remove_snippet();
			$this->insert_snippet();
		}
	}

	/**
	 * Check if htaccess version is not up-to-date.
	 *
	 * @return bool
	 */
	private function should_update() {
		if ( Helper::has_conflicting_caching_plugins() ) {
			return false;
		}

		if ( version_compare( trim( IONOS_PERFOMRANCE_HTACCESS_VERSION ), trim( $this->version ), '==' ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Check if the snippet should be removed from .htaccess
	 *
	 * @return bool
	 */
	private function should_remove_snippet() {
		if ( ! $this->snippet_exists() ) {
			return false;
		}

		if ( ! Config::get( 'features.enabled' ) ) {
			return true;
		}

		if ( Manager::get_option( 'caching_enabled' ) == 0 ) {
			return true;
		}

		if ( ! get_option( 'permalink_structure' ) ) {
			return true;
		}

		if ( Helper::has_conflicting_caching_plugins() ) {
			return true;
		}

		if ( did_action( 'deactivate_' . IONOS_PERFORMANCE_BASE ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Check if the snippet should be inserted into .htaccess
	 *
	 * @return bool
	 */
	private function should_insert_snippet() {
		if ( $this->snippet_exists() ) {
			return false;
		}

		if ( ! Config::get( 'features.enabled' ) ) {
			return false;
		}

		if ( ! get_option( 'permalink_structure' ) ) {
			return false;
		}

		if ( Helper::has_conflicting_caching_plugins() ) {
			return false;
		}

		return true;
	}

	/**
	 * Update .htaccess when a conflicting plugin is activated or deactivated.
	 *
	 * @return void
	 */
	public function handle_plugin_changes() {
		// If the caching feature is disabled because of another active caching plugin, the .htaccess snippet
		// is removed, so we need to check if we have to add it again after a plugin has been deactivated.
		add_action(
			'update_option_active_plugins',
			function() {
				$this->maybe_update();
			}
		);
	}

	/**
	 * Handles plugin activation
	 *
	 * @return void
	 */
	public function handle_activation() {
		$this->maybe_update();
	}

	/**
	 * Handles plugin deactivation
	 *
	 * @return void
	 */
	public function handle_deactivation() {
		if ( $this->should_remove_snippet() ) {
			$this->remove_snippet();
		}
	}
}