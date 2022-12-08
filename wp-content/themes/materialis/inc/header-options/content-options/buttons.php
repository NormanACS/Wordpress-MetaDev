<?php


function materialis_header_buttons_defaults() {
	return materialis_mod_default( 'header_content_buttons' );
}

function materialis_front_page_header_buttons_options( $section, $prefix, $priority ) {
	materialis_add_kirki_field( array(
		'type'     => 'checkbox',
		'settings' => 'header_content_show_buttons',
		'label'    => esc_html__( 'Show buttons', 'materialis' ),
		'section'  => $section,
		'default'  => true,
		'priority' => $priority,
	) );

	materialis_add_kirki_field( array(
		'type'            => 'sidebar-button-group',
		'settings'        => 'header_content_buttons_group',
		'label'           => esc_html__( 'Options', 'materialis' ),
		'section'         => $section,
		'priority'        => $priority,
		'choices'         => apply_filters( 'materialis_header_buttons_group', array(
			'header_content_buttons',
		) ),
		'active_callback' => array(
			array(
				'setting'  => 'header_content_show_buttons',
				'operator' => '==',
				'value'    => true,
			),
		),
		'in_row_with'     => array( 'header_content_show_buttons' ),
	) );

	$companion = apply_filters( 'materialis_is_companion_installed', false );
	materialis_add_kirki_field(
		array(
			'type'            => 'repeater',
			'settings'        => 'header_content_buttons',
			'label'           => esc_html__( 'Buttons', 'materialis' ),
			'section'         => $section,
			'priority'        => $priority,
			'default'         => materialis_header_buttons_defaults(),
			'choices'         => array(
				'limit'           => apply_filters( 'header_content_buttons_limit', 2 ),
				'beforeValueSet'  => $companion ? '' : 'materialis_header_content_buttons_before_set',
				'button_defaults' => materialis_header_buttons_defaults(),
			),
			'row_label'       => array(
				'type'  => 'text',
				'value' => esc_html__( 'Button', 'materialis' ),
			),
			'fields'          => apply_filters( 'materialis_navigation_custom_area_buttons_fields', array(
				'label'  => array(
					'type'    => $companion ? 'hidden' : 'text',
					'label'   => esc_attr__( 'Label', 'materialis' ),
					'default' => __( 'Action Button', 'materialis' ),
				),
				'url'    => array(
					'type'    => $companion ? 'hidden' : 'text',
					'label'   => esc_attr__( 'Link', 'materialis' ),
					'default' => '#',
				),
				'target' => array(
					'type'    => 'hidden',
					'label'   => esc_attr__( 'Target', 'materialis' ),
					'default' => '_self',
				),
				'class'  => array(
					'type'    => 'hidden',
					'label'   => esc_attr__( 'Class', 'materialis' ),
					'default' => '',
				),
			) ),
			'active_callback' => apply_filters( 'materialis_header_normal_buttons_active', array() ),
		)
	);


	materialis_add_kirki_field( array(
		'type'      => 'ope-info-pro',
		'label'     => esc_html__( 'More colors and typography options available in PRO. @BTN@', 'materialis' ),
		'section'   => $section,
		'priority'  => $priority,
		'settings'  => 'header_content_typography_pro_info',
		'default'   => true,
		'transport' => 'postMessage',
	) );
}

function maetrialis_header_buttons_defaults_loggedout() {

	$latest_posts = wp_get_recent_posts( array( 'numberposts' => 2, 'post_status' => 'publish' ) );
	$result       = array();
	$classes      = array(
		'button btn-default big color1 mdc-elevation--z3',
		'button btn-default big white outline mdc-elevation--z3',
	);

	foreach ( $latest_posts as $id => $post ) {
		$result[] = array(
			'label'  => get_the_title( $post['ID'] ),
			'url'    => get_post_permalink( $post['ID'] ),
			'target' => '_self',
			'class'  => $classes[ $id ],
		);
	}

	return $result;
}

function materialis_print_header_content_main_hook() {

	$content = "";
	$enabled = materialis_get_theme_mod( "header_content_show_buttons", true );

	if ( $enabled ) {
		ob_start();

		$default      = array();
		$shadow_class = '';


		if ( materialis_can_show_demo_content() ) {
			$default = materialis_header_buttons_defaults();
		}

		materialis_print_buttons_list( "header_content_buttons", $default );

		$content = ob_get_clean();
		$content = apply_filters( 'materialis_header_buttons_content', $content, $enabled );

		$background_enabled = materialis_get_theme_mod( 'header_content_buttons_background_enabled', false );
		$shadow_value       = materialis_get_theme_mod( 'header_content_buttons_background_shadow', 0 );
		$shadow_class       = '';

		if ( $background_enabled && $shadow_value ) {
			$shadow_class .= 'mdc-elevation--z' . $shadow_value;
		}

		$content = '<div data-dynamic-mod-container class="header-buttons-wrapper ' . $shadow_class . '"><div class="remove-gutter">' . $content . '</div></div>';
	}


	echo $content;

}

add_action( "materialis_print_header_content", 'materialis_print_header_content_main_hook', 1 );


