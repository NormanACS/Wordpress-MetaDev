<?php


require_once get_template_directory() . "/inc/header-options/background-options/background-types/color.php";
require_once get_template_directory() . "/inc/header-options/background-options/background-types/image.php";
require_once get_template_directory() . "/inc/header-options/background-options/background-types/slideshow.php";
require_once get_template_directory() . "/inc/header-options/background-options/background-types/video.php";
require_once get_template_directory() . "/inc/header-options/background-options/background-types/gradient.php";

function materialis_header_background_type($inner)
{
    $prefix  = $inner ? "inner_header" : "header";
    $section = $inner ? "header_image" : "header_background_chooser";

    $group = "{$prefix}_bg_options_group_button";

    $priority = 2;

    /* background type dropdown */

    materialis_add_kirki_field(array(
        'type'              => 'select',
        'settings'          => $prefix . '_background_type',
        'label'             => esc_html__('Background Type', 'materialis'),
        'section'           => $section,
        'choices'           => apply_filters('materialis_header_background_types', array()),
        'default'           => $inner ? 'color' : 'image',
        'sanitize_callback' => 'sanitize_text_field',
        'priority'          => $priority,
    ));

    $frontChoices = array();
    $innerChoices = array('header_image');

    materialis_add_kirki_field(array(
        'type'        => 'sidebar-button-group',
        'settings'    => $group,
        'label'       => esc_html__('Options', 'materialis'),
        'section'     => $section,
        'priority'    => $priority,
        'description' => esc_html__('Options', 'materialis'),
        'in_row_with' => array($prefix . '_background_type'),
        'choices'     => $inner ? $innerChoices : $frontChoices,
    ));


    do_action("materialis_header_background_type_settings", $section, $prefix, $group, $inner, $priority);
}

function materialis_customize_register_options_header_backgroun_type()
{
    materialis_header_background_type(false);
    materialis_header_background_type(true);
}

add_action('materialis_customize_register_options', 'materialis_customize_register_options_header_backgroun_type');

function materialis_customize_register_header_image_settings_modifier($wp_customize)
{
    /** @var WP_Customize_Manager $wp_customize */
    $wp_customize->get_control('header_image')->active_callback = 'materialis_inner_header_image_active_callback';
    $wp_customize->get_control('header_image')->priority        = 4;
}

add_action('materialis_customize_register', 'materialis_customize_register_header_image_settings_modifier', 1, 1);

function materialis_inner_header_image_active_callback()
{
    $currentInnerBgType = materialis_get_theme_mod('inner_header_background_type', 'gradient');

    return ($currentInnerBgType === 'image');
}

function materialis_inner_header_bg_options_group_button_filter($items)
{
    $items = array(
        'inner_header_bg_color',
        'inner_header_image_background_options_separator',
        'header_image',
        'inner_header_bg_color_image',
        'inner_header_bg_position',
        'inner_header_show_featured_image',
        'inner_header_parallax',
        'inner_header_slideshow_background_options_separator',
        'inner_header_slideshow',
        'inner_header_slideshow_duration',
        'inner_header_slideshow_speed',
        'inner_header_video_background_options_separator',
        'inner_header_video',
        'inner_header_video_external',
        'inner_header_video_poster',
        'inner_header_gradient_background_options_separator',
        'inner_header_gradient',
    );

    return $items;
}

add_filter('inner_header_bg_options_group_button_filter', 'materialis_inner_header_bg_options_group_button_filter');
