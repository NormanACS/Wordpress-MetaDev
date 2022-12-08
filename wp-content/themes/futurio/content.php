<?php
if (get_theme_mod('custom_blog_feed', '') != '' && futurio_check_elementor()) {
    get_template_part('template-parts/elementor/template-part', 'elementor-blog-feed');
} else {
    ?>
    <article <?php post_class('futurio-post'); ?>>
        <div class="news-item row">
            <?php futurio_thumb_img('futurio-med', 'col-md-6'); ?>
            <?php if (has_post_thumbnail()) { ?>
                <div class="news-text-wrap col-md-6">
                <?php } else { ?>
                    <div class="news-text-wrap col-md-12">
                    <?php } ?>
                    <div class="content-date-comments">
                        <?php futurio_widget_date_comments(); ?>
                    </div>
                    <?php
                    the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                    if (get_theme_mod('blog_archive_author', 'on') == 'on') {
                        futurio_author_meta();
                    }
                    ?>
                    <div class="post-excerpt">
                        <?php the_excerpt(); ?>
                    </div><!-- .post-excerpt -->
                </div><!-- .news-text-wrap -->
            </div><!-- .news-item -->
    </article>
    <?php
}
