<?php do_action('futurio_before_menu'); ?> 
<div class="main-menu">
    <nav id="site-navigation" class="navbar navbar-default nav-pos-<?php echo esc_html(get_theme_mod('main_menu_float', 'left')); ?>">     
        <div class="<?php echo esc_html(get_theme_mod('main_menu_content_width', 'container')) ?>">   
            <div class="navbar-header">
                <?php if (get_theme_mod('title_heading', 'boxed') == 'boxed') { ?>
                    <div class="site-heading navbar-brand heading-menu" >
                        <div class="site-branding-logo">
                            <?php the_custom_logo(); ?>
                        </div>
                        <div class="site-branding-text">
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
                <?php } ?>	
            </div>
            <?php $sortable_menu = maybe_unserialize(get_theme_mod('main_menu_sort', array())); ?>
            <?php if (!empty($sortable_menu)) : ?>
                <div class="nav navbar-nav navbar-right icons-menu-right">
                    <?php
                    foreach ($sortable_menu as $checked_menu) :
                        switch ($checked_menu) {
                            case 'woo_cart' :
                                ?>
                                <?php if (function_exists('futurio_header_cart') && class_exists('WooCommerce')) { ?>
                                    <div class="menu-cart" >
                                        <?php futurio_header_cart(); ?>
                                    </div>	
                                    <?php
                                }
                                break;
                            case 'woo_account' :
                                ?>	
                                <?php if (function_exists('futurio_my_account') && class_exists('WooCommerce')) { ?>
                                    <div class="menu-account" >
                                        <?php futurio_my_account(); ?>
                                    </div>
                                    <?php
                                }
                                break;
                            case 'search' :
                                ?>	
                                <div class="top-search-icon">
                                    <i class="fa fa-search"></i>
                                    <?php if (class_exists('DGWT_WC_Ajax_Search') && class_exists('WooCommerce')) { ?>
                                        <div class="top-search-box">
                                            <?php echo do_shortcode('[wcas-search-form]'); ?>
                                        </div>
                                    <?php } else { ?>
                                        <div class="top-search-box">
                                            <?php get_search_form(); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php
                                break;
                            case 'widget' :
                                ?>
                                <?php if (is_active_sidebar('futurio-menu-area')) { ?>
                                    <div class="offcanvas-sidebar-toggle">
                                        <i class="fa fa-bars"></i>
                                    </div>
                                <?php } ?>
                                <?php
                                break;
                            case 'button' :
                                ?>
                                <?php if (get_theme_mod('menu_button_text', '') != '') { ?>
                                    <div class="menu-button">
                                        <a class="btn-default" href="<?php echo esc_url(get_theme_mod('menu_button_url', '')); ?>">
                                            <?php echo esc_html(get_theme_mod('menu_button_text', '')); ?>
                                        </a>
                                    </div>
                                <?php } ?>
                                <?php
                                break;
                        }
                    endforeach;
                    ?>
                </div>
            <?php endif; ?>
            <?php if (function_exists('max_mega_menu_is_enabled') && max_mega_menu_is_enabled('main_menu')) : ?>
            <?php elseif (has_nav_menu('main_menu') || has_nav_menu('main_menu_home')) : ?>
                <a href="#" id="main-menu-panel" class="open-panel" data-panel="main-menu-panel">
                    <span></span>
                    <span></span>
                    <span></span>
                    <div class="brand-absolute visible-xs"><?php esc_html_e('Menu', 'futurio'); ?></div>
                </a>
            <?php endif; ?>

            <?php
            if (is_front_page() && has_nav_menu('main_menu_home')) {
                $menu_loc = 'main_menu_home';
            } else {
                $menu_loc = 'main_menu';
            }
            wp_nav_menu(array(
                'theme_location' => $menu_loc,
                'depth' => 5,
                'container' => 'div',
                'container_class' => 'menu-container',
                'menu_class' => 'nav navbar-nav navbar-' . esc_html(get_theme_mod('main_menu_float', 'left')),
                'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
                'walker' => new wp_bootstrap_navwalker(),
            ));
            ?>

            <?php do_action('futurio_menu'); ?>
        </div>
    </nav> 
</div>
<?php
do_action('futurio_after_menu');
