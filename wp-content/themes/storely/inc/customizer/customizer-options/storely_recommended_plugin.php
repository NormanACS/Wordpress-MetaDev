<?php
/* Notifications in customizer */
require get_template_directory() . '/inc/customizer/customizer-notify.php';
$storely_config_customizer = array(
	'recommended_plugins'       => array(
		'woocommerce' => array(
			'recommended' => true,
			'description' => sprintf(__('Install and activate <strong>WooCommerce</strong> plugin for taking full advantage of all the features this theme has to offer.', 'storely')),
		),
		'ecommerce-companion' => array(
			'recommended' => true,
			'description' => sprintf(__('Install and activate <strong>eCommerce Companion</strong> plugin for taking full advantage of all the features this theme has to offer.', 'storely')),
		)
	),
	'recommended_actions'       => array(),
	'recommended_actions_title' => esc_html__( 'Recommended Actions', 'storely' ),
	'recommended_plugins_title' => esc_html__( 'Recommended Plugin', 'storely' ),
	'install_button_label'      => esc_html__( 'Install and Activate', 'storely' ),
	'activate_button_label'     => esc_html__( 'Activate', 'storely' ),
	'storely_deactivate_button_label'   => esc_html__( 'Deactivate', 'storely' ),
);
Storely_Customizer_Notify::init( apply_filters( 'storely_customizer_notify_array', $storely_config_customizer ) );



class storely_import_dummy_data {

	private static $instance;

	public static function init( ) {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof storely_import_dummy_data ) ) {
			self::$instance = new storely_import_dummy_data;
			self::$instance->storely_setup_actions();
		}

	}

	/**
	 * Setup the class props based on the config array.
	 */
	

	/**
	 * Setup the actions used for this class.
	 */
	public function storely_setup_actions() {

		// Enqueue scripts
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'storely_import_customize_scripts' ), 0 );

	}
	
	

	public function storely_import_customize_scripts() {

	wp_enqueue_script( 'storely-import-customizer-js', get_template_directory_uri() . '/inc/customizer/assets/js/import-customizer.js', array( 'customize-controls' ) );
	}
}

$storely_import_customizers = array(

		'import_data' => array(
			'recommended' => true,
			
		),
);
storely_import_dummy_data::init( apply_filters( 'storely_import_customizer', $storely_import_customizers ) );