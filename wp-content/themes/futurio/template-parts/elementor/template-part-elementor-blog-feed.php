<?php
$elementor_section_ID = get_theme_mod('custom_blog_feed', '');
$columns = get_theme_mod('custom_blog_feed_column', 1);
$column = 12 / $columns;
?>
<article <?php post_class('elementor-news col-md-' . absint($column) . ''); ?>>
    <div class="news-item">

        <?php echo do_shortcode('[elementor-template id="' . $elementor_section_ID . '"]'); ?>

    </div><!-- .news-item -->
</article>
