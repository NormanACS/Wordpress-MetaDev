<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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
						<?php 
							$storely_paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
							$args = array( 'post_type' => 'post','paged'=>$storely_paged );	
						?>
						<?php if( have_posts() ): ?>
							<?php while( have_posts() ) : the_post(); 
									get_template_part('template-parts/content/content','page'); 
							endwhile; ?>	
						
						<?php else: ?>
							<?php get_template_part('template-parts/content/content','none'); ?>
						<?php endif; ?>
					</div>
				</div>
				<div class="row">
					<div class="col-12 text-center mt-5">
						<!-- Pagination -->
								<?php								
								// Previous/next page navigation.
								the_posts_pagination( array(
								'prev_text'          => '<i class="fa fa-angle-double-left"></i>',
								'next_text'          => '<i class="fa fa-angle-double-right"></i>',
								) ); ?>
							<!-- Pagination -->	
					</div>
				</div>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
