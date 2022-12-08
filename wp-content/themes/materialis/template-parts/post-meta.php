<?php
if ( ! apply_filters('materialis_show_post_meta', true)) {
    return;
}
?>

<a class="post-footer-link" href="<?php echo esc_url(get_permalink()); ?>">
    <i class="mdi small mdi-comment-outline mdc-card__action mdc-card__action--icon" title="<?php esc_attr_e('Comments', 'materialis'); ?>"></i>
    <span class="post-footer-value"><?php echo absint(get_comments_number()); ?></span>
</a>

<a class="post-footer-link" href="<?php echo esc_url(get_permalink()); ?>">
    <i class="mdi small mdi-clock mdc-card__action mdc-card__action--icon" title="<?php esc_attr_e('Post Time', 'materialis'); ?>"></i>
    <span class="post-footer-value"><?php the_time(get_option('date_format')); ?></span>
</a>
<?php
if (materialis_has_category()) {
    ?>
    <div class="post-footer-category">
        <i class="mdi small mdi-folder-open mdc-card__action mdc-card__action--icon" title="<?php esc_attr_e('Categories', 'materialis'); ?>"></i>
        <?php materialis_the_category(); ?>
    </div>
    <?php
}
?>
