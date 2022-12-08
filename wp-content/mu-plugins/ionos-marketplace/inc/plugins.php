<?php

namespace Ionos\Marketplace;

class Plugins {

	const FALLBACK_LANG = 'en';
	const MAX_ITEMS_PER_PAGE = 12;

	private $ui;
	private $plugins;
	private $paginated_plugins = array();
	private $total_pages = 0;

	public function __construct() {
		$language      = strtolower( explode( '_', get_locale() )[0] );
		$this->ui = json_decode( Config::get( 'data.' . $language . '_ui' ) ) ??
		            json_decode( Config::get( 'data.' . self::FALLBACK_LANG . '_ui' ) );
		$this->plugins = json_decode( Config::get( 'data.' . $language . '_plugins' ) ) ??
		                 json_decode( Config::get( 'data.' . self::FALLBACK_LANG . '_plugins' ) );

		if ( ! empty( $this->plugins ) ) {
			add_filter( 'install_plugins_tabs', array( $this, 'add_ionos_tab' ) );
			add_action( 'install_plugins_ionos', array( $this, 'show_ionos_items' ) );
			add_action( 'install_plugins_pre_ionos', array( $this, 'load_ionos_items' ) );
			add_filter( 'plugins_api', array( $this, 'get_plugin_info' ), 20, 3 );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_style' ) );
		}
	}

	public function enqueue_style() {
		if ( get_current_screen()->id === 'plugin-install' ) {
			wp_enqueue_style(
				'ionos-marketplace-styles',
				Marketplace::get_css_url( 'ionos-marketplace.css' ),
				array(),
				filemtime( Marketplace::get_css_path( 'ionos-marketplace.css' ) )
			);
		}
	}

	private function get_data_for_plugins( $custom_plugins = false ): array {
		$data = array();
		foreach ( $this->paginated_plugins as $p ) {
			$is_custom = $p->custom ?? false;
			if ( $custom_plugins == $is_custom ) {
				array_push( $data, $p );
			}
		}

		return $data;
	}

	private function get_custom_plugin_by_slug( $slug ) {
		foreach ( $this->plugins as $p ) {
			if ( $p->slug === $slug && ! empty ( $p->custom ) ) {
				return $p;
			}
		}

		return null;
	}

	public function load_ionos_items() {
		global $wp_list_table;
		$wp_list_table->items = array();

		$this->total_pages = ceil( count( $this->plugins ) / self::MAX_ITEMS_PER_PAGE );
		$page_num          = max( min( $_GET['paged'] ?? 1, $this->total_pages ), 1 );

		$this->paginated_plugins = array_chunk( $this->plugins, self::MAX_ITEMS_PER_PAGE )[ $page_num - 1 ];

		$pluginInfos = array();
		foreach ( $this->get_data_for_plugins( true ) as $p ) {
			$response                                     = wp_remote_get( $p->custom_info_url );
			$pluginInfos[ $p->slug ]                      = json_decode( wp_remote_retrieve_body( $response ), true );
			$pluginInfos[ $p->slug ]['slug']              = $p->slug;
			$pluginInfos[ $p->slug ]['name']              = $p->name;
			$pluginInfos[ $p->slug ]['version']           = $pluginInfos[ $p->slug ]['latest_version'];
			$pluginInfos[ $p->slug ]['author']            = '<a href="https://www.ionos.com">IONOS</a>';
			$pluginInfos[ $p->slug ]['short_description'] = $p->description;
			$pluginInfos[ $p->slug ]['rating']            = 0;
			$pluginInfos[ $p->slug ]['num_ratings']       = 0;
			$pluginInfos[ $p->slug ]['requires']          = $pluginInfos[ $p->slug ]['requires_wp'] ?? null;
			$pluginInfos[ $p->slug ]['tested']            = $pluginInfos[ $p->slug ]['tested_to'] ?? null;
			$pluginInfos[ $p->slug ]['download_link']     = $pluginInfos[ $p->slug ]['download_url'];
			$pluginInfos[ $p->slug ]['active_installs']   = 0;
			$pluginInfos[ $p->slug ]['icons']             = [ 'svg' => $p->custom_icon_url ];
		}

		$pluginInfos = array_merge( $pluginInfos,
			$this->get_data_from_wp_api( $this->get_data_for_plugins() ) );

		foreach ( $pluginInfos as $p ) {
			array_push( $wp_list_table->items, $p );
		}
	}

	private function get_data_from_wp_api( $plugins ) {
		$endpoint = 'https://api.wordpress.org/plugins/info/1.2/?action=plugin_information&request[fields][icons]=true&request[fields][short_description]=true';
		$endpoint .= '&request[locale]=' . get_locale();

		foreach ( $plugins as $p ) {
			$endpoint .= "&request[slugs][]=$p->slug";
		}

		return json_decode( wp_remote_retrieve_body( wp_remote_get( $endpoint ) ), true );
	}

	public function add_ionos_tab( $tabs ): array {
		unset( $tabs['featured'] );

		return array_merge(
			array( 'ionos' => $this->ui->tab_name ?? 'Marketplace recommends' ),
			$tabs
		);
	}

	public function show_ionos_items() {
		global $wp_list_table;

		$wp_list_table->set_pagination_args( array(
			'total_items' => count( $this->plugins ),
			'total_pages' => $this->total_pages,
			'per_page'    => self::MAX_ITEMS_PER_PAGE
		) );

		display_plugins_table();
	}

	public function get_plugin_info( $result, $action, $args ) {
		if ( $action !== 'plugin_information' ) {
			return $result;
		}

		$p = $this->get_custom_plugin_by_slug( $args->slug );
		if ( ! is_null( $p ) ) {
			$response          = wp_remote_get( $p->custom_info_url );
			$pi                = json_decode( wp_remote_retrieve_body( $response ) );
			$pi->name          = $p->name;
			$pi->slug          = $args->slug;
			$pi->download_link = $pi->download_url;
			$pi->version       = $pi->latest_version;
			$pi->requires      = $pi->requires_wp;
			$pi->tested        = $pi->tested_to;
			$pi->sections      = array(
				_x( 'Description', 'Plugin installer section title' ) => $p->description,
				_x( 'Changelog', 'Plugin installer section title' )   => $this->render_changelog( $pi->changelog )
			);

			return $pi;
		}

		return $result;
	}

	private function render_changelog( $changelog ): string {
		$response = '';

		foreach ( $changelog as $item ) {
			$response .= '<h4>' . $item->version . '</h4><ul>';

			foreach ( $item->changes as $c ) {
				$response .= '<li>' . $c . '</li>';
			}

			$response .= '</ul>';
		}

		return $response;
	}
}
