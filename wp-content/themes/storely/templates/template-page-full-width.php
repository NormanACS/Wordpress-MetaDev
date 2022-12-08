<?php
/**
Template Name: Fullwidth Page
**/

get_header();
?>
<div class="post-section st-py-full">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 mb-lg-0 mb-4">
				<?php 		
					the_post(); the_content(); 
					
					if( $post->comment_status == 'open' ) { 
						 comments_template( '', true ); // show comments 
					}
				?>
			</div>
		</div>
	</div>
</div> 
<?php get_footer(); ?>

