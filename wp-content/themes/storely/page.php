<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Storely
 */

get_header();
?>
<section id="post-section" class="post-section st-py-full">
	<div class="container">
		<div class="row">	
			 <?php 			
				if ( class_exists( 'woocommerce' ) ){
						
					if( is_account_page() || is_cart() || is_checkout() ) {
							echo '<div id="st-primary-content" class="col-lg-'.( !is_active_sidebar( "storely-woocommerce-sidebar" ) ?"12" :"9" ).'">'; 
					}
					else{ 
				
					echo '<div id="st-primary-content" class="col-lg-'.( !is_active_sidebar( "storely-sidebar-primary" ) ?"12" :"9" ).'">'; 
					
					}
				}
				else
				{ 
					echo '<div id="st-primary-content" class="col-lg-'.( !is_active_sidebar( "storely-sidebar-primary" ) ?"12" :"9" ).' ">';
				} 		
					if( have_posts()) :  the_post();
					
					the_content(); 
					endif;
					
					if( $post->comment_status == 'open' ) { 
						 comments_template( '', true ); // show comments 
					}
				?>
			</div>
			<?php 
				//get_sidebar();
				if ( class_exists( 'WooCommerce' ) ) {
					if( is_account_page() || is_cart() || is_checkout() ) {
						get_sidebar('woocommerce');
					}
					else{ 
						get_sidebar();
					}
				}
				else{ 
					get_sidebar();
				}
			?>
		</div>
	</div>
</section>
<?php get_footer(); ?>