/*
    template functions
*/


function materialis_buttons_list_item_mods_attr( $index, $setting ) {
	$item_mods = materialis_buttons_list_item_mods( $index, $setting );
	$result    = "data-theme='" . esc_attr( $item_mods['mod'] ) . "'";

	foreach ( $item_mods['atts'] as $key => $value ) {
		$result .= " data-theme-{$key}='" . esc_attr( $value ) . "'";
	}

	$result .= " data-dynamic-mod='true'";

	return $result;
}

function materialis_print_buttons_list( $setting, $default = array() ) {
	$buttons = materialis_get_theme_mod( $setting, $default );

	if ( ! materialis_can_show_demo_content() ) {
		$buttons_mod_content = get_theme_mod( $setting, null );
		if ( ! is_array( $buttons_mod_content ) ) {

			if ( empty( $buttons_mod_content ) ) {
				if ( ! materialis_is_modified() && is_front_page() ) {
					$buttons = maetrialis_header_buttons_defaults_loggedout();
				}
			}
		}
	}

	$default_cnt = materialis_count_default_buttons( $buttons );


	foreach ( $buttons as $index => $button ) {

		if ( $default_cnt == 2 ) {
			$button = apply_filters( 'materialis_print_buttons_list_button', $button, $setting, $index, 0 );
		} elseif ( ! isset( $button['class'] ) || ! trim( $button['class'] ) ) {
			if ( $default_cnt == 0 ) {
				$button = apply_filters( 'materialis_print_buttons_list_button', $button, $setting, $index, 1 );
			}
			if ( $default_cnt == 1 ) {
				$button = apply_filters( 'materialis_print_buttons_list_button', $button, $setting, $index, 2 );
			}
			$default_cnt ++;
		}

		$title  = $button['label'];
		$url    = $button['url'];
		$target = $button['target'];
		$class  = $button['class'];

		if ( empty( $title ) ) {
			$title = __( 'Action button', 'materialis' );
		}

		$extraAtts       = apply_filters( 'materialis_button_extra_atts', array(), $button );
		$extraAttsString = "";

		foreach ( $extraAtts as $key => $value ) {
			$extraAttsString .= " {$key}='" . esc_attr( $value ) . "'";
		}


		$title = html_entity_decode( $title );

		if ( is_customize_preview() ) {
			$mod_attr   = materialis_buttons_list_item_mods_attr( $index, $setting );
			$btn_string = '<a class="%4$s" target="%3$s" href="%1$s" ' . $mod_attr . ' ' . $extraAttsString . '>%2$s</a>';
			printf( $btn_string, esc_url( $url ), materialis_wp_kses_post( $title ), esc_attr( $target ),
				esc_attr( $class ) );
		} else {
			printf( '<a class="%4$s" target="%3$s" href="%1$s" ' . $extraAttsString . '>%2$s</a>', esc_url( $url ),
				materialis_wp_kses_post( $title ), esc_attr( $target ), esc_attr( $class ) );
		}
	}
}

function materialis_count_default_buttons( $buttons ) {
	$defaults_cnt = 0;
	foreach ( $buttons as $button ) {
		if ( strpos( $button['class'], 'btn-default' ) !== false ) {
			$defaults_cnt ++;
		}
	}

	return $defaults_cnt;
}

function materialis_header_content_buttons_buttons_list_filter( $button, $setting, $index, $add_default_index ) {

	if ( $setting === "header_content_buttons" ) {

		$hasClass = ( isset( $button['class'] ) && trim( $button['class'] ) );

		if ( $add_default_index == 0 ) {
			$button['class'] = $hasClass ? $button['class'] : 'button big';
		} else {
			$buttonDefaults = materialis_header_buttons_defaults();

			if ( $add_default_index == 1 ) {
				$button['class'] = $hasClass ? $button['class'] : $buttonDefaults[0]['class'];
			}
			if ( $add_default_index == 2 ) {
				$button['class'] = $hasClass ? $button['class'] : $buttonDefaults[1]['class'];
			}
		}

	}

	return $button;
}

add_filter( 'materialis_print_buttons_list_button', 'materialis_header_content_buttons_buttons_list_filter', 10, 4 );
function materialis_buttons_list_item_mods( $index, $setting ) {
	$result = array(
		"type" => 'data-theme',
		"mod"  => "{$setting}|$index|label",
		"atts" => array(
			"href"   => "{$setting}|{$index}|url",
			"target" => "{$setting}|{$index}|target",
			"class"  => "{$setting}|{$index}|class",
		),
	);

	$result = apply_filters( 'materialis_buttons_list_item_mods', $result, $setting, $index );

	return $result;
}

add_filter( 'materialis_header_buttons_group', 'materialis_header_buttons_background_controls_group' );


function materialis_header_buttons_background_controls_group( $controls ) {

	$controls[] = 'header_content_buttons_background_options_separator';
	$controls[] = 'header_content_buttons_background_enabled';
	$controls[] = 'header_content_buttons_background_color';
	$controls[] = 'header_content_buttons_background_spacing';
	$controls[] = 'header_content_buttons_background_border_radius';
	$controls[] = 'header_content_buttons_background_border_color';
	$controls[] = 'header_content_buttons_background_border_thickness';
	$controls[] = 'header_content_buttons_background_shadow';

	return $controls;
}

