<?php
get_header();

futurio_generate_header(true, true, true, false, false, true);
?>
<!-- start content container -->
<div class="row">
    <article class="col-md-<?php futurio_main_content_width_woo_columns(); ?> <?php futurio_sidebar_position('content-woo') ?>">
        <div class="futurio-woo-content single-content">
            <?php woocommerce_content(); ?>
        </div>	
    </article>
    <?php
    if (futurio_get_meta('sidebar') != 'no_sidebar') {
        get_sidebar('woo');
    }
    ?>
</div>
<!-- end content container -->

<?php
get_footer();
