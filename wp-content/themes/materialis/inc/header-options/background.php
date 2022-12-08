<?php

require_once get_template_directory() . "/inc/header-options/background-options/background-type.php";
require_once get_template_directory() . "/inc/header-options/background-options/overlay-type.php";
require_once get_template_directory() . "/inc/header-options/background-options/header-separator.php";
require_once get_template_directory() . "/inc/header-options/background-options/general.php";
require_once get_template_directory() . "/inc/header-options/background-options/bottom-arrow.php";

function materialis_header_background_settings($inner)
{
    $prefix  = $inner ? "inner_header" : "header";
    $section = $inner ? "header_image" : "header_background_chooser";

    $group = "{$prefix}_bg_options_group_button";

    $priority = 1;
    materialis_add_kirki_field(array(
        'type'     => 'sectionseparator',
        'label'    => __('Background', 'materialis'),
        'section'  => $section,
        'priority' => $priority,
        'settings' => $prefix . "_header_1",
    ));

    do_action("materialis_header_background_settings", $section, $prefix, $group, $inner, $priority);
}

function materialis_customize_register_options_header_bg_settings()
{
    materialis_header_background_settings(false);
    materialis_header_background_settings(true);
}

add_action("materialis_customize_register_options", 'materialis_customize_register_options_header_bg_settings');


/*
    template functions
*/

function materialis_header_background_atts_full_height_header($attrs, $bg_type, $inner)
{
    if ( ! $inner) {
        $full_height_header = materialis_get_theme_mod('full_height_header', false);

        if ($full_height_header) {
            $attrs['style'] .= "; min-height:100vh";
        }
    }

    return $attrs;
}

add_filter("materialis_header_background_atts", 'materialis_header_background_atts_full_height_header', 1, 3);


function materialis_header_background_atts()
{
    $inner = materialis_is_inner(true);
    $attrs = array(
        'class' => $inner ? "header " : "header-homepage ",
        'style' => "",
    );

    $prefix = $inner ? "inner_header" : "header";
    $bgType = materialis_get_theme_mod($prefix . '_background_type', $inner ? 'color' : 'image');
//    $bgType = apply_filters('materialis_' . $prefix . '_background_type', $bgType);

    do_action("materialis_background", $bgType, $inner, $prefix);

    $attrs  = apply_filters('materialis_header_background_atts', $attrs, $bgType, $inner);
    $result = "";
    foreach ($attrs as $key => $value) {
        $value  = trim(esc_attr($value));
        $result .= " {$key}='" . esc_attr($value) . "'";
    }

    return $result;
}
