</div> 
</div> 
<footer id="footer-section" class="footer-section">
	<?php do_action('storely_above_footer');
	?>
	<div class="footer-content">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-12">
					<div class="footer-widgets">
						<div class="row">
							<?php do_action('storely_footer_widget_left'); 		
								if ( is_active_sidebar( 'storely-footer-widget' ) ) {
							?>
							<?php if(function_exists( 'storely_footer_widget_left' )): ?>
								<div class="col-lg-8 col-12 wow fadeInUp">
							<?php else: ?>	
								<div class="col-lg-12 col-12 wow fadeInUp">
							<?php endif; ?>
								<div class="row">
									<?php  dynamic_sidebar( 'storely-footer-widget' ); ?>
								</div>
							</div>
						   <?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php 
	$footer_copyright 	= get_theme_mod('footer_copyright','Copyright &copy; [current_year] [site_title] | Powered by [theme_author]');				
	if(!empty($footer_copyright)) {
	?>
		<div class="footer-copyright">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-12 col-md-12 col-12 text-center">
						<p class="copyright-text">
							<?php 	
								$storely_copyright_allowed_tags = array(
									'[current_year]' => date_i18n('Y'),
									'[site_title]'   => get_bloginfo('name'),
									'[theme_author]' => sprintf(__('<a href="https://sellerthemes.com/storely/" target="_blank">Storely</a>', 'storely')),
								);
								
								echo apply_filters('storely_footer_copyright', wp_kses_post(storely_str_replace_assoc($storely_copyright_allowed_tags, $footer_copyright)));
							?>
						</p>
					</div>
				</div>
			</div>  
		</div>
	<?php } ?>
</footer>
<?php 
	$hs_scroller 	= get_theme_mod('hs_scroller','1');		
	if($hs_scroller == '1') :
?>
	<button type="button" class="scrollingUp scrolling-btn" aria-label="<?php echo esc_attr_e('scrollingUp','storely'); ?>"><i class="fa fa-angle-up"></i><svg height="46" width="46"> <circle cx="23" cy="23" r="22" /></svg></button>
<?php endif; 
wp_footer(); ?>
</body>
</html>
