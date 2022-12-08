<?php
if( ! function_exists( 'storely_dynamic_style' ) ):
    function storely_dynamic_style() {

		$output_css = '';
		
		 /**
		 *  Breadcrumb
		 */
		$breadcrumb_min_height			= get_theme_mod('breadcrumb_min_height','200'); 
		$output_css .=".breadcrumb-content{ 
					min-height:" .esc_attr($breadcrumb_min_height). "px;
				}\n";
				
		$breadcrumb_bg_img			= get_theme_mod('breadcrumb_bg_img',esc_url(get_template_directory_uri() .'/assets/images/badcrumb_bg.png')); 
		$breadcrumb_back_attach		= get_theme_mod('breadcrumb_back_attach','scroll'); 
		$breadcrumb_bg_img_opacity	= get_theme_mod('breadcrumb_bg_img_opacity','0.1');

		if($breadcrumb_bg_img !== '') { 
			$output_css .=".breadcrumb-area {
					background-image: url(" .esc_url($breadcrumb_bg_img). ");
					background-attachment: " .esc_attr($breadcrumb_back_attach). ";
				}\n";
		}else{
			$output_css .=".breadcrumb-area {
				 background: var(--bs-primary-light);
			}\n";
		}
		
		if($breadcrumb_bg_img !== '') { 
			$output_css .=".breadcrumb-area:before {
					    content: '';
						position: absolute;
						top: 0;
						right: 0;
						bottom: 0;
						left: 0;
						z-index: -1;
						background-color: #fef7f2;
						opacity: " .esc_attr($breadcrumb_bg_img_opacity). ";
				}\n";
		}
		
		$footer_bg_img	= get_theme_mod('footer_bg_img',esc_url(get_template_directory_uri() .'/assets/images/footer_bg.png'));
		$footer_bg_attach		= get_theme_mod('footer_bg_attach','scroll');
		$footer_bg_opacity		= get_theme_mod('footer_bg_opacity','0.75');
		$footer_bg_opacity_clr	= '#000000';
		list($br, $bg, $bb) 	= sscanf($footer_bg_opacity_clr, "#%02x%02x%02x");
		
			if(!empty($footer_bg_img)):
				 $output_css .=".footer-section{ 
					background:url(" .esc_url($footer_bg_img). ") no-repeat " .esc_attr($footer_bg_attach). " center center / cover rgb($br $bg $bb / " .esc_attr($footer_bg_opacity). ");background-blend-mode:multiply;
				}\n";
			endif;
		
        wp_add_inline_style( 'storely-style', $output_css );
    }
endif;
add_action( 'wp_enqueue_scripts', 'storely_dynamic_style' );