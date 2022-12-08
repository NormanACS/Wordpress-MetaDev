<?php $sortable_value = maybe_unserialize(get_theme_mod('top_bar_sort', array())); ?>
<?php if (!empty($sortable_value)) : ?>
    <?php $count = ( 12 / count($sortable_value) ); ?>
    <?php $i = 1; ?>
    <div class="top-bar-section container-fluid">
        <div class="<?php echo esc_attr(get_theme_mod('top_bar_content_width', 'container')); ?>">
            <div class="row">
                <?php foreach ($sortable_value as $checked_value) : ?>
                    <?php
                    switch ($checked_value) {
                        case 'textarea_1' :
                            ?>
                            <div id="<?php echo esc_attr($checked_value); ?>" class="top-bar-item col-sm-<?php echo absint($count); ?>">
                                <?php echo wp_kses_post(do_shortcode(get_theme_mod('top_bar_textarea_one', ''))); ?>                 
                            </div>
                            <?php
                            break;
                        case 'textarea_2' :
                            ?>
                            <div id="<?php echo esc_attr($checked_value); ?>" class="top-bar-item col-sm-<?php echo absint($count); ?>">
                                <?php echo wp_kses_post(do_shortcode(get_theme_mod('top_bar_textarea_two', ''))); ?>                 
                            </div>
                            <?php
                            break;
                        case 'icons' :
                            ?>
                            <div id="<?php echo esc_attr($checked_value); ?>" class="top-bar-item col-sm-<?php echo absint($count); ?>">
                                <?php
                                if (function_exists('futurio_pro_social_links')) {
                                    futurio_pro_social_links();
                                } elseif (function_exists('futurio_extra_social_links')) {
                                    futurio_extra_social_links();
                                }
                                ?>                 
                            </div>
                            <?php
                            break;
                            $i++;
                    }
                endforeach;
                ?>
            </div>
        </div>
    </div>	
<?php endif; ?>