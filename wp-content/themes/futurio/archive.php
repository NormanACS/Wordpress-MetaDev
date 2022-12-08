<?php get_header(); ?>

<?php futurio_generate_header(true, true, true, false, false); ?>

<?php if (have_posts()) : ?>
    <div class="container-fluid archive-page-header">
        <header class="container text-left">
            <?php
            the_archive_title('<h1 class="page-title">', '</h1>');
            the_archive_description('<div class="taxonomy-description">', '</div>');
            ?>
        </header><!-- .archive-page-header -->
    </div>
<?php endif; ?>

<?php futurio_breadcrumbs(); ?>

<?php futurio_content_layout(); ?>

<!-- start content container -->
<div class="row">

    <div class="col-md-<?php futurio_main_content_width_columns(); ?> <?php futurio_sidebar_position('content') ?>">

        <?php
        if (have_posts()) :

            while (have_posts()) : the_post();

                get_template_part('content', get_post_format());

            endwhile;

            if (get_theme_mod('infinite_scroll', 'off') == 'off') {
                the_posts_pagination();
            }
            do_action('futurio_after_archive_pagination');

        else :

            get_template_part('content', 'none');

        endif;
        ?>

    </div>

    <?php get_sidebar(); ?>

</div>
<!-- end content container -->

<?php get_footer(); ?>
