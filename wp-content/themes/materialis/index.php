<?php materialis_get_header(); ?>

    <div <?php echo materialis_page_content_atts("content blog-page"); ?>>
    <div class="gridContainer <?php materialis_page_content_wrapper_class(); ?>">
        <div class="row">
            <div class="col-xs-12 <?php echo materialis_posts_wrapper_class(); ?>">
                <div class="post-list row">
                    <?php
                    if (have_posts()):
                        while (have_posts()):
                            the_post();
                            get_template_part('template-parts/content', get_post_format());
                        endwhile;
                    else:
                        get_template_part('template-parts/content', 'none');
                    endif;
                    ?>
                </div>
                <div class="navigation-c">
                    <?php
                    if (have_posts()):
                        materialis_print_pagination(array(
                            'prev_text'          =>'<i class="mdi mdi-arrow-left"></i>',
                            'next_text'          =>'<i class="mdi mdi-arrow-right"></i>',
                            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'materialis') . ' </span>',
                        ));
                    endif;
                    ?>
                </div>
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>
<?php get_footer();

