<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Storely
 */

get_header();
?>
<div id="post-section" class="post-section st-py-full">
	<div class="container">
		<div class="row">
			<div id="st-primary-content" class="col-lg-9 mb-lg-0 mb-4">
				<div class="row">
					<div class="<?php esc_attr(storely_blog_column_layout()); ?> col-md-12 col-12 mb-4">
						<?php if( have_posts() ): ?>
				
							<?php while( have_posts() ) : the_post();
							
									get_template_part('template-parts/content/content','search'); 
									
							endwhile; 
							the_posts_navigation();
							?>
							
						<?php else: ?>
						
							<?php get_template_part('template-parts/content/content','none'); ?>
							
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
