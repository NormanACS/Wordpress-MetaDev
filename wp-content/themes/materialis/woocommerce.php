<?php

materialis_get_header();

$materialis_wc_template_classes = apply_filters('materialis_wc_template_classes', array('gridContainer'));
?>
    <div class="page-content">
        <div class="page-column content <?php echo esc_attr((implode(' ', $materialis_wc_template_classes))) ?>">
            <div class="page-row row">
                <?php materialis_woocommerce_get_sidebar('left'); ?>
                <div class="woocommerce-page-content <?php materialis_woocommerce_container_class(); ?> col-sm">
                    <?php woocommerce_content(); ?>
                </div>
                <?php materialis_woocommerce_get_sidebar('right'); ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>
