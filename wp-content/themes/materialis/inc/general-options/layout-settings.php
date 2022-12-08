<?php

function materialis_add_layout_options()
{

    $section = 'layout_settings';

    if (apply_filters('materialis_is_companion_installed', false)) {
        $section = 'page_content_settings';
    }

    $priority = 1;

    materialis_add_kirki_field(array(
        'type'     => 'sectionseparator',
        'settings' => "layout_section_settings_separator",
        'label'    => esc_html__('Layout Settings', 'materialis'),
        'section'  => $section,
        'priority' => $priority,
    ));

    materialis_add_kirki_field(array(
        'type'      => 'checkbox',
        'settings'  => 'layout_boxed_content_enabled',
        'label'     => esc_html__('Enable Boxed Content', 'materialis'),
        'section'   => $section,
        'default'   => false,
        'transport' => 'postMessage',
    ));

    materialis_add_kirki_field(array(
        'type'            => 'color',
        'settings'        => 'layout_boxed_content_background_color',
        'label'           => esc_html__('Box Background Color', 'materialis'),
        'section'         => $section,
        'default'         => '#f5fafd',
        'choices'         => array(
            'alpha' => true,
        ),
        'active_callback' => array(
            array(
                'setting'  => 'layout_boxed_content_enabled',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'transport'       => 'postMessage',
        'output'          => array(
            array(
                'element'  => '#page',
                'property' => 'background-color',
            ),
        ),
    ));

    materialis_add_kirki_field(array(
        'type'            => 'number',
        'settings'        => 'layout_boxed_content_overlap_height',
        'label'           => esc_html__('Overlap Height', 'materialis'),
        'section'         => $section,
        'default'         => 50,
        'choices'         => array(
            'min' => 0,
            'max' => 100,
        ),
        'transport'       => 'postMessage',
        'active_callback' => array(
            array(
                'setting'  => 'layout_boxed_content_enabled',
                'operator' => '==',
                'value'    => true,
            ),
        ),
    ));
}

materialis_add_layout_options();


function materialis_page_content_atts_boxed_layout_content($attrs)
{

    $boxed_enabled = materialis_get_theme_mod('layout_boxed_content_enabled', false);
    if (intval($boxed_enabled)) {
        $overlap_height = materialis_get_theme_mod('layout_boxed_content_overlap_height', 50);

        $attrs['class'] .= " mdc-elevation--z20 ";
        $attrs['class'] .= " boxed-layout ";
        $attrs['style'] .= "margin-top:-" . esc_attr($overlap_height) . "px";
    }

    return $attrs;
}

add_filter("materialis_page_content_atts", 'materialis_page_content_atts_boxed_layout_content', 1, 1);

function materialis_page_content_atts($class = "page-content")
{

    $attrs = array(
        'class' => $class,
        'style' => "",
        'id' => 'page-content'
    );

    $attrs = apply_filters('materialis_page_content_atts', $attrs);

    $result = "";
    foreach ($attrs as $key => $value) {
        $value  = trim($value);
        $result .= " {$key}='" . esc_attr($value) . "'";
    }

    return $result;
}
