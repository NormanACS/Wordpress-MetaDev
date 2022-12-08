<?php


function materialis_front_page_header_title_options($section, $prefix, $priority)
{
    $companion = apply_filters('materialis_is_companion_installed', false);

    materialis_add_kirki_field(array(
        'type'     => 'checkbox',
        'settings' => 'header_content_show_title',
        'label'    => esc_html__('Show title', 'materialis'),
        'section'  => $section,
        'default'  => true,
        'priority' => $priority,
    ));

    materialis_add_kirki_field(array(
        'type'            => 'sidebar-button-group',
        'settings'        => 'header_content_title_group',
        'label'           => esc_html__('Options', 'materialis'),
        'section'         => $section,
        'priority'        => $priority,
        'choices'         => array(
            'header_title',
            'header_title_color',
            "header_content_title_background_options_separator",
            "header_content_title_background_enabled",
            "header_content_title_background_color",
            "header_content_title_background_spacing",
            "header_content_title_background_border_radius",
            "header_content_title_background_border_color",
            "header_content_title_background_border_thickness",
            "header_content_title_background_shadow",
        ),
        'active_callback' => array(
            array(
                'setting'  => 'header_content_show_title',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'in_row_with'     => array('header_content_show_title'),
    ));

    if ( ! $companion) {
        materialis_add_kirki_field(array(
            'type'              => 'textarea',
            'settings'          => 'header_title',
            'label'             => esc_html__('Title', 'materialis'),
            'section'           => $section,
            'default'           => '',
            'sanitize_callback' => 'materialis_wp_kses_post',
            'priority'          => $priority,
            'partial_refresh' => array(
                'header_title' => array(
                    'selector'        => ".header-homepage .hero-title",
                    'render_callback' => function () {
                        return get_theme_mod('header_title');
                    },
                ),
            ),
        ));
    }

    if (apply_filters('materialis_show_header_title_color', true)) {

        materialis_add_kirki_field(array(
            'type'      => 'select',
            'settings'  => 'header_title_color',
            'label'     => esc_html__('Title color', 'materialis'),
            'section'   => $section,
            'default'   => '#ffffff',
            'choices'   => apply_filters('materialis_woocommerce_shop_header_type_choices', array(
                "#ffffff" => esc_html__("White text", "materialis"),
                "#000000" => esc_html__("Dark Text", "materialis"),
            )),
            'priority'  => $priority,
            'transport' => 'postMessage',
            'output'    => array(
                array(
                    'element'  => '.header-homepage .hero-title',
                    'property' => 'color',
                    'function' => 'css',
                ),
            ),
            'js_vars'   => array(
                array(
                    'element'  => '.header-homepage .hero-title',
                    'property' => 'color',
                    'function' => 'css',
                ),
            ),
        ));
    }


    materialis_add_kirki_field(array(
        'type'     => 'sectionseparator',
        'label'    => esc_html__('Background Options', 'materialis'),
        'section'  => $section,
        'settings' => "header_content_title_background_options_separator",
        'priority' => $priority,
    ));

    materialis_add_kirki_field(array(
        'type'     => 'checkbox',
        'label'    => esc_html__('Enable Background', 'materialis'),
        'section'  => $section,
        'settings' => 'header_content_title_background_enabled',
        'priority' => $priority,
        'default'  => materialis_mod_default("header_element_background_enabled"),
    ));

    materialis_add_kirki_field(array(
        'type'            => 'color',
        'label'           => esc_html__('Background Color', 'materialis'),
        'section'         => $section,
        'settings'        => 'header_content_title_background_color',
        'default'         => materialis_mod_default("header_element_background_color"),
        'transport'       => 'postMessage',
        'priority'        => $priority,
        'choices'         => array(
            'alpha' => true,
        ),
        'active_callback' => array(
            array(
                'setting'  => 'header_content_title_background_enabled',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        "output"          => array(
            array(
                'element'  => '.header-homepage .hero-title',
                'property' => 'background',
            ),
        ),
        'js_vars'         => array(
            array(
                'element'  => ".header-homepage .hero-title",
                'function' => 'css',
                'property' => 'background',
            ),
        ),
    ));

    materialis_add_kirki_field(array(
        'type'            => 'spacing',
        'settings'        => 'header_content_title_background_spacing',
        'label'           => esc_html__('Background Spacing', 'materialis'),
        'section'         => $section,
        'priority'        => $priority,
        'default'         => materialis_mod_default("header_element_background_spacing"),
        'transport'       => 'postMessage',
        'active_callback' => array(
            array(
                'setting'  => 'header_content_title_background_enabled',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'output'          => array(
            array(
                'element'  => '.header-homepage .hero-title',
                'property' => 'padding',
            ),
        ),
        'js_vars'         => array(
            array(
                'element'  => ".header-homepage .hero-title",
                'function' => 'style',
                'property' => 'padding',
            ),
        ),
    ));

    materialis_add_kirki_field(array(
        'type'            => 'dimension',
        'settings'        => 'header_content_title_background_border_radius',
        'label'           => esc_html__('Border Radius', 'materialis'),
        'section'         => $section,
        'priority'        => $priority,
        'default'         => materialis_mod_default("header_element_background_radius"),
        'transport'       => 'postMessage',
        'active_callback' => array(
            array(
                'setting'  => 'header_content_title_background_enabled',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'output'          => array(
            array(
                'element'  => '.header-homepage .hero-title',
                'property' => 'border-radius',
            ),
        ),
        'js_vars'         => array(
            array(
                'element'  => ".header-homepage .hero-title",
                'function' => 'style',
                'property' => 'border-radius',
            ),
        ),
    ));

    materialis_add_kirki_field(array(
        'type'            => 'color',
        'settings'        => 'header_content_title_background_border_color',
        'label'           => esc_html__('Border Color', 'materialis'),
        'section'         => $section,
        'default'         => materialis_mod_default('header_element_background_border_color'),
        'transport'       => 'postMessage',
        'priority'        => $priority,
        'choices'         => array(
            'alpha' => true,
        ),
        'active_callback' => array(
            array(
                'setting'  => 'header_content_title_background_enabled',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'output'          => array(
            array(
                'element'  => ".header-homepage .hero-title",
                'property' => 'border-color',
            ),
        ),
        'js_vars'         => array(
            array(
                'element'  => ".header-homepage .hero-title",
                'function' => 'css',
                'property' => 'border-color',
            ),
        ),
    ));

    materialis_add_kirki_field(array(
        'type'            => 'spacing',
        'settings'        => 'header_content_title_background_border_thickness',
        'label'           => esc_html__('Background Border Thickness', 'materialis'),
        'section'         => $section,
        'priority'        => $priority,
        'default'         => materialis_mod_default('header_element_background_border_thickness'),
        'transport'       => 'postMessage',
        'active_callback' => array(
            array(
                'setting'  => 'header_content_title_background_enabled',
                'operator' => '==',
                'value'    => true,
            ),
        ),
    ));

    materialis_add_kirki_field(array(
        'type'            => 'slider',
        'settings'        => 'header_content_title_background_shadow',
        'label'           => esc_html__('Shadow Elevation', 'materialis'),
        'section'         => $section,
        'priority'        => $priority,
        'default'         => materialis_mod_default("header_element_background_shadow"),
        'choices'         => array(
            'min'  => '0',
            'max'  => '12',
            'step' => '1',
        ),
        'transport'       => 'postMessage',
        'active_callback' => array(
            array(
                'setting'  => 'header_content_title_background_enabled',
                'operator' => '==',
                'value'    => true,
            ),
        ),
    ));
}


function materialis_print_header_content_title_hook()
{
    materialis_print_header_title();
}

add_action("materialis_print_header_content", 'materialis_print_header_content_title_hook', 1);

function materialis_print_header_title()
{
    $title        = materialis_get_theme_mod('header_title', "");
    $show         = materialis_get_theme_mod('header_content_show_title', true);
    $shadow_class = '';

    if (materialis_can_show_demo_content()) {
        if ($title == "") {
            $title = strtoupper(esc_html__('Set the title in customizer', 'materialis'));
        }
    } else {
	    if ($title == "") {
		    $title = get_bloginfo('site_title');
	    }
    }

    $title = materialis_wp_kses_post($title);
    $title = apply_filters("materialis_header_title", $title);

    if ($show) {
        $background_enabled = materialis_get_theme_mod('header_content_title_background_enabled', false);
        $shadow_value       = materialis_get_theme_mod('header_content_title_background_shadow', 0);
        if ($background_enabled && $shadow_value) {
            $shadow_class = 'mdc-elevation--z' . $shadow_value;
        }

        if ($title) {
            printf('<h1 class="hero-title ' . esc_attr($shadow_class) . '">%1$s</h1>', $title);
        }
    }
}
