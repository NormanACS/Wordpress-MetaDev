<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Storely
 */

get_header();
?>
<!-- Blog & Sidebar Section -->
<div id="product" class="post-section st-py-full">
        <div class="container">
            <div class="row">
			
			 <?php if(!is_active_sidebar('storely-woocommerce-sidebar')): ?>
				<div class="col-lg-12 mb-lg-0 mb-4">
			<?php else: ?>	
				<div id="st-primary-content" class="col-lg-9 mb-lg-0 mb-4">
			<?php endif; ?>
				<?php woocommerce_content(); ?>
			</div>
			<?php get_sidebar('woocommerce'); ?>
		</div>	
	</div>
</div>
<!-- End of Blog & Sidebar Section -->

<?php get_footer(); ?>

