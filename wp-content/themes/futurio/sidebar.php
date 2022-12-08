<?php if (is_active_sidebar('futurio-sidebar') || ( is_archive() || is_search() ) && is_active_sidebar('futurio-archive-sidebar')) { ?>
    <aside id="sidebar" class="col-md-<?php echo absint(get_theme_mod('sidebar_size', '3')) ?> <?php futurio_sidebar_position('sidebar') ?>">
        <?php
        if (( is_archive() || is_search() ) && is_active_sidebar('futurio-archive-sidebar')) {
            dynamic_sidebar('futurio-archive-sidebar');
        } else {
            dynamic_sidebar('futurio-sidebar');
        }
        ?>
    </aside>
<?php } ?>
