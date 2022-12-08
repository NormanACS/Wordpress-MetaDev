<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Storely
 */

get_header(); 
?>
<div id="post-section" class="post-section st-py-full">
	<div class="container">
		<div class="row">
			<div id="st-primary-content" class="<?php esc_attr(storely_blog_column_layout()); ?> mb-lg-0 mb-4">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-12 mb-4">
						<?php if( have_posts() ): ?>
				
							<?php while( have_posts() ) : the_post();
							
									get_template_part('template-parts/content/content','page'); 
									
							endwhile; ?>
							
						<?php else: ?>
						
							<?php get_template_part('template-parts/content/content','none'); ?>
							
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php  get_sidebar(); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
