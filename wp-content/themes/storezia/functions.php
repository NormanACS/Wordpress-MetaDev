<?php
function storezia_css() {
	$parent_style = 'storely-parent-style';
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'storezia-style', get_stylesheet_uri(), array( $parent_style ));
	
	wp_enqueue_style('storezia-media-query',get_stylesheet_directory_uri().'/assets/css/responsive.css');
	wp_dequeue_style('storely-media-query');
}
add_action( 'wp_enqueue_scripts', 'storezia_css',999);

require get_stylesheet_directory() . '/inc/customizer/customizer-options/storezia-pro.php';

/**
 * Import Settings From Parent Theme
 *
 */
function storezia_parent_theme_options() {
	$storely_mods = get_option( 'theme_mods_storely' );
	if ( ! empty( $storely_mods ) ) {
		foreach ( $storely_mods as $storely_mod_k => $storely_mod_v ) {
			set_theme_mod( $storely_mod_k, $storely_mod_v );
		}
	}
}
add_action( 'after_switch_theme', 'storezia_parent_theme_options' );