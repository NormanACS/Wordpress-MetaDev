<?php


function materialis_get_footer_contact_boxes($index = 0)
{

    $contact_boxes = array(
        array(
            'icon_mod'     => 'footer_box1_content_icon',
            'icon_default' => 'mdi-pin',
            'text_mod'     => 'footer_box1_content_text',
            'text_default' => esc_html__('San Francisco - Adress - 18 California Street 1100.', 'materialis'),
        ),
        array(
            'icon_mod'     => 'footer_box2_content_icon',
            'icon_default' => 'mdi-email',
            'text_mod'     => 'footer_box2_content_text',
            'text_default' => esc_html__('hello@mycoolsite.com', 'materialis'),
        ),
        array(
            'icon_mod'     => 'footer_box3_content_icon',
            'icon_default' => 'mdi-cellphone-android',
            'text_mod'     => 'footer_box3_content_text',
            'text_default' => esc_html__('+1 (555) 345 234343', 'materialis'),
        ),
    );

    return $contact_boxes[$index];

}

function materialis_footer_filter()
{
    $footer_template = materialis_get_theme_mod('footer_template', 'simple');

    $theme      = wp_get_theme();
    $textDomain = materialis_get_text_domain();

    if ($footer_template == 'simple') {
        $footer_template = '';
    }

    return $footer_template;
}

add_filter('materialis_footer', 'materialis_footer_filter');

