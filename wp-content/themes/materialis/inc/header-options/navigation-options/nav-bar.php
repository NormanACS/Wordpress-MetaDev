<?php

function materialis_customize_register_options_navigation_general_options()
{
    materialis_navigation_general_options(false);
    materialis_navigation_general_options(true);
}

add_action("materialis_customize_register_options", 'materialis_customize_register_options_navigation_general_options');


function materialis_navigation_general_options($inner = false)
{
    $priority = 1;
    $section  = $inner ? "inner_page_navigation" : "front_page_navigation";
    $prefix   = $inner ? "inner_header" : "header";

    materialis_add_kirki_field(array(
        'type'     => 'sectionseparator',
        'label'    => $inner ? esc_html__('Inner Pages Navigation options', 'materialis') : esc_html__('Front Page Navigation options', 'materialis'),
        'settings' => "{$prefix}_nav_separator",
        'section'  => $section,
        'priority' => $priority,
    ));

    do_action('materialis_after_navigation_separator_option', $inner, $section, $prefix);


    materialis_add_kirki_field(array(
        'type'      => 'checkbox',
        'label'     => esc_html__('Stick to top', 'materialis'),
        'section'   => $section,
        'priority'  => $priority,
        'settings'  => "{$prefix}_nav_sticked",
        'default'   => true,
        'transport' => 'postMessage',
    ));

    materialis_add_kirki_field(array(
        'type'      => 'checkbox',
        'label'     => esc_html__('Boxed Navigation', 'materialis'),
        'section'   => $section,
        'priority'  => $priority,
        'settings'  => "{$prefix}_nav_boxed",
        'default'   => false,
        'transport' => 'refresh',
    ));


    materialis_add_kirki_field(array(
        'type'      => 'checkbox',
        'label'     => esc_html__('Show Navigation Bottom Border', 'materialis'),
        'section'   => $section,
        'priority'  => $priority,
        'settings'  => "{$prefix}_nav_border",
        'default'   => materialis_mod_default("{$prefix}_nav_border", "#ffffff"),
        'transport' => 'postMessage',
    ));


    $group = $prefix . '_nav_border_group_button';

    materialis_add_kirki_field(array(
        'type'            => 'sectionseparator',
        'label'           => esc_html__('Bottom Border Options', 'materialis'),
        'section'         => $section,
        'settings'        => $prefix . '_nav_border_color_options_separator',
        'priority'        => $priority,
        'group'           => $group,
        'active_callback' => array(
            array(
                'setting'  => "{$prefix}_nav_border",
                'operator' => '==',
                'value'    => true,
            ),
        ),
    ));

    $selector_start = $inner ? ".materialis-inner-page" : ".materialis-front-page";

    materialis_add_kirki_field(array(
        'type'            => 'color',
        'label'           => esc_html__('Bottom Border Color', 'materialis'),
        'section'         => $section,
        'settings'        => $prefix . '_nav_border_color',
        'priority'        => $priority,
        'choices'         => array(
            'alpha' => true,
        ),
        'default'         => materialis_mod_default("{$prefix}_nav_border_color", "#ffffff"),
        'transport'       => 'postMessage',
        "output"          => array(
            array(
                'element'  => "{$selector_start} .navigation-bar.bordered",
                'property' => 'border-bottom-color',
            ),
        ),
        'js_vars'         => array(
            array(
                'element'  => "{$selector_start} .navigation-bar.bordered",
                'property' => 'border-bottom-color',
                'function' => 'style',
            ),
        ),
        'group'           => $group,
        'active_callback' => array(
            array(
                'setting'  => "{$prefix}_nav_border",
                'operator' => '==',
                'value'    => true,
            ),
        ),
    ));

    materialis_add_kirki_field(array(
        'type'            => 'number',
        'label'           => esc_html__('Bottom Border Thickness', 'materialis'),
        'section'         => $section,
        'settings'        => $prefix . '_nav_border_thickness',
        'choices'         => array(
            'min'  => 1,
            'max'  => 50,
            'step' => 1,
        ),
        'default'         => materialis_mod_default("header_nav_border_thickness", "2"),
        'priority'        => $priority,
        'transport'       => 'postMessage',
        "output"          => array(
            array(
                'element'  => "{$selector_start} .navigation-bar.bordered:not(.fixto-fixed)",
                'property' => 'border-bottom-width',
                'suffix'   => 'px',
            ),
            array(
                'element'       => "{$selector_start} .navigation-bar.bordered",
                'property'      => 'border-bottom-style',
                'value_pattern' => 'solid',
            ),
        ),
        'js_vars'         => array(
            array(
                'element'  => "{$selector_start} .navigation-bar.bordered:not(.fixto-fixed)",
                'property' => 'border-bottom-width',
                'suffix'   => 'px',
                'function' => 'css',
            ),
            array(
                'element'       => "{$selector_start} .navigation-bar.bordered",
                'property'      => 'border-bottom-style',
                'function'      => 'css',
                'value_pattern' => 'solid',
            ),
        ),
        'group'           => $group,
        'active_callback' => array(
            array(
                'setting'  => "{$prefix}_nav_border",
                'operator' => '==',
                'value'    => true,
            ),
        ),

    ));

    materialis_add_kirki_field(array(
        'type'            => 'sidebar-button-group',
        'settings'        => $prefix . '_nav_border_group_button',
        'label'           => esc_html__('Border Options', 'materialis'),
        'section'         => $section,
        'priority'        => $priority,
        'active_callback' => array(
            array(
                'setting'  => "{$prefix}_nav_border",
                'operator' => '==',
                'value'    => true,
            ),
        ),
    ));

    materialis_add_kirki_field(array(
        'type'      => 'checkbox',
        'label'     => esc_html__('Transparent Nav Bar', 'materialis'),
        'section'   => $section,
        'priority'  => $priority,
        'settings'  => "{$prefix}_nav_transparent",
        'default'   => materialis_mod_default("{$prefix}_nav_transparent"),
        'transport' => 'postMessage',
        'update'    => apply_filters('materialis_transparent_navigation_settings_partial_update', array(), $prefix),
    ));

    materialis_add_kirki_field(array(
        'type'      => 'ope-info-pro',
        'label'     => esc_html__('More colors and typography options available in PRO. @BTN@', 'materialis'),
        'section'   => $section,
        'priority'  => $priority,
        'settings'  => "{$prefix}_nav_pro_info",
        'default'   => true,
        'transport' => 'postMessage',
    ));

    materialis_add_kirki_field(array(
        'type'     => 'select',
        'settings' => "{$prefix}_nav_bar_type",
        'label'    => esc_html__('Navigation bar type', 'materialis'),
        'section'  => $section,
        'default'  => 'default',
        'choices'  => apply_filters('materialis_navigation_types', array(
            'default'         => esc_html__('Logo on left, Navigation on right', 'materialis'),
            'logo-above-menu' => esc_html__('Logo on center, Navigation below', 'materialis'),

        )),
        'update'   => apply_filters('materialis_nav_bar_menu_settings_partial_update', array(
            array(
                "value"  => "default",
                "fields" => array(
                    "{$prefix}_nav_menu_items_align"   => 'flex-end',
                    "{$prefix}_fixed_menu_items_align" => 'flex-end',
                ),
            ),
            array(
                "value"  => "logo-above-menu",
                "fields" => array(
                    "{$prefix}_nav_menu_items_align"   => 'center',
                    "{$prefix}_fixed_menu_items_align" => 'flex-end',
                ),
            ),

        ), $prefix),
        'priority' => $priority,
    ));

    materialis_add_kirki_field(array(
        'type'     => 'select',
        'settings' => "{$prefix}_nav_style",
        'label'    => esc_html__('Navigation style', 'materialis'),
        'section'  => $section,
        'default'  => 'material-buttons',
        'choices'  => apply_filters('materialis_navigation_styles', array(
            'simple-text-buttons' => esc_html__('Simple text menu', 'materialis'),
            'material-buttons'    => esc_html__('Material Buttons', 'materialis'),
        )),
        'priority' => $priority,

        'transport' => apply_filters('materialis_nav_style_transport', 'refresh'),
    ));


    do_action('materialis_after_navigation_options_area', $inner, $section, $prefix, $priority);
}


