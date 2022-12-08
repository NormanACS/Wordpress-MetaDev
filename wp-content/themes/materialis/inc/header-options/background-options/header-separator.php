<?php

function materialis_header_background_settings_separator_options($section, $prefix, $group, $inner, $priority)
{
    materialis_header_separator_options($section, $prefix, $group, $inner, $priority);
}

add_action("materialis_header_background_settings", 'materialis_header_background_settings_separator_options', 3, 5);


function materialis_header_separator_options($section, $prefix, $group, $inner, $priority)
{

    $priority = 4;
    $group    = "{$prefix}_options_separator_group_button";

    materialis_add_kirki_field(array(
        'type'     => 'checkbox',
        'label'    => esc_html__('Use Bottom Separator', 'materialis'),
        'section'  => $section,
        'settings' => $prefix . '_show_separator',
        'default'  => $inner ? false : false,
        'priority' => $priority,
    ));

    materialis_add_kirki_field(array(
        'type'            => 'sidebar-button-group',
        'settings'        => $group,
        'label'           => esc_html__('Options', 'materialis'),
        'section'         => $section,
        'priority'        => $priority,
        'in_row_with'     => array($prefix . '_show_separator'),
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_show_separator',
                'operator' => '==',
                'value'    => true,
            ),
        ),
    ));


    materialis_add_kirki_field(array(
        'type'     => 'sectionseparator',
        'label'    => esc_html__('Bottom Separator Options', 'materialis'),
        'section'  => $section,
        'settings' => $prefix . '_separator_header_separator_2',
        'priority' => $priority,
        'group'    => $group,
    ));

    materialis_add_kirki_field(array(
        'type'            => 'select',
        'settings'        => $prefix . '_separator',
        'label'           => esc_html__('Type', 'materialis'),
        'section'         => $section,
        'default'         => 'materialis/1.wave-and-line',
        'choices'         => materialis_get_separators_list(),
        'priority'        => $priority,
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_show_separator',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'group'           => $group,
    ));


    materialis_add_kirki_field(array(
        'type'     => 'color',
        'settings' => "{$prefix}_separator_color",
        'label'    => esc_attr__('Color', 'materialis'),
        'section'  => $section,
        'priority' => $priority,
        'choices'  => array(
            'alpha' => true,
        ),
        'default'  => $inner ? "#F5FAFD" : "#ffffff",
        'output'   => array(
            array(
                'element'  => $inner ? "body .header .svg-white-bg" : ".materialis-front-page .header-separator .svg-white-bg",
                'property' => 'fill',
                'suffix'   => '!important',
            ),


        ),

        'transport' => 'postMessage',
        'js_vars'   => array(
            array(
                'element'  => $inner ? "body .header .svg-white-bg" : ".materialis-front-page .header-separator .svg-white-bg",
                'property' => 'fill',
                'suffix'   => '!important',
            ),
        ),

        'active_callback' => array(
            array(
                'setting'  => $prefix . '_show_separator',
                'operator' => '==',
                'value'    => true,
            ),
        ),

        'group' => $group,
    ));


    materialis_add_kirki_field(array(
        'type'     => 'color',
        'settings' => "{$prefix}_separator_color_accent",
        'label'    => esc_attr__('Accent Color', 'materialis'),
        'section'  => $section,
        'priority' => $priority,
        'choices'  => array(
            'alpha' => true,
        ),
        'default'  => materialis_get_theme_colors('color2'),
        'output'   => array(
            array(
                'element'  => $inner ? ".materialis-inner-page .header .svg-accent" : ".materialis-front-page .header-separator path.svg-accent",
                'property' => 'stroke',
                'suffix'   => '!important',
            ),


        ),

        'transport' => 'postMessage',
        'js_vars'   => array(
            array(
                'element'  => $inner ? "body.page .header path.svg-accent" : ".materialis-front-page .header-separator path.svg-accent",
                'property' => 'stroke',
                'suffix'   => '!important',
            ),
        ),

        'active_callback' => array(
            array(
                'setting'  => $prefix . '_show_separator',
                'operator' => '==',
                'value'    => true,
            ),

            array(
                'setting'  => $prefix . '_separator',
                'operator' => 'in',
                'value'    => materialis_get_2_colors_separators(array(), true),
            ),
        ),
        'group'           => $group,
    ));

    materialis_add_kirki_field(array(
        'type'            => 'slider',
        'label'           => esc_html__('Height', 'materialis'),
        'section'         => $section,
        'settings'        => $prefix . '_separator_height',
        'default'         => 154,
        'transport'       => 'postMessage',
        'priority'        => $priority,
        'choices'         => array(
            'min'  => '0',
            'max'  => '400',
            'step' => '1',
        ),
        "output"          => array(
            array(
                "element"  => $inner ? ".header-separator svg" : ".materialis-front-page .header-separator svg",
                'property' => 'height',
                'suffix'   => '!important',
                'units'    => 'px',
            ),
        ),
        'js_vars'         => array(
            array(
                'element'  => $inner ? ".header-separator svg" : ".materialis-front-page .header-separator svg",
                'function' => 'css',
                'property' => 'height',
                'units'    => "px",
                'suffix'   => '!important',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_show_separator',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'group'           => $group,
    ));
}


function materialis_get_2_colors_separators($separators = array(), $onlyIDs = false)
{
    $separators = array_merge(
        $separators,
        array(
            'materialis/1.wave-and-line'          => esc_html__('Wave and line', 'materialis'),
            'materialis/1.wave-and-line-negative' => esc_html__('Wave and line Negative', 'materialis'),
        )
    );

    if ($onlyIDs) {
        return array_keys($separators);

    }

    return $separators;
}

function materialis_prepend_2_colors_separators($separators, $use_only_defaults)
{
    if ($use_only_defaults) {
        return $separators;
    }

    return materialis_get_2_colors_separators($separators);

}

add_filter('materialis_separators_list_prepend', 'materialis_prepend_2_colors_separators', 10, 2);


function materialis_get_separators_list($use_only_defaults = false)
{
    $extras = array(
        'materialis/3.waves-noCentric'           => esc_html__('Wave no centric', 'materialis'),
        'materialis/3.waves-noCentric-negative'  => esc_html__('Wave no centric Negative', 'materialis'),
        'materialis/4.clouds'                    => esc_html__('Clouds 2', 'materialis'),
        'materialis/5.triple-waves-3'            => esc_html__('Triple Waves 1', 'materialis'),
        'materialis/5.triple-waves-3-negative'   => esc_html__('Triple Waves 1 Negative', 'materialis'),
        'materialis/6.triple-waves-2'            => esc_html__('Triple Waves 2', 'materialis'),
        'materialis/6.triple-waves-2-negative'   => esc_html__('Triple Waves 2 Negative', 'materialis'),
        'materialis/7.stright-angles-1'          => esc_html__('Stright Angles 1', 'materialis'),
        'materialis/7.stright-angles-1-negative' => esc_html__('Stright Angles 1 Negative', 'materialis'),
        'materialis/8.stright-angles-2'          => esc_html__('Triple Waves 2', 'materialis'),
        'materialis/8.stright-angles-2-negative' => esc_html__('Triple Waves 2 Negative', 'materialis'),
    );


    $separators = array(
        'tilt'                           => esc_html__('Tilt', 'materialis'),
        'tilt-flipped'                   => esc_html__('Tilt Flipped', 'materialis'),
        'opacity-tilt'                   => esc_html__('Tilt Opacity', 'materialis'),
        'triangle'                       => esc_html__('Triangle', 'materialis'),
        'triangle-negative'              => esc_html__('Triangle Negative', 'materialis'),
        'triangle-asymmetrical'          => esc_html__('Triangle Asymmetrical', 'materialis'),
        'triangle-asymmetrical-negative' => esc_html__('Triangle Asymmetrical Negative', 'materialis'),
        'opacity-fan'                    => esc_html__('Fan Opacity', 'materialis'),
        'mountains'                      => esc_html__('Mountains', 'materialis'),
        'pyramids'                       => esc_html__('Pyramids', 'materialis'),
        'pyramids-negative'              => esc_html__('Pyramids Negative', 'materialis'),
        'waves'                          => esc_html__('Waves', 'materialis'),
        'waves-negative'                 => esc_html__('Waves Negative', 'materialis'),
        'wave-brush'                     => esc_html__('Waves Brush', 'materialis'),
        'waves-pattern'                  => esc_html__('Waves Pattern', 'materialis'),
        'clouds'                         => esc_html__('Clouds', 'materialis'),
        'clouds-negative'                => esc_html__('Clouds Negative', 'materialis'),
        'curve'                          => esc_html__('Curve', 'materialis'),
        'curve-negative'                 => esc_html__('Curve Negative', 'materialis'),
        'curve-asymmetrical'             => esc_html__('Curve Asymmetrical', 'materialis'),
        'curve-asymmetrical-negative'    => esc_html__('Curve Asymmetrical Negative', 'materialis'),
        'drops'                          => esc_html__('Drops', 'materialis'),
        'drops-negative'                 => esc_html__('Drops Negative', 'materialis'),
        'arrow'                          => esc_html__('Arrow', 'materialis'),
        'arrow-negative'                 => esc_html__('Arrow Negative', 'materialis'),
        'book'                           => esc_html__('Book', 'materialis'),
        'book-negative'                  => esc_html__('Book Negative', 'materialis'),
        'split'                          => esc_html__('Split', 'materialis'),
        'split-negative'                 => esc_html__('Split Negative', 'materialis'),
        'zigzag'                         => esc_html__('Zigzag', 'materialis'),
    );

    if ( ! $use_only_defaults) {
        $separators = array_merge($extras, $separators);
    }

    $prepend_separators = apply_filters('materialis_separators_list_prepend', array(), $use_only_defaults);
    $append_separators  = apply_filters('materialis_separators_list_append', array(), $use_only_defaults);

    $separators = array_merge($prepend_separators, $separators, $append_separators);

    return $separators;
}


function materialis_print_header_separator($prefix = null)
{
    $inner = materialis_is_inner(true);

    if ( ! $prefix) {
        $prefix = $inner ? "inner_header" : "header";
    }

    $show = materialis_get_theme_mod($prefix . '_show_separator', $inner ? false : false);
    if ($show) {

        $separator = materialis_get_theme_mod($prefix . '_separator', 'materialis/1.wave-and-line');

        $reverse = "";

        if (strpos($separator, "materialis/") !== false) {
            $reverse = strpos($separator, "-negative") === false ? "" : "header-separator-reverse";
        } else {
            $reverse = strpos($separator, "-negative") === false ? "header-separator-reverse" : "";
        }

        echo '<div class="header-separator header-separator-bottom ' . esc_attr($reverse) . '">';
        ob_start();

        // local svg as template ( ensure it will work with filters in child theme )
        locate_template("/assets/separators/" . $separator . ".svg", true, true);

        $content = ob_get_clean();
        echo $content;
        echo '</div>';

    }
}
