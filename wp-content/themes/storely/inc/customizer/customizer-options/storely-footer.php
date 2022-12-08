<?php
function storely_footer( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	// Footer Panel // 
	$wp_customize->add_panel( 
		'footer_section', 
		array(
			'priority'      => 34,
			'capability'    => 'edit_theme_options',
			'title'			=> __('Footer', 'storely'),
		) 
	);

	// Footer Setting Section // 
	$wp_customize->add_section(
        'footer_copy_Section',
        array(
            'title' 		=> __('Below Footer','storely'),
			'panel'  		=> 'footer_section',
			'priority'      => 4,
		)
    );
	
	// Copyright
	$storely_copyright = esc_html__('Copyright &copy; [current_year] [site_title] | Powered by [theme_author]', 'storely' );
	$wp_customize->add_setting( 
		'footer_copyright' , 
			array(
			'default'	      => $storely_copyright,
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'storely_sanitize_html',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'footer_copyright', 
		array(
			'label'	      => esc_html__( 'Copyright', 'storely' ),
			'section'     => 'footer_copy_Section',
			'type'        => 'textarea'
		) 
	);
	
	// Footer Background // 
	$wp_customize->add_section(
        'footer_background',
        array(
            'title' 		=> __('Footer Background','storely'),
			'panel'  		=> 'footer_section',
			'priority'      => 4,
		)
    );
	
	//  Image // 
    $wp_customize->add_setting( 
    	'footer_bg_img' , 
    	array(
			'default' 			=> esc_url(get_template_directory_uri() .'/assets/images/footer_bg.png'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'storely_sanitize_url',	
		) 
	);
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize , 'footer_bg_img' ,
		array(
			'label'          => esc_html__( 'Background Image', 'storely'),
			'section'        => 'footer_background',
		) 
	));
	
	// Background Attachment // 
	$wp_customize->add_setting( 
		'footer_bg_attach' , 
			array(
			'default' => 'scroll',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'storely_sanitize_select',
		) 
	);
	
	$wp_customize->add_control(
	'footer_bg_attach' , 
		array(
			'label'          => __( 'Background Attachment', 'storely' ),
			'section'        => 'footer_background',
			'type'           => 'select',
			'choices'        => 
			array(
				'inherit' => __( 'Inherit', 'storely' ),
				'scroll' => __( 'Scroll', 'storely' ),
				'fixed'   => __( 'Fixed', 'storely' )
			) 
		) 
	);
	// opacity
	if ( class_exists( 'Ecommerce_Comp_Customizer_Range_Control' ) ) {
		$wp_customize->add_setting(
			'footer_bg_opacity',
			array(
				'default'	      => '0.75',
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'ecommerce_comp_sanitize_range_value',
			)
		);
		$wp_customize->add_control( 
		new Ecommerce_Comp_Customizer_Range_Control( $wp_customize, 'footer_bg_opacity', 
			array(
				'label'      => __( 'opacity', 'storely' ),
				'section'  => 'footer_background',
				 'media_query'   => false,
					'input_attr'    => array(
						'desktop' => array(
							'min'           => 0,
							'max'           => 0.9,
							'step'          => 0.1,
							'default_value' => 0.75,
						),
					),
			) ) 
		);
	}
	
	
}
add_action( 'customize_register', 'storely_footer' );
// Footer selective refresh
function storely_footer_partials( $wp_customize ){	
	// footer_copyright
	$wp_customize->selective_refresh->add_partial( 'footer_copyright', array(
		'selector'            => '.footer-copyright .copyright-text',
		'settings'            => 'footer_copyright',
		'render_callback'  => 'storely_footer_copyright_render_callback',
	) );
	
	}
add_action( 'customize_register', 'storely_footer_partials' );


// footer_copyright
function storely_footer_copyright_render_callback() {
	return get_theme_mod( 'footer_copyright' );
}