/*
    template functions
*/

function materialis_get_offcanvas_primary_menu()
{
    ?>
    <a href="#" data-component="offcanvas" data-target="#offcanvas-wrapper" data-direction="right" data-width="300px" data-push="false">
        <div class="bubble"></div>
        <i class="mdi mdi-view-sequential"></i>
    </a>
    <div id="offcanvas-wrapper" class="hide force-hide offcanvas-right">
        <div class="offcanvas-top">
            <div class="logo-holder">
                <?php materialis_print_logo(); ?>
            </div>
        </div>
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'menu_id'        => 'offcanvas_menu',
            'menu_class'     => 'offcanvas_menu',
            'container_id'   => 'offcanvas-menu',
            'fallback_cb'    => 'materialis_no_hamburger_menu_cb',
        ));
        ?>

        <?php do_action("materialis_offcanvas_primary_menu_footer"); ?>
    </div>
    <?php
}


function materialis_print_primary_menu($walker = '', $fallback = 'materialis_nomenu_cb')
{

    $drop_down_menu_classes = apply_filters('materialis_primary_drop_menu_classes', array('default'));
    $drop_down_menu_classes = array_merge($drop_down_menu_classes, array('main-menu', 'dropdown-menu'));

    wp_nav_menu(array(
        'theme_location'  => 'primary',
        'menu_id'         => 'main_menu',
        'menu_class'      => esc_attr(implode(" ", $drop_down_menu_classes)),
        'container_id'    => 'mainmenu_container',
        'container_class' => 'row',
        'fallback_cb'     => $fallback,
        'walker'          => $walker,
    ));

    materialis_get_offcanvas_primary_menu();
}

