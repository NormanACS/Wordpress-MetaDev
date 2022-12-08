<?php

function materialis_overlay_types_register_gradient($types)
{
    $types['gradient'] = esc_html__('Gradient', 'materialis');

    return $types;
}

add_filter("materialis_overlay_types", 'materialis_overlay_types_register_gradient');

function materialis_header_background_overlay_settings_register_gradient_bg($section, $prefix, $group, $inner, $priority)
{
    materialis_add_kirki_field(array(
        'type'            => 'gradient-control',
        'label'           => esc_html__('Gradient', 'materialis'),
        'section'         => $section,
        'settings'        => $prefix . '_overlay_gradient_colors',
        'default'         => json_encode(materialis_mod_default($prefix . '_overlay_gradient_colors')),
        'choices'         => array(
            'opacity' => 0.8,
        ),
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_overlay_type',
                'operator' => '==',
                'value'    => 'gradient',
            ),
            array(
                'setting'  => $prefix . '_show_overlay',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'priority'        => $priority,
        'transport'       => 'postMessage',
        'group'           => $group,
    ));
}

add_action("materialis_header_background_overlay_settings", 'materialis_header_background_overlay_settings_register_gradient_bg', 1, 5);

function materialis_print_background_overlay()
{
    $inner           = materialis_is_inner(true);
    $prefix          = $inner ? "inner_header" : "header";
    $type            = materialis_get_theme_mod($prefix . '_overlay_type', materialis_mod_default($prefix . '_overlay_type'));
    $overlay_enabled = materialis_get_theme_mod($prefix . '_show_overlay', true);
    if ($type == "gradient" && $overlay_enabled) {
        echo '<div class="background-overlay"></div>';
    }
}

add_action("materialis_before_header_background", "materialis_print_background_overlay");

function materialis_get_gradient_value($colors, $angle)
{
    $angle    = intval($angle);
    $color1   = esc_html($colors[0]['color']);
    $color2   = esc_html($colors[1]['color']);
    $gradient = "{$angle}deg , {$color1} 0%, {$color2} 100%";
    $gradient = 'linear-gradient(' . $gradient . ')';

    return $gradient;
}

// print gradient overlay option

function materialis_hero_print_gradient_overlay()
{

    $inner = materialis_is_inner(true);

    if ($inner) {
        $prefix = 'inner_header';
    } else {
        $prefix = 'header';
    }

    $type = materialis_get_theme_mod($prefix . '_overlay_type', materialis_mod_default($prefix . '_overlay_type'));
    if ($type != "gradient") {
        return;
    }

    $colors = materialis_get_theme_mod($prefix . '_overlay_gradient_colors', "");

    if ($colors == "") {
        $colors = materialis_mod_default($prefix . '_overlay_gradient_colors');
    }

    if (is_string($colors)) {
        $colors = json_decode($colors, true);
    }

    $gradient = materialis_get_gradient_value($colors['colors'], $colors['angle']);
    $selector = $inner ? ".header" : ".header-homepage";

    ?>
    <style data-name="header-gradient-overlay">
        <?php echo esc_attr($selector); ?>
        .background-overlay {
            background: <?php echo esc_attr($gradient); ?>;
        }
    </style>
    <?php
}

add_action('wp_head', 'materialis_hero_print_gradient_overlay');
