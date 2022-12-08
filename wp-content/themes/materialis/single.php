<?php materialis_get_header(); ?>
<div <?php echo materialis_page_content_atts("content post-page"); ?>>
    <div class="gridContainer">
        <div class="row">
            <div class=" <?php echo materialis_posts_wrapper_class(); ?>">
                <div class="post-item">
                    <?php
                    if (have_posts()):
                        while (have_posts()):
                            the_post();
                            get_template_part('template-parts/content', 'single');
                        endwhile;
                    else :
                        get_template_part('template-parts/content', 'none');
                    endif;
                    ?>
                </div>
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>

</div>
<?php get_footer(); ?>