function materialis_print_footer_menu()
{
    wp_nav_menu(array(
        'theme_location'  => 'footer_menu',
        'menu_id'         => 'materialis-footer-menu',
        'menu_class'      => 'materialis-footer-menu',
        'container_class' => 'materialis-footer-menu',
        'fallback_cb'     => 'materialis_footer_nomenu_cb',
        'depth'           => 1,
    ));
}


// sticky navigation
function materialis_navigation_sticky_attrs()
{
    $inner = materialis_is_inner(true);
    $atts  = array(
        "data-sticky"        => 0,
        "data-sticky-mobile" => 1,
        "data-sticky-to"     => "top",
    );

    $atts   = apply_filters("materialis_navigation_sticky_attrs", $atts);
    $prefix = $inner ? "inner_header" : "header";

    $result = "";
    if (get_theme_mod("{$prefix}_nav_sticked", true)) {
        foreach ($atts as $key => $value) {
            $result .= " " . esc_attr($key) . "='" . esc_attr($value) . "' ";
        }
    }

    echo $result;
}

function materialis_navigation_wrapper_class($mainClass = array())
{
    $inner   = materialis_is_inner(true);
    $classes = array();

    $prefix  = $inner ? "inner_header" : "header";
    $isBoxed = materialis_get_theme_mod("{$prefix}_nav_boxed", false);

    if ($isBoxed) {
        $classes[] = "gridContainer";
    }

    $classes = apply_filters("materialis_navigation_wrapper_class", $classes, $inner);

    if ( ! is_array($mainClass)) {
        if (is_string($mainClass)) {
            $mainClass = array($mainClass);
        } else {
            $mainClass = array();
        }
    }

    $classes = array_merge($classes, $mainClass);

    return implode(" ", $classes);
}

add_filter('materialis_navigation', 'materialis_navigation_bar_type');

function materialis_navigation_bar_type($template)
{

    if ( ! $template) {
        $setting         = materialis_is_front_page(true) ? "header_nav_bar_type" : "inner_header_nav_bar_type";
        $settingTemplate = materialis_get_theme_mod($setting, 'default');

        if ($settingTemplate !== 'default') {
            $template = $settingTemplate;
        }

    }

    return $template;
}


function materialis_primary_drop_menu_classes($classes)
{
    $prefix          = materialis_is_front_page(true) ? "header" : "inner_header";
    $variation_class = materialis_get_theme_mod("{$prefix}_nav_style", "material-buttons");
    $result          = array();

    foreach ($classes as $class) {
        if ($class !== "default") {
            $result[] = $class;
        }
    }

    $result[] = $variation_class;

    return $result;
}

add_filter('materialis_primary_drop_menu_classes', 'materialis_primary_drop_menu_classes');