function materialis_footer_settings()
{

    $section = 'footer_settings';

    materialis_add_kirki_field(array(
        'type'     => 'sectionseparator',
        'label'    => esc_html__('Footer Content', 'materialis'),
        'section'  => $section,
        'settings' => 'footer_content_separator',
        'priority' => 1,
    ));

    materialis_add_kirki_field(array(
        'type'      => 'checkbox',
        'settings'  => 'footer_paralax',
        'label'     => esc_html__('Use footer parallax', 'materialis'),
        'section'   => $section,
        'default'   => false,
        'priority'  => 4,
        'transport' => 'postMessage',
        'active_callback' => array(
            array(
                'setting'  => 'layout_boxed_content_enabled',
                'operator' => '==',
                'value'    => false,
            ),
        ),
    ));


    materialis_add_kirki_field(array(
        'type'      => 'ope-info-pro',
        'label'     => esc_html__('More colors and typography options available in PRO. @BTN@', 'materialis'),
        'section'   => $section,
        'priority'  => 4,
        'settings'  => 'footer_content_typography_pro_info',
        'default'   => true,
        'transport' => 'postMessage',
    ));

    materialis_add_kirki_field(array(
        'type'     => 'select',
        'settings' => 'footer_template',
        'label'    => esc_html__('Footer Template', 'materialis'),
        'section'  => $section,
        'priority' => 1,
        'default'  => 'simple',
        'choices'  => apply_filters('materialis_footer_templates', array(
            'simple'        => esc_html__('Copyright text only', 'materialis'),
            'contact-boxes' => esc_html__('Contact Boxes', 'materialis'),
            'dark'          => esc_html__('Dark Footer With Menu', 'materialis'),
        )),
        'update'   => apply_filters('materialis_footer_templates_update', array()),
    ));

    // Contact Boxes options button and section

    $group = 'footer_content_contact_boxes_group_button';

    materialis_add_kirki_field(array(
        'type'            => 'sectionseparator',
        'label'           => esc_html__('Box 1 Content', 'materialis'),
        'section'         => $section,
        'settings'        => 'footer_box1_content_separator',
        'priority'        => 1,
        'group'           => $group,
        'active_callback' => array(
            array(
                'setting'  => 'footer_template',
                'operator' => '==',
                'value'    => 'contact-boxes',
            ),
        ),
    ));

    materialis_add_kirki_field(array(
        'type'            => 'material-icons-icon-control',
        'settings'        => 'footer_box1_content_icon',
        'label'           => esc_html__('Icon', 'materialis'),
        'section'         => $section,
        'priority'        => 1,
        'group'           => $group,
        'default'         => 'mdi-map-marker',
        'active_callback' => array(
            array(
                'setting'  => 'footer_template',
                'operator' => '==',
                'value'    => 'contact-boxes',
            ),
        ),
    ));

    materialis_add_kirki_field(array(
        'type'              => 'textarea',
        'settings'          => 'footer_box1_content_text',
        'label'             => esc_html__('Text', 'materialis'),
        'section'           => $section,
        'priority'          => 1,
        'group'             => $group,
        'default'           => 'San Francisco - Adress - 18 California Street 1100.',
        'sanitize_callback' => 'wp_kses_post',
        'active_callback'   => array(
            array(
                'setting'  => 'footer_template',
                'operator' => '==',
                'value'    => 'contact-boxes',
            ),
        ),
        'transport'         => 'postMessage',
        'js_vars'           => array(
            array(
                'element'  => '[data-focus-control="footer_box1_content_icon"] > p',
                'function' => 'html',
            ),
        ),
    ));

    materialis_add_kirki_field(array(
        'type'            => 'sectionseparator',
        'label'           => esc_html__('Box 2 Content', 'materialis'),
        'section'         => $section,
        'settings'        => 'footer_box2_content_separator',
        'priority'        => 1,
        'group'           => $group,
        'active_callback' => array(
            array(
                'setting'  => 'footer_template',
                'operator' => '==',
                'value'    => 'contact-boxes',
            ),
        ),
    ));

    materialis_add_kirki_field(array(
        'type'            => 'material-icons-icon-control',
        'settings'        => 'footer_box2_content_icon',
        'label'           => esc_html__('Icon', 'materialis'),
        'section'         => $section,
        'priority'        => 1,
        'group'           => $group,
        'default'         => 'mdi-email',
        'active_callback' => array(
            array(
                'setting'  => 'footer_template',
                'operator' => '==',
                'value'    => 'contact-boxes',
            ),
        ),
    ));

    materialis_add_kirki_field(array(
        'type'              => 'textarea',
        'settings'          => 'footer_box2_content_text',
        'label'             => esc_html__('Text', 'materialis'),
        'section'           => $section,
        'priority'          => 1,
        'group'             => $group,
        'default'           => 'hello@mycoolsite.com',
        'sanitize_callback' => 'wp_kses_post',
        'active_callback'   => array(
            array(
                'setting'  => 'footer_template',
                'operator' => '==',
                'value'    => 'contact-boxes',
            ),
        ),
        'transport'         => 'postMessage',
        'js_vars'           => array(
            array(
                'element'  => '[data-focus-control="footer_box2_content_icon"] > p',
                'function' => 'html',

            ),
        ),
    ));

    materialis_add_kirki_field(array(
        'type'            => 'sectionseparator',
        'label'           => esc_html__('Box 3 Content', 'materialis'),
        'section'         => $section,
        'settings'        => 'footer_box3_content_separator',
        'priority'        => 1,
        'group'           => $group,
        'active_callback' => array(
            array(
                'setting'  => 'footer_template',
                'operator' => '==',
                'value'    => 'contact-boxes',
            ),
        ),
    ));

    materialis_add_kirki_field(array(
        'type'            => 'material-icons-icon-control',
        'settings'        => 'footer_box3_content_icon',
        'label'           => esc_html__('Icon', 'materialis'),
        'section'         => $section,
        'priority'        => 1,
        'group'           => $group,
        'default'         => 'mdi-cellphone-android',
        'active_callback' => array(
            array(
                'setting'  => 'footer_template',
                'operator' => '==',
                'value'    => 'contact-boxes',
            ),
        ),
    ));

    materialis_add_kirki_field(array(
        'type'              => 'textarea',
        'settings'          => 'footer_box3_content_text',
        'label'             => esc_html__('Text', 'materialis'),
        'section'           => $section,
        'priority'          => 1,
        'group'             => $group,
        'default'           => '+1 (555) 345 234343',
        'sanitize_callback' => 'wp_kses_post',
        'active_callback'   => array(
            array(
                'setting'  => 'footer_template',
                'operator' => '==',
                'value'    => 'contact-boxes',
            ),
        ),
        'transport'         => 'postMessage',
        'js_vars'           => array(
            array(
                'element'  => '[data-focus-control="footer_box3_content_icon"] > p',
                'function' => 'html',

            ),
        ),
    ));

    materialis_add_kirki_field(array(
        'type'            => 'sidebar-button-group',
        'settings'        => 'footer_content_contact_boxes_group_button',
        'label'           => esc_html__('Contact Boxes Options', 'materialis'),
        'section'         => $section,
        'priority'        => 1,
        'active_callback' => array(
            array(
                'setting'  => 'footer_template',
                'operator' => '==',
                'value'    => 'contact-boxes',
            ),
        ),
    ));

    // Social icons options button and section

    $footers_with_social_icons = apply_filters('materialis_footer_templates_with_social', array('contact-boxes', 'content-lists'));

    $group = 'footer_content_social_icons_group_button';

    $materialis_footer_socials_icons = materialis_default_icons();

    $count = 0;
    foreach ($materialis_footer_socials_icons as $social) {
        $socialid   = 'social_icon_' . $count;
        $social_url = $social['link'];
        $count++;

        $social_separator_label = sprintf(__('Social Icon %s Options', 'materialis'), $count);

        $social_enable_label = sprintf(__('Show Icon %s', 'materialis'), $count);
        $social_url_label    = sprintf(__('Icon %s url', 'materialis'), $count);
        $social_url_icon     = sprintf(__('Icon %s icon', 'materialis'), $count);

        materialis_add_kirki_field(array(
            'type'            => 'sectionseparator',
            'label'           => esc_html($social_separator_label),
            'section'         => $section,
            'settings'        => 'footer_content_' . $socialid . '_separator',
            'priority'        => 1,
            'group'           => $group,
            'active_callback' => array(
                array(
                    'setting'  => 'footer_template',
                    'operator' => 'in',
                    'value'    => $footers_with_social_icons,
                ),
            ),
        ));

        materialis_add_kirki_field(array(
            'type'            => 'checkbox',
            'settings'        => 'footer_content_' . $socialid . '_enabled',
            'label'           => esc_html($social_enable_label),
            'section'         => $section,
            'priority'        => 1,
            'group'           => $group,
            'default'         => true,
            'transport'       => 'postMessage',
            'active_callback' => array(
                array(
                    'setting'  => 'footer_template',
                    'operator' => 'in',
                    'value'    => $footers_with_social_icons,
                ),
            ),
        ));

        materialis_add_kirki_field(array(
            'type'            => 'url',
            'settings'        => 'footer_content_' . $socialid . '_link',
            'label'           => esc_html($social_url_label),
            'section'         => $section,
            'priority'        => 1,
            'group'           => $group,
            'default'         => '#',
            'transport'       => 'postMessage',
            'active_callback' => array(
                array(
                    'setting'  => 'footer_content_' . $socialid . '_enabled',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'footer_template',
                    'operator' => 'in',
                    'value'    => $footers_with_social_icons,
                ),
            ),
        ));

        materialis_add_kirki_field(array(
            'type'            => 'material-icons-icon-control',
            'settings'        => 'footer_content_' . $socialid . '_icon',
            'label'           => esc_html($social_url_icon),
            'section'         => $section,
            'priority'        => 1,
            'group'           => $group,
            'default'         => $social['icon'],
            'transport'       => 'postMessage',
            'active_callback' => array(
                array(
                    'setting'  => 'footer_content_' . $socialid . '_enabled',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'footer_template',
                    'operator' => 'in',
                    'value'    => $footers_with_social_icons,
                ),
            ),
        ));

    }

    materialis_add_kirki_field(array(
        'type'            => 'sidebar-button-group',
        'settings'        => 'footer_content_social_icons_group_button',
        'label'           => esc_html__('Social Icons Options', 'materialis'),
        'section'         => $section,
        'priority'        => 1,
        'active_callback' => array(
            array(
                'setting'  => 'footer_template',
                'operator' => 'in',
                'value'    => $footers_with_social_icons,
            ),
        ),
    ));


}

