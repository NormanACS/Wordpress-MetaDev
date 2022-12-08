<?php 
	$storely_hs_browse_cat		= get_theme_mod( 'hs_browse_cat','1');
	$storely_browse_cat_ttl		= get_theme_mod( 'browse_cat_ttl');
	$storely_hs_product_search	= get_theme_mod( 'hs_product_search','1');
	if(($storely_hs_browse_cat=='1'  || $storely_hs_product_search=='1') && class_exists( 'woocommerce' )):
?>	
<div id="browse-section" class="browse-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-12">
				<?php if($storely_hs_browse_cat=='1'): ?>
					<div class="product-category-browse d-none d-lg-block <?php if ( is_page_template( 'templates/template-homepage.php' ) ) { echo esc_attr_e('active','storely'); } ?>">
						<?php do_action('storely_hdr_browse_cat'); ?>
					</div>
				<?php endif; ?>
			</div>
			<div class="col-lg-9 col-12">
				<?php do_action('storely_hdr_product_search');  ?>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>	