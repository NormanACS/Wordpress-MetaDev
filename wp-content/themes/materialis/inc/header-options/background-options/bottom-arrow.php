<?php


add_action("materialis_header_background_overlay_settings", "materialis_front_page_header_bottom_arrow_settings", 1, 5);

function materialis_front_page_header_bottom_arrow_settings($section, $prefix, $group, $inner, $priority)
{

    if ($inner) return;

    $priority = 5;

    $prefix   = $inner ? "inner_header_" : "header_";
    $section  = "header_background_chooser";

    $group = "{$prefix}bottom_arrow_options_group_button";

    materialis_add_kirki_field(array(
        'priority' => $priority,
        'type'     => 'checkbox',
        'settings' => 'header_show_bottom_arrow',
        'label'    => esc_html__('Use Bottom Arrow', 'materialis'),
        'section'  => $section,
        'default'  => false
    ));

     materialis_add_kirki_field(array(
        'type'            => 'sidebar-button-group',
        'settings'        => $group,
        'label'           => esc_html__('Options', 'materialis'),
        'section'         => $section,
        'priority'        => $priority,
        'active_callback' => array(
            array(
                'setting'  => 'header_show_bottom_arrow',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'in_row_with' => array('header_show_bottom_arrow')
    ));

    materialis_add_kirki_field(array(
        'type'            => 'checkbox',
        'settings'        => 'header_bounce_bottom_arrow',
        'label'           => esc_html__('Bounce arrow', 'materialis'),
        'section'         => $section,
        'default'         => true,
        'priority'        => $priority,
        'active_callback' => array(
            array(
                'setting'  => 'header_show_bottom_arrow',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'group' => $group
    ));

    materialis_add_kirki_field(array(
        'priority' => $priority,

        'type'            => 'material-icons-icon-control',
        'settings'        => 'header_bottom_arrow',
        'label'           => esc_html__('Icon', 'materialis'),
        'section'         => $section,
        'default'         => "mdi-arrow-down-bold-circle",
        'active_callback' => array(
            array(
                'setting'  => 'header_show_bottom_arrow',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'group' => $group
    ));

    materialis_add_kirki_field(array(
        'priority' => $priority,

        'type'            => 'slider',
        'settings'        => 'header_size_bottom_arrow',
        'label'           => esc_html__('Icon Size', 'materialis'),
        'section'         => $section,
        'default'         => "50",
        'choices'         => array(
            'min'  => '10',
            'max'  => '100',
            'step' => '1',
        ),
        "output"          => array(
            array(
                'element'  => '.header-homepage-arrow',
                'property' => 'font-size',
                'suffix'   => 'px !important',
            ),
            array(
                'element'  => '.header-homepage-arrow > i',
                'property' => 'width',
                'suffix'   => 'px',
            ),
            array(
                'element'  => '.header-homepage-arrow > i',
                'property' => 'height',
                'suffix'   => 'px',
            ),
        ),
        'transport'       => 'postMessage',
        'js_vars'         => array(
            array(
                'element'  => '.header-homepage-arrow',
                'function' => 'css',
                'property' => 'font-size',
                'suffix'   => 'px !important',
            ),
            array(
                'element'  => '.header-homepage-arrow > i',
                'function' => 'css',
                'property' => 'width',
                'suffix'   => 'px',
            ),
            array(
                'element'  => '.header-homepage-arrow > i',
                'function' => 'css',
                'property' => 'height',
                'suffix'   => 'px',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => 'header_show_bottom_arrow',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => 'header_show_bottom_arrow',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'group' => $group
    ));


    materialis_add_kirki_field(array(
        'priority' => $priority,

        'type'            => 'slider',
        'settings'        => 'header_offset_bottom_arrow',
        'label'           => esc_html__('Icon Bottom Offset', 'materialis'),
        'section'         => $section,
        'default'         => "20",
        'choices'         => array(
            'min'  => '0',
            'max'  => '200',
            'step' => '1',
        ),
        "output"          => array(
            array(
                'element'  => '.header-homepage-arrow',
                'property' => 'bottom',
                'suffix'   => 'px !important',
            ),
        ),
        'transport'       => 'postMessage',
        'js_vars'         => array(
            array(
                'element'  => '.header-homepage-arrow',
                'function' => 'css',
                'property' => 'bottom',
                'suffix'   => 'px !important',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => 'header_show_bottom_arrow',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => 'header_show_bottom_arrow',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'group' => $group
    ));

    materialis_add_kirki_field(array(
        'priority' => $priority,

        'type'            => 'color',
        'settings'        => 'header_color_bottom_arrow',
        'label'           => esc_html__('Icon Color', 'materialis'),
        'section'         => $section,
        'default'         => "#ffffff",
        'choices'         => array(
            'alpha' => true,
        ),
        "output"          => array(
            array(
                'element'  => '.header-homepage-arrow > i',
                'property' => 'color',
            ),
        ),
        'transport'       => 'postMessage',
        'js_vars'         => array(
            array(
                'element'  => '.header-homepage-arrow > i',
                'function' => 'css',
                'property' => 'color',
                'suffix'   => ' !important',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => 'header_show_bottom_arrow',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'group' => $group
    ));

    materialis_add_kirki_field(array(
        'priority'        => $priority,
        'type'            => 'color',
        'settings'        => 'header_background_bottom_arrow',
        'label'           => esc_html__('Icon Background Color', 'materialis'),
        'section'         => $section,
        'default'         => "rgba(255,255,255,0)",
        'choices'         => array(
            'alpha' => true,
        ),
        "output"          => array(
            array(
                'element'  => '.header-homepage-arrow',
                'property' => 'background',
            ),
        ),
        'transport'       => 'postMessage',
        'js_vars'         => array(
            array(
                'element'  => '.header-homepage-arrow',
                'function' => 'css',
                'property' => 'background',
                'suffix'   => ' !important',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => 'header_show_bottom_arrow',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'group' => $group
    ));

}


function materialis_header_bottom_arrow()
{
    $show   = materialis_get_theme_mod('header_show_bottom_arrow', false);
    $bounce = materialis_get_theme_mod('header_bounce_bottom_arrow', true);

    $class = "header-homepage-arrow ";

    if ($bounce) {
        $class .= "move-down-bounce";
    }

    if ($show) {
        $icon = materialis_get_theme_mod('header_bottom_arrow', "mdi-arrow-down-bold-circle");
        ?>
        <div class="header-homepage-arrow-c">
            <span class="<?php echo esc_attr($class); ?>"> <i class="mdi arrow <?php echo esc_attr($icon); ?>" aria-hidden="true"></i>
            </span>
        </div>
        <?php
    }
}

add_action('materialis_after_header_content', 'materialis_header_bottom_arrow');
