<?php

function materialis_add_blog_options( $section ) {
	$priority = 1;

	materialis_add_kirki_field( array(
		'type'     => 'sectionseparator',
		'label'    => esc_html__( 'Blog Settings', 'materialis' ),
		'section'  => $section,
		'settings' => "blog_section_settings_separator",
		'priority' => $priority,
	) );

	materialis_add_kirki_field( array(
		'type'     => 'checkbox',
		'settings' => 'blog_use_homepage_header',
		'label'    => esc_html__( 'Show front page header on blog page', 'materialis' ),
		'section'  => $section,
		'default'  => false,
	) );

	materialis_add_kirki_field( array(
		'type'     => 'checkbox',
		'settings' => 'blog_sidebar_enabled',
		'label'    => esc_html__( 'Show blog sidebar', 'materialis' ),
		'section'  => $section,
		'default'  => true,
	) );


	materialis_add_kirki_field( array(
		'type'     => 'checkbox',
		'settings' => 'show_author_about_box',
		'label'    => esc_html__( 'Show post author info in sidebar', 'materialis' ),
		'section'  => $section,
		'default'  => false,
	) );

	materialis_add_kirki_field( array(
		'type'     => 'checkbox',
		'settings' => 'show_single_item_title',
		'label'    => esc_html__( 'Show post title in post page', 'materialis' ),
		'section'  => $section,
		'default'  => true,
	) );

	materialis_add_kirki_field( array(
		'type'     => 'checkbox',
		'settings' => 'blog_post_meta_enabled',
		'label'    => esc_html__( 'Show post meta', 'materialis' ),
		'section'  => $section,
		'default'  => true,
	) );

	materialis_add_kirki_field( array(
		'type'     => 'checkbox',
		'settings' => 'blog_post_highlight_enabled',
		'label'    => esc_html__( 'Highlight first post', 'materialis' ),
		'section'  => $section,
		'default'  => true,
	) );

	$posts_per_row = array();

	foreach ( array( 1, 2, 3, 4, 6 ) as $class ) {
		$posts_per_row[ $class ] = sprintf( _n( '%s item', '%s items', $class, "materialis" ), $class );
	}

	materialis_add_kirki_field( array(
		'type'     => 'select',
		'settings' => 'blog_posts_per_row',
		'label'    => esc_html__( 'Posts per row', 'materialis' ),
		'section'  => $section,
		'default'  => 2,
		'choices'  => $posts_per_row,
	) );

	materialis_add_kirki_field( array(
		'type'     => 'checkbox',
		'settings' => 'blog_posts_as_masonry_grid',
		'label'    => esc_html__( 'Display posts as masonry grid', 'materialis' ),
		'section'  => $section,
		'default'  => true,
	) );

	materialis_add_kirki_field( array(
		'type'        => 'checkbox',
		'settings'    => 'blog_show_post_featured_image',
		'label'       => esc_html__( 'Use blog/post featured image as hero background when available', 'materialis' ),
		'description' => esc_html__( 'Must have inner pages hero background set to image, and blog page and/or post featured image added.',
			'materialis' ),
		'section'     => $section,
		'priority'    => 3,
		'default'     => true,
	) );


	materialis_add_kirki_field( array(
		'type'     => 'checkbox',
		'settings' => 'blog_show_post_thumb_placeholder',
		'label'    => esc_html__( 'Show thumbnail placeholder', 'materialis' ),
		'section'  => $section,
		'default'  => true,
	) );

	materialis_add_kirki_field( array(
		'type'            => 'color',
		'label'           => esc_html__( 'Placeholder Background Color', 'materialis' ),
		'section'         => $section,
		'settings'        => 'blog_post_thumb_placeholder_color',
		'default'         => materialis_get_theme_colors( 'color1' ),
		'active_callback' => array(
			array(
				'setting'  => 'blog_show_post_thumb_placeholder',
				'operator' => '==',
				'value'    => true,
			),
		),
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'element'  => "svg.materialis-post-list-item-thumb-placeholder rect",
				'property' => 'fill',
				'suffix'   => '!important',
			),
		),
	) );

}

materialis_add_blog_options( 'blog_settings' );


function materialis_show_post_meta_setting_filter( $value ) {

	$value = materialis_get_theme_mod( 'blog_post_meta_enabled', $value );

	return $value;
}

add_filter( 'materialis_show_post_meta', 'materialis_show_post_meta_setting_filter' );


function materialis_posts_per_row_setting_filter( $value ) {

	$value = materialis_get_theme_mod( 'blog_posts_per_row', $value );

	return $value;
}

add_filter( 'materialis_posts_per_row', 'materialis_posts_per_row_setting_filter' );

function materialis_archive_post_highlight_setting_filter( $value ) {

	if ( ! materialis_is_modified() && is_front_page() ) {
		return false;
	}


	$value = materialis_get_theme_mod( 'blog_post_highlight_enabled', $value );

	return $value;
}

add_filter( 'materialis_archive_post_highlight', 'materialis_archive_post_highlight_setting_filter' );


function materialis_blog_sidebar_enabled_setting_filter( $value ) {


	$value = intval( materialis_get_theme_mod( 'blog_sidebar_enabled', $value ) );

	return ( $value === 1 );
}

add_filter( 'materialis_blog_sidebar_enabled', 'materialis_blog_sidebar_enabled_setting_filter' );


function materialis_blog_posts_as_masonry_grid_data_script( $data ) {
	$blog_uses_masonry = materialis_get_theme_mod( 'blog_posts_as_masonry_grid', true );

	$data['blog_posts_as_masonry_grid'] = ! ! intval( $blog_uses_masonry );

	return $data;
}

add_filter( 'materialis_theme_data_script', 'materialis_blog_posts_as_masonry_grid_data_script' );


function materialis_is_blog_page_with_front_header() {
	$value = false;

	$use_front_header_on_blog_page = ! ! intval( materialis_get_theme_mod( 'blog_use_homepage_header', false ) );

	if ( is_archive() || ( ! is_front_page() && is_home() ) ) {
		if ( $use_front_header_on_blog_page ) {
			$value = true;
		}
	}

	return $value;
}


function materialis_header_blog_page_with_front_hero_filter( $header ) {

	if ( materialis_is_blog_page_with_front_header() ) {
		$header = "homepage";
	}

	return $header;
}

add_filter( 'materialis_header', 'materialis_header_blog_page_with_front_hero_filter' );


function materialis_is_front_page_for_blog_page( $value ) {

	if ( materialis_is_blog_page_with_front_header() ) {
		$value = true;
	}

	return $value;
}

add_filter( 'materialis_is_front_page', 'materialis_is_front_page_for_blog_page' );
