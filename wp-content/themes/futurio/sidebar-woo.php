<?php if (is_active_sidebar('futurio-woo-right-sidebar') || ( ( ( function_exists('is_shop') && is_shop() ) || is_product_tag() || is_product_category() ) && is_active_sidebar('futurio-woo-archive-sidebar') )) { ?>
    <aside id="sidebar" class="col-md-<?php echo absint(get_theme_mod('sidebar_size', '3')) ?> <?php futurio_sidebar_position('sidebar-woo') ?>">
        <?php
        if (( ( function_exists('is_shop') && is_shop() ) || is_product_tag() || is_product_category() ) && is_active_sidebar('futurio-woo-archive-sidebar')) {
            dynamic_sidebar('futurio-woo-archive-sidebar');
        } else {
            dynamic_sidebar('futurio-woo-right-sidebar');
        }
        ?>
    </aside>
<?php } ?>
