<?php
function storely_general_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	$wp_customize->add_panel(
		'storely_general', array(
			'priority' => 31,
			'title' => esc_html__( 'General', 'storely' ),
		)
	);
	/*=========================================
	Scroller
	=========================================*/
	$wp_customize->add_section(
		'top_scroller', array(
			'title' => esc_html__( 'Top Scroller', 'storely' ),
			'priority' => 4,
			'panel' => 'storely_general',
		)
	);
	
	$wp_customize->add_setting( 
		'hs_scroller' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'storely_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 1,
		) 
	);
	
	$wp_customize->add_control(
	'hs_scroller', 
		array(
			'label'	      => esc_html__( 'Hide / Show Scroller', 'storely' ),
			'section'     => 'top_scroller',
			'type'        => 'checkbox'
		) 
	);
	
	/*=========================================
	Breadcrumb 
	=========================================*/
	$wp_customize->add_section(
		'breadcrumb_setting', array(
			'title' => esc_html__( 'Page Breadcrumb', 'storely' ),
			'priority' => 12,
			'panel' => 'storely_general',
		)
	);
	
	// Settings
	$wp_customize->add_setting(
		'breadcrumb_settings'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'storely_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'breadcrumb_settings',
		array(
			'type' => 'hidden',
			'label' => __('Settings','storely'),
			'section' => 'breadcrumb_setting',
		)
	);
	
	// Breadcrumb Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'hs_breadcrumb' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'storely_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'hs_breadcrumb', 
		array(
			'label'	      => esc_html__( 'Hide / Show', 'storely' ),
			'section'     => 'breadcrumb_setting',
			'type'        => 'checkbox'
		) 
	);
	
	// Breadcrumb Content Section // 
	if ( class_exists( 'Ecommerce_Comp_Customizer_Range_Control' ) ) {
	$wp_customize->add_setting(
		'breadcrumb_contents'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'storely_sanitize_text',
			'priority' => 5,
		)
	);

	$wp_customize->add_control(
	'breadcrumb_contents',
		array(
			'type' => 'hidden',
			'label' => __('Content','storely'),
			'section' => 'breadcrumb_setting',
		)
	);
	
	
	
	// Content size // 
	
	$wp_customize->add_setting(
    	'breadcrumb_min_height',
    	array(
			'default'	      => '200',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'ecommerce_comp_sanitize_range_value',
			'transport'         => 'postMessage',
			'priority' => 8,
		)
	);
	$wp_customize->add_control( 
		new Ecommerce_Comp_Customizer_Range_Control( $wp_customize, 'breadcrumb_min_height', 
			array(
				'label'      => __( 'Min Height', 'storely'),
				'section'  => 'breadcrumb_setting',
				'media_query'   => false,
				'input_attr'    => array(
					'desktop' => array(
						'min'           => 0,
						'max'           => 1000,
						'step'          => 1,
						'default_value' => 200,
					),
				),
			) ) 
		);
	}	
	// Background // 
	$wp_customize->add_setting(
		'breadcrumb_bg_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'storely_sanitize_text',
			'priority' => 9,
		)
	);

	$wp_customize->add_control(
	'breadcrumb_bg_head',
		array(
			'type' => 'hidden',
			'label' => __('Background','storely'),
			'section' => 'breadcrumb_setting',
		)
	);
	
	// Background Image // 
    $wp_customize->add_setting( 
    	'breadcrumb_bg_img' , 
    	array(
			'default' 			=> esc_url(get_template_directory_uri() .'/assets/images/badcrumb_bg.png'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'storely_sanitize_url',	
			'priority' => 10,
		) 
	);
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize , 'breadcrumb_bg_img' ,
		array(
			'label'          => esc_html__( 'Background Image', 'storely'),
			'section'        => 'breadcrumb_setting',
		) 
	));
	
	// Background Attachment // 
	$wp_customize->add_setting( 
		'breadcrumb_back_attach' , 
			array(
			'default' => 'scroll',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'storely_sanitize_select',
			'priority'  => 10,
		) 
	);
	
	$wp_customize->add_control(
	'breadcrumb_back_attach' , 
		array(
			'label'          => __( 'Background Attachment', 'storely' ),
			'section'        => 'breadcrumb_setting',
			'type'           => 'select',
			'choices'        => 
			array(
				'inherit' => __( 'Inherit', 'storely' ),
				'scroll' => __( 'Scroll', 'storely' ),
				'fixed'   => __( 'Fixed', 'storely' )
			) 
		) 
	);
	
	// Image Opacity // 
	if ( class_exists( 'Ecommerce_Comp_Customizer_Range_Control' ) ) {
	$wp_customize->add_setting(
    	'breadcrumb_bg_img_opacity',
    	array(
	        'default'			=> '0.1',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'ecommerce_comp_sanitize_range_value',
			'priority'  => 11,
		)
	);
	$wp_customize->add_control( 
	new Ecommerce_Comp_Customizer_Range_Control( $wp_customize, 'breadcrumb_bg_img_opacity', 
		array(
			'label'      => __( 'Opacity', 'storely'),
			'section'  => 'breadcrumb_setting',
			'settings' => 'breadcrumb_bg_img_opacity',
			 'media_query'   => false,
                'input_attr'    => array(
                    'desktop' => array(
                        'min'           => 0,
                        'max'           => 1,
                        'step'          => 0.1,
                        'default_value' => 0.1,
                    ),
                ),
		) ) 
	);
	}
}

add_action( 'customize_register', 'storely_general_setting' );
