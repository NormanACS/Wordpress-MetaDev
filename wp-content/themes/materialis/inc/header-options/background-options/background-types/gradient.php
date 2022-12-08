<?php


add_filter('materialis_header_background_types', 'materialis_header_background_gradient');

function materialis_header_background_gradient($types)
{
    $types['gradient'] = esc_html__('Gradient', 'materialis');

    return $types;
}

function materialis_header_background_atts_gradient($attrs, $bg_type, $inner)
{
    if ($bg_type == 'gradient') {
        $prefix         = $inner ? "inner_header" : "header";
        $bgGradient     = materialis_get_theme_mod($prefix . "_gradient", "easter_blueberry");
        $attrs['class'] .= " " . esc_attr($bgGradient);
    }

    return $attrs;
}

add_filter("materialis_header_background_atts", 'materialis_header_background_atts_gradient', 1, 3);


add_filter("materialis_header_background_type_settings", 'materialis_header_background_type_gradient_settings', 2, 6);

function materialis_header_background_type_gradient_settings($section, $prefix, $group, $inner, $priority)
{

    materialis_add_kirki_field(array(
        'type'            => 'sectionseparator',
        'label'           => esc_html__('Gradient Background Options', 'materialis'),
        'section'         => $section,
        'settings'        => $prefix . '_gradient_background_options_separator',
        'priority'        => 2,
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_background_type',
                'operator' => '==',
                'value'    => 'gradient',
            ),
        ),
        'group'           => $group,
    ));

    materialis_add_kirki_field(array(
        'type'            => 'web-gradients',
        'settings'        => $prefix . '_gradient',
        'label'           => esc_html__('Header Gradient', 'materialis'),
        'section'         => $section,
        'default'         => 'easter_blueberry',
        "priority"        => 2,
        'transport'       => 'postMessage',
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_background_type',
                'operator' => '==',
                'value'    => 'gradient',
            ),
        ),
        'group'           => $group,
    ));

}
