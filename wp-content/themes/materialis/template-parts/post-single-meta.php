<?php
if ( ! apply_filters('materialis_show_post_meta', true)) {
    return;
}
?>

<div class="post-meta mdc-card__actions col-padding">
    <div class="mdc-card__action-icons col-xs-12 col-sm-fit">
        <a class="post-footer-link" href="<?php echo esc_url(get_permalink()); ?>">
            <i class="mdi small mdi-comment-outline mdc-card__action mdc-card__action--icon" title="Comments"></i>
            <span class="post-footer-value"><?php echo absint(get_comments_number()); ?></span>
        </a>
        <a class="post-footer-link" href="<?php echo esc_url(get_permalink()); ?>">
            <i class="mdi small mdi-clock mdc-card__action mdc-card__action--icon" title="Post Time"></i>
            <span class="post-footer-value"><?php the_time(get_option('date_format')); ?></span>
        </a>
        <?php
        if (materialis_has_category()) {

            if (is_single()) {
                ?>
                <div class="post-footer-category">
                    <i class="mdi small mdi-folder-open mdc-card__action mdc-card__action--icon" title="Categories"></i>
                    <?php materialis_the_category(true); ?>
                </div>
                <?php
            } else {
                ?>
                <div class="post-footer-category">
                    <i class="mdi small mdi-folder-open mdc-card__action mdc-card__action--icon" title="Categories"></i>
                    <?php materialis_the_category(); ?>
                </div>
                <?php
            }


        }
        ?>
    </div>

</div>
