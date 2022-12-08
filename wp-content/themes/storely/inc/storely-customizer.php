<?php
/**
 * Storely Theme Customizer.
 *
 * @package Storely
 */

 if ( ! class_exists( 'Storely_Customizer' ) ) {

	/**
	 * Customizer Loader
	 *
	 * @since 1.0.0
	 */
	class Storely_Customizer {

		/**
		 * Instance
		 *
		 * @access private
		 * @var object
		 */
		private static $instance;

		/**
		 * Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 */
		public function __construct() {
			/**
			 * Customizer
			 */
			 add_action( 'admin_enqueue_scripts',array( $this, 'storely_admin_script' ) );
			add_action( 'customize_preview_init', array( $this, 'storely_customize_preview_js' ) );
			add_action( 'customize_controls_enqueue_scripts',array( $this, 'storely_customizer_script' ) );
			add_action( 'customize_register',array( $this, 'storely_customizer_register' ) );
			add_action( 'after_setup_theme',array( $this, 'storely_customizer_settings' ) );
		}
		
		/**
		 * Add postMessage support for site title and description for the Theme Customizer.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		function storely_customizer_register( $wp_customize ) {
			
			$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
			$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
			$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
			$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
			$wp_customize->get_setting('custom_logo')->transport = 'refresh';

			/**
			 * Helper files
			 */
			require STORELY_PARENT_INC_DIR . '/customizer/sanitization.php';
		}
		
		/**
		 * Admin Script
		 */
		function storely_admin_script() {
			wp_enqueue_style('storely-admin-style', STORELY_PARENT_INC_URI . '/customizer/assets/css/admin.css');
			wp_enqueue_script( 'storely-admin-script', STORELY_PARENT_INC_URI . '/customizer/assets/js/admin-script.js', array( 'jquery' ), '', true );
			wp_localize_script( 'storely-admin-script', 'storely_ajax_object',
				array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
			);
		}
		
		/**
		 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
		 */
		function storely_customize_preview_js() {
			wp_enqueue_script( 'storely-customizer', STORELY_PARENT_INC_URI . '/customizer/assets/js/customizer-preview.js', array( 'customize-preview' ), '20151215', true );
		}
		
		function storely_customizer_script() {
			 wp_enqueue_script( 'storely-customizer-section', STORELY_PARENT_INC_URI .'/customizer/assets/js/customizer-section.js', array("jquery"),'', true  );	
		}

		// Include customizer customizer settings.
			
		function storely_customizer_settings() {
				 require STORELY_PARENT_INC_DIR . '/customizer/customizer-options/storely-header.php';
				 require STORELY_PARENT_INC_DIR . '/customizer/customizer-options/storely-blog.php';
				 require STORELY_PARENT_INC_DIR . '/customizer/customizer-options/storely-footer.php';
				 require STORELY_PARENT_INC_DIR . '/customizer/customizer-options/storely-general.php';
				 require STORELY_PARENT_INC_DIR . '/customizer/customizer-options/storely_recommended_plugin.php';
				 require STORELY_PARENT_INC_DIR . '/customizer/customizer-options/storely-pro.php';
		}

	}
}// End if().

/**
 *  Kicking this off by calling 'get_instance()' method
 */
Storely_Customizer::get_instance();