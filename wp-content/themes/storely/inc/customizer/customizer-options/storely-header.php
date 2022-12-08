<?php
function storely_header_settings( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	/*=========================================
	Header Settings Panel
	=========================================*/
	$wp_customize->add_panel( 
		'header_section', 
		array(
			'priority'      => 2,
			'capability'    => 'edit_theme_options',
			'title'			=> __('Header', 'storely'),
		) 
	);
	/*=========================================
	Storely Site Identity
	=========================================*/
	$wp_customize->add_section(
        'title_tagline',
        array(
        	'priority'      => 1,
            'title' 		=> __('Site Identity','storely'),
			'panel'  		=> 'header_section',
		)
    );
	
	/*=========================================
	Header Navigation
	=========================================*/	
	$wp_customize->add_section(
        'header_navigation',
        array(
        	'priority'      => 4,
            'title' 		=> __('Header Navigation','storely'),
			'panel'  		=> 'header_section',
		)
    );
	
	
	// My Account
	$wp_customize->add_setting(
		'hdr_nav_account'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'storely_sanitize_text',
			'priority' => 3,
		)
	);

	$wp_customize->add_control(
	'hdr_nav_account',
		array(
			'type' => 'hidden',
			'label' => __('My Account','storely'),
			'section' => 'header_navigation',
		)
	);
	$wp_customize->add_setting( 
		'hide_show_account' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'storely_sanitize_checkbox',
			'priority' => 4,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_account', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'storely' ),
			'section'     => 'header_navigation',
			'type'        => 'checkbox'
		) 
	);	
	
	
	// Cart
	$wp_customize->add_setting(
		'hdr_nav_cart'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'storely_sanitize_text',
			'priority' => 7,
		)
	);

	$wp_customize->add_control(
	'hdr_nav_cart',
		array(
			'type' => 'hidden',
			'label' => __('Cart','storely'),
			'section' => 'header_navigation',
		)
	);
	$wp_customize->add_setting( 
		'hide_show_cart' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'storely_sanitize_checkbox',
			'priority' => 8,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_cart', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'storely' ),
			'section'     => 'header_navigation',
			'type'        => 'checkbox'
		) 
	);	

	/*=========================================
	Browse Section
	=========================================*/	
	$wp_customize->add_section(
        'header_browse',
        array(
        	'priority'      => 4,
            'title' 		=> __('Browse Section','storely'),
			'panel'  		=> 'header_section',
		)
    );
	
	// Browse Category
	$wp_customize->add_setting(
		'browse_cat_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'storely_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'browse_cat_head',
		array(
			'type' => 'hidden',
			'label' => __('Browse Category','storely'),
			'section' => 'header_browse',
		)
	);
	
	// Hide / Show 
	$wp_customize->add_setting( 
		'hs_browse_cat' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'storely_sanitize_checkbox',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'hs_browse_cat', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'storely' ),
			'section'     => 'header_browse',
			'type'        => 'checkbox'
		) 
	);
	
	// Title
	$wp_customize->add_setting( 
		'browse_cat_ttl', 
			array(
			'default' => '',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'storely_sanitize_html',
			'priority' => 3,
		) 
	);
	
	$wp_customize->add_control(
	'browse_cat_ttl', 
		array(
			'label'	      => esc_html__( 'Title', 'storely' ),
			'section'     => 'header_browse',
			'type'        => 'text'
		) 
	);	
	
	
	// Search
	$wp_customize->add_setting(
		'product_search_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'storely_sanitize_text',
			'priority' => 4,
		)
	);

	$wp_customize->add_control(
	'product_search_head',
		array(
			'type' => 'hidden',
			'label' => __('Product Search','storely'),
			'section' => 'header_browse',
		)
	);
	
	// Hide / Show 
	$wp_customize->add_setting( 
		'hs_product_search' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'storely_sanitize_checkbox',
			'priority' => 5,
		) 
	);
	
	$wp_customize->add_control(
	'hs_product_search', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'storely' ),
			'section'     => 'header_browse',
			'type'        => 'checkbox'
		) 
	);
	
	
	
	/*=========================================
	Sticky Header
	=========================================*/	
	$wp_customize->add_section(
        'sticky_header_setting',
        array(
        	'priority'      => 4,
            'title' 		=> __('Sticky Header','storely'),
			'panel'  		=> 'header_section',
		)
    );
	
	// Heading
	$wp_customize->add_setting(
		'sticky_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'storely_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'sticky_head',
		array(
			'type' => 'hidden',
			'label' => __('Sticky Header','storely'),
			'section' => 'sticky_header_setting',
		)
	);
	$wp_customize->add_setting( 
		'hide_show_sticky' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'storely_sanitize_checkbox',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_sticky', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'storely' ),
			'section'     => 'sticky_header_setting',
			'type'        => 'checkbox'
		) 
	);	
}
add_action( 'customize_register', 'storely_header_settings' );

