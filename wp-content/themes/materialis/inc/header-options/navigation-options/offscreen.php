<?php

add_action("materialis_customize_register_options", 'materialis_offscreen_menu_settings', 1);

function materialis_offscreen_menu_settings()
{
    $prefix   = "header_offscreen_nav";
    $section  = "navigation_offscreen";
    $priority = 1;

    materialis_add_kirki_field(array(
        'type'     => 'sectionseparator',
        'label'    => esc_html__('Offscreen Menu Settings', 'materialis'),
        'settings' => "{$prefix}_settings_separator",
        'section'  => $section,
        'priority' => $priority,
    ));

    materialis_add_kirki_field(array(
        'type'     => 'checkbox',
        'settings' => "{$prefix}_on_tablet",
        'label'    => esc_html__('Show offscreen navigation on tablet', 'materialis'),
        'section'  => $section,
        'default'  => false,
        'priority' => $priority,

    ));

    materialis_add_kirki_field(array(
        'type'     => 'checkbox',
        'settings' => "{$prefix}_on_desktop",
        'label'    => esc_html__('Show offscreen navigation on desktop', 'materialis'),
        'section'  => $section,
        'default'  => false,
        'priority' => $priority,

    ));


    materialis_add_kirki_field(array(
        'type'      => 'ope-info-pro',
        'label'     => esc_html__('More colors and typography options available in PRO. @BTN@', 'materialis'),
        'section'   => $section,
        'priority'  => $priority,
        'settings'  => "{$prefix}_offscreen_pro_info",
        'default'   => true,
        'transport' => 'postMessage',
    ));

}


// APPLY OFFSCREEN FILTERS

function materialis_header_offscreen_nav_filter($classes)
{
    $prefix = "header_offscreen_nav";

    $offscreen_on_tablet  = materialis_get_theme_mod("{$prefix}_on_tablet", false);
    $offscreen_on_desktop = materialis_get_theme_mod("{$prefix}_on_desktop", false);

    if (intval($offscreen_on_desktop)) {
        $classes[] = "offcanvas_menu-desktop";
    }
    if (intval($offscreen_on_tablet)) {
        $classes[] = "offcanvas_menu-tablet";
    }

    return $classes;
}

add_filter('body_class', 'materialis_header_offscreen_nav_filter');
