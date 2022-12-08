<?php
/*
 * Template Name: Front Page Template
 */
materialis_get_header('homepage');
?>

<div <?php echo materialis_page_content_atts(); ?>>
    <div class="<?php materialis_page_content_wrapper_class(); ?>">
        <?php
        while (have_posts()) : the_post();
            the_content();
        endwhile;
        ?>
    </div>
</div>

<?php get_footer(); ?>
