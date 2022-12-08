<?php

namespace Ionos\Marketplace;

class Themes {
	private $themes;

	public function __construct() {
		$this->themes = Config::get( 'data.themes' );

		if ( ! empty( $this->themes ) ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_filter( 'themes_api', array( $this, 'get_theme_info' ), 10, 3 );
		}
	}

	function enqueue_scripts() {
		if ( get_current_screen()->id === 'theme-install' ) {
			wp_enqueue_script(
				'ionos-marketplace',
				Marketplace::get_js_url( 'ionos-marketplace-themes.js' ),
				array(),
				filemtime( Marketplace::get_js_path( 'ionos-marketplace-themes.js' ) ),
				true
			);
		}
	}

	function get_themes_array( $themeInfos ) {
		global $themes_allowedtags;
		$update_php = network_admin_url( 'update.php?action=install-theme' );

		$themes = array();
		foreach ( $themeInfos as $ti ) {
			if ( ! isset( $ti->slug ) ) {
				continue;
			}

			$i                 = new \stdClass;
			$i->name           = wp_kses( $ti->name, $themes_allowedtags );
			$i->slug           = $ti->slug;
			$i->version        = wp_kses( $ti->version, $themes_allowedtags );
			$i->preview_url    = set_url_scheme( $ti->preview_url );
			$i->author         = wp_kses( $ti->author->author, $themes_allowedtags );
			$i->screenshot_url = $ti->screenshot_url;
			$i->rating         = $ti->rating;
			$i->num_ratings    = number_format_i18n( $ti->num_ratings );
			$i->reviews_url    = $ti->reviews_url;
			$i->homepage       = $ti->homepage;
			$i->description    = wp_kses( $ti->sections->description, $themes_allowedtags );
			$i->requires       = $ti->requires;
			$i->requires_php   = $ti->requires_php;

			$i->install_url = add_query_arg(
				array(
					'theme'    => $ti->slug,
					'_wpnonce' => wp_create_nonce( 'install-theme_' . $ti->slug ),
				),
				$update_php
			);

			if ( current_user_can( 'switch_themes' ) ) {
				if ( is_multisite() ) {
					$i->activate_url = add_query_arg(
						array(
							'action'   => 'enable',
							'_wpnonce' => wp_create_nonce( 'enable-theme_' . $ti->slug ),
							'theme'    => $ti->slug,
						),
						network_admin_url( 'themes.php' )
					);
				} else {
					$i->activate_url = add_query_arg(
						array(
							'action'     => 'activate',
							'_wpnonce'   => wp_create_nonce( 'switch-theme_' . $ti->slug ),
							'stylesheet' => $ti->slug,
						),
						admin_url( 'themes.php' )
					);
				}
			}

			if ( ! is_multisite() && current_user_can( 'edit_theme_options' ) && current_user_can( 'customize' ) ) {
				$i->customize_url = add_query_arg(
					array(
						'return' => urlencode( network_admin_url( 'theme-install.php', 'relative' ) ),
					),
					wp_customize_url( $ti->slug )
				);
			}

			$i->stars          = wp_star_rating(
				array(
					'rating' => $ti->rating,
					'type'   => 'percent',
					'number' => $ti->num_ratings,
					'echo'   => false,
				)
			);
			$i->compatible_wp  = is_wp_version_compatible( $ti->requires );
			$i->compatible_php = is_php_version_compatible( $ti->requires_php );

			$themes[] = $i;
		}

		$info = array(
			'page'    => 1,
			'pages'   => 1,
			'results' => count( $themes )
		);

		return array(
			'info'   => $info,
			'themes' => $themes
		);
	}

	function get_theme_info( $override, $action, $args ) {
		global $themes_allowedtags;

		if ( $args->browse === 'ionos' && ! isset ( $args->page ) ) {
			$override = true;

			$slugs = array();
			foreach ( $this->themes as $t ) {
				$slugs[] = $t->slug;
			}

			$endpoint = 'https://api.wordpress.org/themes/info/1.2/?action=theme_information';

			foreach ( $slugs as $s ) {
				$endpoint .= "&request[slugs][]=$s";
			}

			$response  = wp_remote_get( $endpoint );
			$themeInfo = json_decode( wp_remote_retrieve_body( $response ) );

			wp_send_json_success( $this->get_themes_array( $themeInfo ) );
		}
	}


}