<div id="post-<?php the_ID(); ?>"<?php post_class(); ?>>

    <div class="post-content-single mdc-card">

        <div class="post-content-inner">

            <?php

            if (has_post_thumbnail()) {

                the_post_thumbnail();

            }

            ?>
            <div class="col-padding">
                <?php materialis_single_item_title($before = "<h3>", $after = "</h3>"); ?>
                <?php
                the_content();
                wp_link_pages(array(
                    'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__('Pages:', 'materialis') . '</span>',
                    'after'       => '</div>',
                    'link_before' => '<span>',
                    'link_after'  => '</span>',
                    'pagelink'    => '<span class="screen-reader-text">' . esc_html__('Page', 'materialis') . ' </span>%',
                    'separator'   => '<span class="screen-reader-text">, </span>',
                ));
                ?>
                <?php echo get_the_tag_list('<p class="tags-list"><i data-cp-mdi="true" class="font-icon-25 fa fa-tags"></i>&nbsp;', ' ', '</p>'); ?>
            </div>
        </div>
        <?php get_template_part('template-parts/post-single-meta') ?>
    </div>


    <?php
    if (comments_open() || get_comments_number()):
        comments_template();
    endif;
    ?>

    <?php

    the_post_navigation(array(

        'next_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__('Next:', 'materialis') . '</span> ' .
                       '<span class="screen-reader-text">' . esc_html__('Next post:', 'materialis') . '</span> ' .
                       '<span class="post-title">%title</span><i class="font-icon-post mdi mdi-chevron-right"></i>',

        'prev_text' => '<i class="font-icon-post mdi mdi-chevron-left"></i>' .
                       '<span class="meta-nav" aria-hidden="true">' . esc_html__('Previous:', 'materialis') . '</span> ' .
                       '<span class="screen-reader-text">' . esc_html__('Previous post:', 'materialis') . '</span> ' .
                       '<span class="post-title">%title</span>',

    ));

    ?>


</div>