add_filter( 'materialis_front_page_header_buttons_options_before', 'materialis_header_buttons_background_controls', 10,
	3 );

function materialis_header_buttons_background_controls( $section, $prefix, $priority ) {
	$companion = apply_filters( 'materialis_is_companion_installed', false );

	$buttons_background_options_control = array(
		'type'     => 'sectionseparator',
		'label'    => esc_html__( 'Background Options', 'materialis' ),
		'section'  => $section,
		'settings' => "header_content_buttons_background_options_separator",
		'priority' => $priority,

	);

	if ( ! $companion ) {
		$buttons_background_options_control['partial_refresh'] = array(
			'header_buttons' => array(
				'selector'        => ".header-buttons-wrapper .remove-gutter",
				'render_callback' => function () {
					return get_theme_mod( 'header_content_buttons_background_options_separator' );
				},
			),
		);
	}

	materialis_add_kirki_field( $buttons_background_options_control );

	materialis_add_kirki_field( array(
		'type'     => 'checkbox',
		'label'    => esc_html__( 'Enable Background', 'materialis' ),
		'section'  => $section,
		'settings' => 'header_content_buttons_background_enabled',
		'priority' => $priority,
		'default'  => materialis_mod_default( "header_element_background_enabled" ),
	) );

	materialis_add_kirki_field( array(
		'type'            => 'color',
		'label'           => esc_html__( 'Background Color', 'materialis' ),
		'section'         => $section,
		'settings'        => 'header_content_buttons_background_color',
		'default'         => materialis_mod_default( "header_element_background_color" ),
		'transport'       => 'postMessage',
		'priority'        => $priority,
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_content_buttons_background_enabled',
				'operator' => '==',
				'value'    => true,
			),
		),
		"output"          => array(
			array(
				'element'  => '.header-buttons-wrapper',
				'property' => 'background',
			),
		),
		'js_vars'         => array(
			array(
				'element'  => ".header-buttons-wrapper",
				'function' => 'css',
				'property' => 'background',
			),
		),
	) );

	materialis_add_kirki_field( array(
		'type'            => 'spacing',
		'settings'        => 'header_content_buttons_background_spacing',
		'label'           => esc_html__( 'Background Spacing', 'materialis' ),
		'section'         => $section,
		'priority'        => $priority,
		'default'         => materialis_mod_default( "header_element_background_spacing" ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'header_content_buttons_background_enabled',
				'operator' => '==',
				'value'    => true,
			),
		),
		'output'          => array(
			array(
				'element'  => '.header-buttons-wrapper',
				'property' => 'padding',
			),
		),
		'js_vars'         => array(
			array(
				'element'  => ".header-buttons-wrapper",
				'function' => 'style',
				'property' => 'padding',
			),
		),
	) );

	materialis_add_kirki_field( array(
		'type'            => 'dimension',
		'settings'        => 'header_content_buttons_background_border_radius',
		'label'           => esc_html__( 'Border Radius', 'materialis' ),
		'section'         => $section,
		'priority'        => $priority,
		'default'         => materialis_mod_default( "header_element_background_radius", 0 ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'header_content_buttons_background_enabled',
				'operator' => '==',
				'value'    => true,
			),
		),
		'output'          => array(
			array(
				'element'  => '.header-buttons-wrapper',
				'property' => 'border-radius',
			),
		),
		'js_vars'         => array(
			array(
				'element'  => ".header-buttons-wrapper",
				'function' => 'style',
				'property' => 'border-radius',
			),
		),
	) );

	materialis_add_kirki_field( array(
		'type'            => 'color',
		'settings'        => 'header_content_buttons_background_border_color',
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
				'setting'  => 'header_content_buttons_background_enabled',
				'operator' => '==',
				'value'    => true,
			),
		),
		'output'          => array(
			array(
				'element'  => '.header-buttons-wrapper',
				'property' => 'border-color',
			),
		),
		'js_vars'         => array(
			array(
				'element'  => '.header-buttons-wrapper',
				'function' => 'css',
				'property' => 'border-color',
			),
		),
	) );

	materialis_add_kirki_field( array(
		'type'            => 'spacing',
		'settings'        => 'header_content_buttons_background_border_thickness',
		'label'           => esc_html__( 'Background Border Thickness', 'materialis' ),
		'section'         => $section,
		'priority'        => $priority,
		'default'         => materialis_mod_default( 'header_element_background_border_thickness' ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'header_content_buttons_background_enabled',
				'operator' => '==',
				'value'    => true,
			),
		),
	) );

	materialis_add_kirki_field( array(
		'type'            => 'slider',
		'settings'        => 'header_content_buttons_background_shadow',
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
				'setting'  => 'header_content_buttons_background_enabled',
				'operator' => '==',
				'value'    => true,
			),
		),
	) );
}
