<?php if (get_theme_mod('title_heading', 'boxed') == 'full') { ?>
    <div class="site-header container-fluid">
        <div class="container" >
            <div class="heading-row" >
                <div class="site-heading text-center" >
                    <div class="site-branding-logo">
                        <?php the_custom_logo(); ?>
                    </div>
                    <div class="site-branding-text header-branding-text">
                        <?php if (is_front_page()) : ?>
                            <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
                        <?php else : ?>
                            <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></p>
                        <?php endif; ?>

                        <?php
                        $description = get_bloginfo('description', 'display');
                        if ($description || is_customize_preview()) :
                            ?>
                            <p class="site-description">
                                <?php echo esc_html($description); ?>
                            </p>
                        <?php endif; ?>
                    </div><!-- .site-branding-text -->
                </div>
            </div>
        </div>
    </div>
<?php } ?>