<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Storely
 */
?>
<article <?php post_class('post-items mb-4'); ?>>
	<figure class="post-image">
		<?php if ( has_post_thumbnail() ) { ?>
			<div class="featured-image">
				<a href="<?php echo esc_url(the_permalink()); ?>">
					<?php the_post_thumbnail(); ?>
				</a>
			</div>
		<?php } ?>	
		<a href="<?php echo esc_url(the_permalink()); ?>" class="post-hover"><i class="fa fa-share"></i></a>
		<div class="post-categories">
			<a href="<?php echo esc_url(the_permalink()); ?>" rel="category tag"><?php the_category(' '); ?></a>
		</div>
		<div class="post-meta">
			<span class="author-name">
				<a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) ));?>" title="<?php esc_attr(the_author()); ?>" class="author meta-info"><i class="fa fa-user-o"></i> <span class="author-name"><?php esc_html(the_author()); ?></span></a>
			</span>
			<?php if(has_tag()){ ?>
				<span class="post-tag">
					<a href="<?php esc_url(the_permalink()); ?>"><i class="fa fa-folder-open-o"></i></a><a href="<?php esc_url(the_permalink()); ?>" rel="category tag"><?php the_tags(''); ?></a>
				</span>
			<?php } ?>	
		</div>
	</figure>
	<div class="post-content">
		<?php     
			if ( is_single() ) :
			
			the_title('<h5 class="post-title">', '</h5>' );
			
			else:
			
			the_title( sprintf( '<h5 class="post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h5>' );
			
			endif; 
		?> 
		<?php 
			
			the_content( 
					sprintf( 
						__( 'Read More', 'storely' ), 
						'<span class="screen-reader-text">  '.esc_html(get_the_title()).'</span>' 
					) 
				);
		  ?>
	</div>
</article>