<?php

function materialis_front_page_header_subtitle_options( $section, $prefix, $priority ) {
	$companion = apply_filters( 'materialis_is_companion_installed', false );


	materialis_add_kirki_field( array(
		'type'     => 'checkbox',
		'settings' => 'header_content_show_subtitle',
		'label'    => esc_html__( 'Show subtitle', 'materialis' ),
		'section'  => $section,
		'default'  => true,
		'priority' => $priority,
	) );

	materialis_add_kirki_field( array(
		'type'            => 'sidebar-button-group',
		'settings'        => 'header_content_subtitle_group',
		'label'           => esc_html__( 'Options', 'materialis' ),
		'section'         => $section,
		'priority'        => $priority,
		"choices"         => array(
			"header_subtitle",
			"header_content_subtitle_typography",
			"header_content_subtitle_spacing",
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_content_show_subtitle',
				'operator' => '==',
				'value'    => true,
			),
		),
		'in_row_with'     => array( 'header_content_show_subtitle' ),
	) );

	if ( ! $companion ) {

		materialis_add_kirki_field( array(
			'type'              => 'textarea',
			'settings'          => 'header_subtitle',
			'label'             => esc_html__( 'Subtitle', 'materialis' ),
			'section'           => $section,
			'default'           => "",
			'sanitize_callback' => 'wp_kses_post',
			'priority'          => $priority,
			'partial_refresh'   => array(
				'header_subtitle' => array(
					'selector'        => ".header-homepage .header-subtitle",
					'render_callback' => function () {
						return get_theme_mod( 'header_subtitle' );
					},
				),
			),
		) );
	}
}

function materialis_print_header_content_subtitle() {
	materialis_print_header_subtitle();
}

add_action( "materialis_print_header_content", 'materialis_print_header_content_subtitle', 1 );


function materialis_print_header_subtitle() {
	$subtitle     = materialis_get_theme_mod( 'header_subtitle', "" );
	$show         = materialis_get_theme_mod( 'header_content_show_subtitle', true );
	$shadow_class = '';

	if ( materialis_can_show_demo_content() ) {
		if ( $subtitle == "" ) {
			$subtitle = esc_html__( 'You can set this subtitle from the customizer.', 'materialis' );
		}
	} else {
		if ( $subtitle == "" ) {
			$subtitle = get_bloginfo( 'description' );
		}
	}
	if ( $show ) {
		$background_enabled = materialis_get_theme_mod( 'header_content_subtitle_background_enabled', false );
		$shadow_value       = materialis_get_theme_mod( 'header_content_subtitle_background_shadow', 0 );
		if ( $background_enabled && $shadow_value ) {
			$shadow_class = 'mdc-elevation--z' . $shadow_value;
		}
		printf( '<p class="header-subtitle ' . $shadow_class . '">%1$s</p>', materialis_wp_kses_post( $subtitle ) );
	}
}

function materialis_customizer_header_content_subtitle_group_filter( $values ) {
	$new = array(
		"header_content_subtitle_background_options_separator",
		"header_content_subtitle_background_enabled",
		"header_content_subtitle_background_color",
		"header_content_subtitle_background_spacing",
		"header_content_subtitle_background_border_radius",
		"header_content_subtitle_background_border_color",
		"header_content_subtitle_background_border_thickness",
		"header_content_subtitle_background_shadow",
	);

	return array_merge( $values, $new );
}

add_filter( "header_content_subtitle_group_filter", 'materialis_customizer_header_content_subtitle_group_filter' );

