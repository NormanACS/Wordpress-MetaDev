<?php
 /**
 * Enqueue scripts and styles.
 */
function storely_scripts() {
	
	// Styles	
	wp_enqueue_style('bootstrap-min',get_template_directory_uri().'/assets/css/bootstrap.min.css');
	
	wp_enqueue_style('tiny-slider',get_template_directory_uri().'/assets/css/tiny-slider.css');
	
	wp_enqueue_style('owl-carousel-min',get_template_directory_uri().'/assets/css/owl.carousel.min.css');
	
	wp_enqueue_style('font-awesome',get_template_directory_uri().'/assets/css/fonts/font-awesome/css/font-awesome.min.css');
	
	wp_enqueue_style('animate',get_template_directory_uri().'/assets/css/animate.min.css');
	
	wp_enqueue_style('storely-editor-style',get_template_directory_uri().'/assets/css/editor-style.css');

	wp_enqueue_style('storely-meanmenu', get_template_directory_uri() . '/assets/css/meanmenu.css');

	wp_enqueue_style('storely-widgets',get_template_directory_uri().'/assets/css/widgets.css');

	wp_enqueue_style('storely-main', get_template_directory_uri() . '/assets/css/main.css');

	wp_enqueue_style('storely-woo-style',get_template_directory_uri().'/assets/css/woo-style.css');
	
	wp_enqueue_style('storely-media-query', get_template_directory_uri() . '/assets/css/responsive.css');
	
	wp_enqueue_style( 'storely-style', get_stylesheet_uri() );
	
	// Scripts
	wp_enqueue_script( 'jquery' );
	
	wp_enqueue_script('popper', get_template_directory_uri() . '/assets/js/popper.min.js', array('jquery'), false, true);
	
	wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), false, true);
	
	wp_enqueue_script('tiny-slider', get_template_directory_uri() . '/assets/js/tiny-slider.min.js', array('jquery'), true);
	
	wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array('jquery'), true);
	
	wp_enqueue_script('owlcarousel2-filter', get_template_directory_uri() . '/assets/js/owlcarousel2-filter.js', array('jquery'), false, true);
	
	wp_enqueue_script('isotope-pkgd', get_template_directory_uri() . '/assets/js/isotope.pkgd.min.js', array('jquery'), true);
	
	wp_enqueue_script('storely-meanmenu', get_template_directory_uri() . '/assets/js/meanmenu.js', array('jquery'), false, true);
	
	wp_enqueue_script('wow-min', get_template_directory_uri() . '/assets/js/wow.min.js', array('jquery'), false, true);

	wp_enqueue_script('storely-custom-js', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), false, true);	
	  

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'storely_scripts' );
