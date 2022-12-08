<div class="<?php materialis_print_archive_entry_class(); ?>" data-masonry-width="<?php materialis_print_masonry_col_class(true); ?>">
    <div id="post-<?php the_ID(); ?>" <?php post_class('blog-post mdc-card mdc-elevation--z3'); ?>>

        <?php materialis_print_post_thumb(); ?>

        <div class="flexbox">
            <div class="col-xs-12 col-padding">
                <h3 class="post-title">
                    <a href="<?php the_permalink(); ?>" rel="bookmark">
                        <?php the_title(); ?>
                    </a>
                </h3>
                <div class="post-excerpt"><?php the_excerpt(); ?></div>

            </div>
        </div>
        <div class="mdc-card__actions col-padding">
            <div class="mdc-card__action-icons col-xs-12 col-sm-fit">
                <?php get_template_part('template-parts/post-meta'); ?>
            </div>
            <div class="mdc-card__action-buttons col-xs-12 col-sm-fit">
                <a href="<?php the_permalink(); ?>" class="button color2 link"><?php _e('Read more', 'materialis') ?></a>
            </div>
        </div>

    </div>
</div>