function materialis_print_widget($id)
{
    if ( ! is_active_sidebar($id) && is_customize_preview()) {
        $focusAttr = materialis_customizer_focus_control_attr("sidebars_widgets[{$id}]", false);
        echo "<div {$focusAttr}>" . esc_html__("Go to widgets section to add a widget here.", 'materialis') . "</div>";
    } else {
        dynamic_sidebar($id);
    }
}

function materialis_footer_container_atts($attrs)
{
    $paralax = materialis_get_theme_mod('footer_paralax', false);
    if ($paralax) {
        $attrs['class'] .= " paralax ";
    }

    return $attrs;
}

add_filter('materialis_footer_container_atts', 'materialis_footer_container_atts');

/* start contact boxes */

function materialis_footer_contact_boxes_content_print()
{
    materialis_print_contact_boxes();
}

add_filter('materialis_footer_contact_boxes_content_print', 'materialis_footer_contact_boxes_content_print');

function materialis_print_contact_boxes($index = 0)
{

    $fields = materialis_get_footer_contact_boxes($index);

    $preview_atts = "";

    if (materialis_is_customize_preview()) {
        $setting      = esc_attr($fields['icon_mod']);
        $preview_atts = "data-focus-control='{$setting}'";
    }


    $icon = materialis_get_theme_mod($fields['icon_mod'], $fields['icon_default']);
    ?>
    <div data-type="group" <?php echo $preview_atts; ?> data-dynamic-mod="true">
        <i class="big-icon mdi <?php echo esc_attr($icon) ?>"></i>
        <p>
            <?php echo wp_kses_post(materialis_get_theme_mod($fields['text_mod'], $fields['text_default'])); ?>
        </p>
    </div>
    <?php
}

/* end contact boxes */

function materialis_customize_register_options_footer_settings()
{
    materialis_footer_settings();
}

add_action('materialis_customize_register_options', 'materialis_customize_register_options_footer_settings');
