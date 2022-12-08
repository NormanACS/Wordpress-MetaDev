<?php

function materialis_header_background_overlay_settings_register_shapes($section, $prefix, $group, $inner, $priority)
{
    $header_class = $inner ? ".header" : ".header-homepage";

    materialis_add_kirki_field(array(
        'type'    => 'select',
        'label'   => esc_html__('Overlay Shapes', 'materialis'),
        'section' => $section,

        'settings'        => $prefix . '_overlay_shape',
        'default'         => "none",
        'priority'        => $priority,
        'choices'         => materialis_get_header_shapes_overlay(),
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_show_overlay',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'group'           => $group,
    ));

    materialis_add_kirki_field(array(
        'type'      => 'slider',
        'label'     => esc_html__('Shape Light', 'materialis'),
        'section'   => $section,
        'priority'  => $priority,
        'settings'  => $prefix . '_overlay_shape_light',
        'default'   => 0,
        'transport' => 'postMessage',
        'choices'   => array(
            'min'  => '0',
            'max'  => '100',
            'step' => '1',
        ),

        "output" => array(
            array(
                'element'       => $header_class . '.color-overlay:after',
                'property'      => 'filter',
                'value_pattern' => 'invert($%) ',
            ),
        ),

        'js_vars'         => array(
            array(
                'element'       => $header_class . '.color-overlay:after',
                'function'      => 'css',
                'property'      => 'filter',
                'value_pattern' => 'invert($%) ',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_overlay_shape',
                'operator' => '!=',
                'value'    => 'none',

            ),
        ),
        'group'           => $group,
    ));

}

add_action("materialis_header_background_overlay_settings", 'materialis_header_background_overlay_settings_register_shapes', 1, 5);


function materialis_get_header_shape_overlay_value($shape, $shapes = false)
{
    if ( ! $shapes) {
        $shapes = materialis_get_header_shapes();
    }

    $shapeObj = $shapes[$shape];
    $isTile   = $shapeObj['tile'];
    $shapeURL = isset($shapeObj['url']) ? $shapeObj['url'] : false;

    if ($shapeURL) {
        $url = esc_url("$shapeURL/{$shape}.png");
    } else {
        $url = esc_url(get_template_directory_uri() . "/assets/images/header-shapes/{$shape}.png");
    }


    $value = "url({$url})";

    if ($isTile) {
        $value .= " top left repeat";
    } else {
        $value .= " center center/ cover no-repeat";
    }

    return $value;
}


add_action('wp_head', 'materialis_print_header_shape', PHP_INT_MAX);
function materialis_print_header_shape()
{
    $inner        = ! materialis_is_front_page(true);
    $header_class = $inner ? ".header" : ".header-homepage";
    $prefix       = $inner ? "inner_header" : "header";
    $theme_mod    = $prefix . '_overlay_shape';

    $type = materialis_get_theme_mod($theme_mod, "circles");

    if ($type != "none") {
        $selector = $header_class . '.color-overlay:after';
        $value    = materialis_get_header_shape_overlay_value($type);
        ?>
        <style data-name="header-shapes">
            <?php echo esc_html($selector)." {background:$value}"; ?>
        </style>
        <?php
    }
}


function materialis_get_header_shapes()
{
    $shapes = apply_filters("materialis_get_header_shapes_overlay_filter", array(
        'none'    => array(
            'label' => esc_html__('None', 'materialis'),
            'tile'  => false,
        ),
        'circles' => array(
            'label' => esc_html__('Circles', 'materialis'),
            'tile'  => false,
            'url'   => false,
        ),
    ));

    return $shapes;
}


function materialis_get_header_shapes_overlay($asControlOptions = true)
{

    $shapes = materialis_get_header_shapes();


    foreach ($shapes as $shape => $data) {
        $label    = $data['label'];
        $isTile   = $data['tile'];
        $shapeURL = isset($data['url']) ? $data['url'] : false;

        if ($shape === 'none') {
            $url = '#';
        } else {
            if ( ! $shapeURL) {
                $url = get_template_directory_uri() . "/assets/images/header-shapes/{$shape}.png";
            } else {
                $url = "{$shapeURL}/{$shape}.png";
            }
        }
        if ($asControlOptions) {
            $result[$shape] = $label;
        } else {
            $result[$shape] = array(
                'url'   => $url,
                'label' => $label,
                'tile'  => $isTile,
            );
        }

    }

    return $result;

}
