<?php

function materialis_defaults_dark($defaults)
{

    if (!materialis_current_default_is('dark')) {
        return $defaults;
    }

    $defaults = array_merge($defaults, array(
        'header_overlay_color'         => '#181818',
        'header_nav_style'             => 'simple-text-buttons',
        'header_overlay_opacity'       => '0.4',

        'inner_header_overlay_color'   => '#181818',
        'inner_header_nav_style'       => 'simple-text-buttons',
        'inner_header_overlay_opacity' => '0.4',
    ));

    return $defaults;
}

add_filter('materialis_defaults', 'materialis_defaults_dark');

function materialis_defaults_dark_purple($defaults)
{

    if (!materialis_current_default_is('dark-purple')) {
        return $defaults;
    }

    $defaults = array_merge($defaults, array(
        'header_front_page_image'      => get_template_directory_uri() . '/assets/images/curve-1209392.jpg',
        'inner_page_header_background' => get_template_directory_uri() . '/assets/images/curve-1209392.jpg',
        'header_overlay_color'         => '#181818',
        'header_nav_style'             => 'simple-text-buttons',
        'header_overlay_opacity'       => '0.4',
        // 'header_nav_transparent'                        => false,
        // 'inner_header_nav_transparent'                  => false,
        'inner_header_overlay_color'   => '#181818',
        'inner_header_nav_style'       => 'simple-text-buttons',
        'inner_header_overlay_opacity' => '0.4',
        'header_content_buttons'       => array(
            array(
                'label'  => __('Action Button 1', 'materialis'),
                'url'    => '#',
                'target' => '_self',
                'class'  => 'button btn-default big color1 mdc-elevation--z3',
            ),
            array(
                'label'  => __('Action Button 2', 'materialis'),
                'url'    => '#',
                'target' => '_self',
                'class'  => 'button btn-default big white outline mdc-elevation--z3',
            ),
        ),
    ));

    return $defaults;
}

add_filter('materialis_defaults', 'materialis_defaults_dark_purple');
