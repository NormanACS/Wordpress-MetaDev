<?php  
	$storely_blog_hide_show 		= get_theme_mod('blog_hide_show','1');
	$storely_blog_ttl 				= get_theme_mod('blog_ttl');
	$storely_blog_tab_hs			= get_theme_mod('blog_tab_hs','1'); 
	$storely_blog_num				= get_theme_mod('blog_num','3');
	$tax = 'post'; 
	$categories = get_terms($tax);
	if($storely_blog_hide_show=='1'):
?>	
<div id="post-section" class="post-section post-home st-py-default">
	<div class="container">
		<div class="st-filter-wrapper-1">
			<?php if(!empty($storely_blog_ttl) || $storely_blog_tab_hs=='1'): ?>
				<div class="row">
					<div class="col-lg-12 col-12 mx-lg-auto mb-5 wow fadeInUp">
						<div class="heading-default">
							<?php if(!empty($storely_blog_ttl)): ?>
								<div class="title">
									<h5><?php echo wp_kses_post($storely_blog_ttl); ?></h5>
								</div>
							<?php endif; ?>
							<?php if($storely_blog_tab_hs=='1'): ?>
							<?php $categories = get_categories();
							if (!$categories == 0) { ?>	
								<div class="heading-right">
									<div class="st-tab-filter text-center">
										<?php foreach ($categories as $category) { ?>
										<?php if($category->name == 'All'){ ?>
											<a href="javascript:void(0);" data-filter=".<?php echo esc_attr($category->slug); ?>" class="active is-active"><?php echo esc_html($category->name); ?></a>
										<?php } else{ ?>
											<a href="javascript:void(0);" data-filter=".<?php echo esc_attr($category->slug); ?>"><?php echo esc_html($category->name); ?></a>
										<?php } } ?>
									</div>
								</div>
							<?php } endif; ?>	
						</div>
					</div>
				</div>
			<?php endif; ?>
			<div id="st-filter-init-1" class="row st-filter-init wow fadeInUp">
				<?php 
					$storely_blog_args = array( 'post_type' => 'post', 'posts_per_page' => $storely_blog_num,'post__not_in'=>get_option("sticky_posts")) ; 	
				
					$storely_wp_query = new WP_Query($storely_blog_args);
					if($storely_wp_query)
					{	
					while($storely_wp_query->have_posts()):$storely_wp_query->the_post();
				
						$terms = get_the_category( $post->ID, 'post' );
											
						if ( $terms && ! is_wp_error( $terms ) ) : 
							$links = array();

							foreach ( $terms as $term ) 
							{
								$links[] = $term->slug;
							}
							
							$tax = join( ' ', $links );		
						else :	
							$tax = '';	
						endif;
				?>
					<div class="col-lg-4 col-md-6 col-12 mb-4 st-filter-item <?php echo esc_attr(strtolower($tax)); ?>">
						 <?php get_template_part('template-parts/content/content','page'); ?>
					</div>
				<?php endwhile; } wp_reset_postdata(); ?>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>