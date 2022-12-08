<?php
function storezia_upsale_setting( $wp_customize ) {
	
	$wp_customize->add_section(
        'storely_upsale',
        array(
            'title' 		=> __('Get More Features in Storezia Pro','storezia'),
			'priority'      => 1,
		)
    );
	
	/*=========================================
	 Buttons
	=========================================*/
	
	class Storezia_Button_Customize_Control extends WP_Customize_Control {
	public $type = 'storely_upsale';

	   function render_content() {
		?>
			<div class="upsale_info">
				<ul>
					<li><a href="https://preview.sellerthemes.com/pro/storezia/" class="btn-secondary" target="_blank"><i class="dashicons dashicons-desktop"></i><?php _e( 'Pro Demo','storezia' ); ?> </a></li>
					
					<li><a href="https://sellerthemes.com/storezia-premium/" class="btn-primary" target="_blank"><i class="dashicons dashicons-cart"></i><?php _e( 'Purchase Now','storezia' ); ?> </a></li>
					
					<li><a href="https://sellerthemes.ticksy.com/" class="btn-secondary" target="_blank"><i class="dashicons dashicons-sos"></i><?php _e( 'Ask for Support','storezia' ); ?> </a></li>
					
					<li><a href="https://wordpress.org/support/theme/storezia/reviews/#new-post" class="btn-green" target="_blank"><i class="dashicons dashicons-heart"></i><?php _e( 'Give us Rating','storezia' ); ?> </a></li>
				</ul>
			</div>
		<?php
	   }
	}
	
	$wp_customize->add_setting(
		'storely_upsale_btns',
		array(
		   'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'storely_sanitize_text',
		)	
	);
	
	$wp_customize->add_control( new Storezia_Button_Customize_Control( $wp_customize, 'storely_upsale_btns', array(
		'section' => 'storely_upsale',
    ))
);
}
add_action( 'customize_register', 'storezia_upsale_setting',999 );