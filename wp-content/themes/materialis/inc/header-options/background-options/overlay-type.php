<?php

require_once get_template_directory() . "/inc/header-options/background-options/overlay-types/color-overlay.php";
require_once get_template_directory() . "/inc/header-options/background-options/overlay-types/gradient-overlay.php";
require_once get_template_directory() . "/inc/header-options/background-options/overlay-types/shapes-overlay.php";

function materialis_header_overlay_options($section, $prefix, $group, $inner, $priority)
{
    $prefix   = $inner ? "inner_header" : "header";
    $section  = $inner ? "header_image" : "header_background_chooser";
    $priority = 3;

    $group = "{$prefix}_overlay_options_group_button";

    materialis_add_kirki_field(array(
        'type'     => 'checkbox',
        'settings' => $prefix . '_show_overlay',
        'label'    => esc_html__('Show overlay', 'materialis'),
        'section'  => $section,
        'default'  => true,
        'priority' => $priority,
    ));


    materialis_add_kirki_field(array(
        'type'     => 'sectionseparator',
        'label'    => esc_html__('Overlay Options', 'materialis'),
        'section'  => $section,
        'settings' => $prefix . '_overlay_header',
        'group'    => $group,
    ));

    materialis_add_kirki_field(array(
        'type'     => 'select',
        'settings' => $prefix . '_overlay_type',
        'label'    => esc_html__('Overlay Type', 'materialis'),
        'section'  => $section,
        'choices'  => apply_filters('materialis_overlay_types', array(
            'none' => esc_html__('Shape Only', 'materialis'),
        )),
        'default'  => materialis_mod_default($prefix . '_overlay_type'),
        'group'    => $group,
        'update'   => apply_filters('materialis_overlay_shapes_partial_update', array(
            array(
                "value"  => "none",
                "fields" => array(
                    $prefix . '_overlay_shape' => 'circles',
                ),
            ),
            array(
                "value"  => "color",
                "fields" => array(
                    $prefix . '_overlay_shape' => 'none',
                ),
            ),
            array(
                "value"  => "gradient",
                "fields" => array(
                    $prefix . '_overlay_shape' => 'none',
                ),
            ),
        )),
    ));

    materialis_add_kirki_field(array(
        'type'            => 'sidebar-button-group',
        'settings'        => $group,
        'label'           => esc_html__('Options', 'materialis'),
        'section'         => $section,
        'in_row_with'     => array($prefix . '_show_overlay'),
        'priority'        => $priority,
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_show_overlay',
                'operator' => '==',
                'value'    => true,
            ),
        ),
    ));

    do_action("materialis_header_background_overlay_settings", $section, $prefix, $group, $inner, $priority);
}

function materialis_header_background_settings_main_hook($section, $prefix, $group, $inner, $priority)
{
    materialis_header_overlay_options($section, $prefix, $group, $inner, $priority);
}

add_action("materialis_header_background_settings", 'materialis_header_background_settings_main_hook', 2, 5);
