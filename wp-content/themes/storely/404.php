<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Storely
 */

get_header();
?>
<section id="section404" class="section404 st-py-default" style="background: url('<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/image404bg.png') no-repeat center center / cover;">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-12 mx-lg-auto">
				<div class="card404">	
					<img class="image404" src="<?php echo esc_url(get_template_directory_uri() .'/assets/images/image404.png'); ?>">	
					
					<h3><?php echo esc_html_e('Oops You are Lost','storely'); ?></h3> 
					
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary"><?php esc_html_e('Back to Home','storely'); ?></a>
				</div>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>
