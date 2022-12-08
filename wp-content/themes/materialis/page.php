<?php materialis_get_header();?>

<div <?php echo materialis_page_content_atts("page-content"); ?>>
  <div class="<?php materialis_page_content_wrapper_class(); ?>">
   <?php 
      while ( have_posts() ) : the_post();
        get_template_part( 'template-parts/content', 'page' );
      endwhile;
     ?>
  </div>
</div>

<?php get_footer(); ?>
