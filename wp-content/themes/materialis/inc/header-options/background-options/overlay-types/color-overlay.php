<?php

function materialis_overlay_types_rigister_color($types)
{
    $types['color'] = esc_html__('Color', 'materialis');

    return $types;
}

add_filter("materialis_overlay_types", 'materialis_overlay_types_rigister_color');

function materialis_header_background_overlay_settings_main_hook($section, $prefix, $group, $inner, $priority)
{
    $header_class = $inner ? ".header" : ".header-homepage";

    materialis_add_kirki_field(array(
        'type'            => 'color',
        'label'           => esc_html__('Overlay Color', 'materialis'),
        'section'         => $section,
        'settings'        => $prefix . '_overlay_color',
        'transport'       => 'postMessage',
        'priority'        => $priority,
        'choices'         => array(
            'alpha' => false,
        ),
        "output"          => array(
            array(
                'element'  => $header_class . '.color-overlay:before',
                'property' => 'background',
            ),
        ),
        'js_vars'         => array(
            array(
                'element'  => $header_class . ".color-overlay:before",
                'function' => 'css',
                'property' => 'background',
                'suffix'   => ' !important',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_show_overlay',
                'operator' => '==',
                'value'    => true,
            ),
            array(
                'setting'  => $prefix . '_overlay_type',
                'operator' => '==',
                'value'    => 'color',
            ),
        ),
        'group'           => $group,
    ));

    materialis_add_kirki_field(array(
        'type'            => 'slider',
        'label'           => esc_html__('Overlay Opacity', 'materialis'),
        'section'         => $section,
        'priority'        => $priority,
        'settings'        => $prefix . '_overlay_opacity',
        'default'         => materialis_mod_default($prefix . '_overlay_opacity', 0.5),
        'choices'         => array(
            'min'  => '0',
            'max'  => '1',
            'step' => '0.01',
        ),
        'transport'       => 'postMessage',
        "output"          => array(
            array(
                'element'  => array(
                    $header_class . '.color-overlay::before',
                    $header_class . ' .background-overlay',
                ),
                'property' => 'opacity',
            ),
        ),
        'js_vars'         => array(
            array(
                'element'  => array(
                    $header_class . '.color-overlay::before',
                    $header_class . ' .background-overlay',
                ),
                'function' => 'css',
                'property' => 'opacity',
                'suffix'   => ' !important',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_show_overlay',
                'operator' => '==',
                'value'    => true,
            ),
            array(
                'setting'  => $prefix . '_overlay_type',
                'operator' => '==',
                'value'    => 'color',
            ),
        ),
        'group'           => $group,
    ));
}

add_action("materialis_header_background_overlay_settings", 'materialis_header_background_overlay_settings_main_hook', 1, 5);
