<?php

function materialis_get_default_colors()
{
    return array(
        array("label" => esc_html__("Primary", "materialis"), "name" => "color1", "value" => "#228ae6"),
        array("label" => esc_html__("Secondary", "materialis"), "name" => "color2", "value" => "#fa5252"),
        array("label" => esc_html__("color3", "materialis"), "name" => "color3", "value" => "#82c91e"),
        array("label" => esc_html__("color4", "materialis"), "name" => "color4", "value" => "#fab005"),
        array("label" => esc_html__("color5", "materialis"), "name" => "color5", "value" => "#7950f2"),
        array("label" => esc_html__("color6", "materialis"), "name" => "color6", "value" => "#e64980"),
    );
}

function materialis_get_theme_colors($color = false)
{
    $colors = apply_filters("materialis_get_theme_colors", materialis_get_default_colors(), $color);

    if ($color) {
        global $materialis_cached_colors;

        if ( ! $materialis_cached_colors) {

            $materialis_cached_colors = array();

            foreach ($colors as $colorData) {
                $materialis_cached_colors[$colorData['name']] = $colorData['value'];
            }
        }

        if (isset($materialis_cached_colors[$color])) {
            return $materialis_cached_colors[$color];
        } else {
            return esc_html(sprintf(__("color %s not found", "materialis"), $color));
        }
    }

    return $colors;
}


function materialis_get_changed_theme_colors()
{
    $colors         = materialis_get_theme_colors();
    $default_colors = materialis_get_default_colors(true);
    $result         = array();

    foreach ($colors as $color) {
        $name = $color['name'];

        if (isset($default_colors[$name])) {
            if ($default_colors[$name] !== $color['value']) {
                $result[] = $color;
            }
        } else {
            $result[] = $color;
        }
    }

    return $result;
}

add_filter('kirki_color_picker_palettes', 'materialis_theme_kirki_palettes');

function materialis_theme_kirki_palettes($palettes)
{
    $namedColors = materialis_get_theme_colors();

    foreach ($namedColors as $name => $color) {
        if (isset($color['value'])) {
            $palettes[] = $color['value'];
        }
    }

    array_unshift($palettes, '#ffffff');
    array_unshift($palettes, '#000000');

    return array_unique($palettes);
}

materialis_add_kirki_field(array(
    'type'     => 'ope-info-pro',
    'label'    => esc_html__('Customize all theme colors in PRO. @BTN@', 'materialis'),
    'section'  => 'colors',
    'settings' => "site_colors_info_pro",
));
