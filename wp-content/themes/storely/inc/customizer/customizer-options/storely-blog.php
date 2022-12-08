<?php
function storely_blog_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	$wp_customize->add_panel(
		'storely_frontpage_sections', array(
			'priority' => 32,
			'title' => esc_html__( 'Frontpage Sections', 'storely' ),
		)
	);
	/*=========================================
	Blog Section
	=========================================*/
	$wp_customize->add_section(
		'blog_setting', array(
			'title' => esc_html__( 'Blog Section', 'storely' ),
			'priority' => 8,
			'panel' => 'storely_frontpage_sections',
		)
	);
	/*=========================================
	Setting
	=========================================*/
	$wp_customize->add_setting(
		'blog_settings'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'storely_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'blog_settings',
		array(
			'type' => 'hidden',
			'label' => __('Settings','storely'),
			'section' => 'blog_setting',
		)
	);
	
	// Hide / Show
	$wp_customize->add_setting(
		'blog_hide_show'
			,array(
			'default' => '1',	
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'storely_sanitize_checkbox',
			'priority' => 2,
		)
	);

	$wp_customize->add_control(
	'blog_hide_show',
		array(
			'type' => 'checkbox',
			'label' => __('Hide / Show','storely'),
			'section' => 'blog_setting',
		)
	);
	
	/*=========================================
	Header
	=========================================*/
	$wp_customize->add_setting(
		'blog_header'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'storely_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'blog_header',
		array(
			'type' => 'hidden',
			'label' => __('Header','storely'),
			'section' => 'blog_setting',
		)
	);
	
	//  Title // 
	$wp_customize->add_setting(
    	'blog_ttl',
    	array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'storely_sanitize_html',
			'transport'         => $selective_refresh,
			'priority' => 2,
		)
	);	
	
	$wp_customize->add_control( 
		'blog_ttl',
		array(
		    'label'   => __('Title','storely'),
		    'section' => 'blog_setting',
			'type'           => 'text',
		)  
	);
	
	/*=========================================
	Content
	=========================================*/
	$wp_customize->add_setting(
		'blog_content'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'storely_sanitize_text',
			'priority' => 5,
		)
	);

	$wp_customize->add_control(
	'blog_content',
		array(
			'type' => 'hidden',
			'label' => __('Content','storely'),
			'section' => 'blog_setting',
		)
	);
	
	// Hide / Show
	$wp_customize->add_setting(
		'blog_tab_hs'
			,array(
			'default'     	=> '1',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'storely_sanitize_checkbox',
			'priority' => 5,
		)
	);

	$wp_customize->add_control(
	'blog_tab_hs',
		array(
			'type' => 'checkbox',
			'label' => __('Hide / Show Tab','storely'),
			'section' => 'blog_setting',
		)
	);
	
	// No. of Products Display
	if ( class_exists( 'Ecommerce_Comp_Customizer_Range_Control' ) ) {
		$wp_customize->add_setting(
			'blog_num',
			array(
				'default' => '3',
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'ecommerce_comp_sanitize_range_value',
				'priority' => 7,
			)
		);
		$wp_customize->add_control( 
		new Ecommerce_Comp_Customizer_Range_Control( $wp_customize, 'blog_num', 
			array(
				'label'      => __( 'No. of Blog Display', 'storely' ),
				'section'  => 'blog_setting',
				 'media_query'   => false,
					'input_attr'    => array(
						'desktop' => array(
							'min'    => 1,
							'max'    => 500,
							'step'   => 1,
							'default_value' => 3,
						),
					),
			) ) 
		);
	}
}

add_action( 'customize_register', 'storely_blog_setting' );

// selective refresh
function storely_blog_partials( $wp_customize ){
	
	// blog_ttl
	$wp_customize->selective_refresh->add_partial( 'blog_ttl', array(
		'selector'            => '.post-home .heading-default h5',
		'settings'            => 'blog_ttl',
		'render_callback'  => 'storely_blog_ttl_render_callback',
	) );
	
	}

add_action( 'customize_register', 'storely_blog_partials' );

// blog_ttl
function storely_blog_ttl_render_callback() {
	return get_theme_mod( 'blog_ttl' );
}