function materialis_front_page_header_subtitle_options_after_main_hook( $section, $prefix, $priority ) {

	materialis_add_kirki_field( array(
		'type'     => 'sectionseparator',
		'label'    => esc_html__( 'Background Options', 'materialis' ),
		'section'  => $section,
		'settings' => "header_content_subtitle_background_options_separator",
		'priority' => $priority,
	) );

	materialis_add_kirki_field( array(
		'type'     => 'checkbox',
		'label'    => esc_html__( 'Enable Background', 'materialis' ),
		'section'  => $section,
		'settings' => 'header_content_subtitle_background_enabled',
		'priority' => $priority,
		'default'  => materialis_mod_default( "header_content_subtitle_background_enabled" ),
	) );

	materialis_add_kirki_field( array(
		'type'            => 'color',
		'label'           => esc_html__( 'Background Color', 'materialis' ),
		'section'         => $section,
		'settings'        => 'header_content_subtitle_background_color',
		'default'         => materialis_mod_default( "header_element_background_color" ),
		'transport'       => 'postMessage',
		'priority'        => $priority,
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_content_subtitle_background_enabled',
				'operator' => '==',
				'value'    => true,
			),
		),
		"output"          => array(
			array(
				'element'  => '.header-homepage p.header-subtitle',
				'property' => 'background',
			),
		),
		'js_vars'         => array(
			array(
				'element'  => ".header-homepage p.header-subtitle",
				'function' => 'css',
				'property' => 'background',
			),
		),
	) );

	materialis_add_kirki_field( array(
		'type'            => 'spacing',
		'settings'        => 'header_content_subtitle_background_spacing',
		'label'           => esc_html__( 'Background Spacing', 'materialis' ),
		'section'         => $section,
		'priority'        => $priority,
		'default'         => materialis_mod_default( "header_content_subtitle_background_spacing" ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'header_content_subtitle_background_enabled',
				'operator' => '==',
				'value'    => true,
			),
		),
		'output'          => array(
			array(
				'element'  => '.header-homepage p.header-subtitle',
				'property' => 'padding',
			),
		),
		'js_vars'         => array(
			array(
				'element'  => ".header-homepage p.header-subtitle",
				'function' => 'style',
				'property' => 'padding',
			),
		),
	) );

	materialis_add_kirki_field( array(
		'type'            => 'dimension',
		'settings'        => 'header_content_subtitle_background_border_radius',
		'label'           => esc_html__( 'Border Radius', 'materialis' ),
		'section'         => $section,
		'priority'        => $priority,
		'default'         => materialis_mod_default( "header_element_background_radius" ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'header_content_subtitle_background_enabled',
				'operator' => '==',
				'value'    => true,
			),
		),
		'output'          => array(
			array(
				'element'  => '.header-homepage p.header-subtitle',
				'property' => 'border-radius',
			),
		),
		'js_vars'         => array(
			array(
				'element'  => ".header-homepage p.header-subtitle",
				'function' => 'style',
				'property' => 'border-radius',
			),
		),
	) );

	materialis_add_kirki_field( array(
		'type'            => 'color',
		'settings'        => 'header_content_subtitle_background_border_color',
		'label'           => esc_html__( 'Border Color', 'materialis' ),
		'section'         => $section,
		'default'         => materialis_mod_default( 'header_element_background_border_color' ),
		'transport'       => 'postMessage',
		'priority'        => $priority,
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_content_subtitle_background_enabled',
				'operator' => '==',
				'value'    => true,
			),
		),
		'output'          => array(
			array(
				'element'  => '.header-homepage p.header-subtitle',
				'property' => 'border-color',
			),
		),
		'js_vars'         => array(
			array(
				'element'  => '.header-homepage p.header-subtitle',
				'function' => 'css',
				'property' => 'border-color',
			),
		),
	) );

	materialis_add_kirki_field( array(
		'type'            => 'spacing',
		'settings'        => 'header_content_subtitle_background_border_thickness',
		'label'           => esc_html__( 'Background Border Thickness', 'materialis' ),
		'section'         => $section,
		'priority'        => $priority,
		'default'         => materialis_mod_default( 'header_element_background_border_thickness' ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'header_content_subtitle_background_enabled',
				'operator' => '==',
				'value'    => true,
			),
		),
	) );

	materialis_add_kirki_field( array(
		'type'            => 'slider',
		'settings'        => 'header_content_subtitle_background_shadow',
		'label'           => esc_html__( 'Shadow Elevation', 'materialis' ),
		'section'         => $section,
		'priority'        => $priority,
		'default'         => materialis_mod_default( "header_element_background_shadow" ),
		'choices'         => array(
			'min'  => '0',
			'max'  => '12',
			'step' => '1',
		),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'header_content_subtitle_background_enabled',
				'operator' => '==',
				'value'    => true,
			),
		),
	) );


}

add_action( "materialis_front_page_header_subtitle_options_after",
	'materialis_front_page_header_subtitle_options_after_main_hook', 1, 3 );
