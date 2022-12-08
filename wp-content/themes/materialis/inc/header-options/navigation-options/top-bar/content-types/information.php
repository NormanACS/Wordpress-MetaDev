<?php


function materialis_get_content_types_register_info_fields($types)
{
    $types['info'] = esc_html__("Information Fields", 'materialis');

    return $types;
}

add_filter("materialis_get_content_types", 'materialis_get_content_types_register_info_fields');

function materialis_get_content_types_options_register_info_field($options)
{
    $options['info'] = "materialis_top_bar_information_fields_options";

    return $options;
}

add_filter("materialis_get_content_types_options", 'materialis_get_content_types_options_register_info_field');

function materialis_top_bar_fields_defaults()
{
    return array(
        array(
            "icon" => "mdi-pin",
            "text" => __("Location,TX 75035,USA", 'materialis'),
        ),
        array(
            "icon" => "mdi-cellphone-android",
            "text" => __("+1234567890", 'materialis'),
        ),
        array(
            "icon" => "mdi-email",
            "text" => __("info@yourmail.com", 'materialis'),
        ),
    );
}

function materialis_top_bar_information_fields_options($area, $section, $priority, $prefix)
{

    materialis_add_kirki_field(array(
        'type'     => 'sectionseparator',
        'label'    => esc_html__('Information fields icons', 'materialis'),
        'section'  => $section,
        'priority' => $priority,
        'settings' => "{$prefix}_info_fields_icons_separator",
    ));


    $materialis_top_bar_fields_defaults = materialis_top_bar_fields_defaults();

    $group_choices = array(
        "{$prefix}_info_fields_colors_separator",
        "{$prefix}_information_fields_text_color",
        "{$prefix}_information_fields_icon_color",
        "{$prefix}_info_fields_icons_separator",
    );

    for ($i = 0; $i < 3; $i++) {
        materialis_add_kirki_field(array(
            'type'     => 'checkbox',
            'label'    => sprintf(esc_html__('Show Field %d', 'materialis'), ($i + 1)),
            'section'  => $section,
            'priority' => $priority,
            'settings' => "{$prefix}_info_field_{$i}_enabled",
            'default'  => true,
        ));

        $group_choices[] = "{$prefix}_info_field_{$i}_enabled";

        materialis_add_kirki_field(array(
            'type'     => 'material-icons-icon-control',
            'settings' => "{$prefix}_info_field_{$i}_icon",
            'label'    => sprintf(esc_html__('Field %d icon', 'materialis'), ($i + 1)),
            'section'  => $section,
            'priority' => $priority,
            'default'  => $materialis_top_bar_fields_defaults[$i]['icon'],

        ));

        $group_choices[] = "{$prefix}_info_field_{$i}_icon";

        materialis_add_kirki_field(array(
            'type'              => 'textarea',
            'settings'          => "{$prefix}_info_field_{$i}_text",
            'label'             => sprintf(esc_html__('Field %d text', 'materialis'), ($i + 1)),
            'section'           => $section,
            'priority'          => $priority,
            'default'           => $materialis_top_bar_fields_defaults[$i]['text'],
            'sanitize_callback' => 'materialis_wp_kses_post',
            'transport'         => 'postMessage',
        ));

        $group_choices[] = "{$prefix}_info_field_{$i}_text";
    }


    materialis_add_kirki_field(array(
        'type'            => 'sidebar-button-group',
        'settings'        => "{$prefix}_info_fields_group_button",
        'label'           => esc_html__('Info Options', 'materialis'),
        'section'         => $section,
        'priority'        => $priority,
        "choices"         => $group_choices,
        'active_callback' => array(
            array(
                'setting'  => "{$prefix}_content",
                'operator' => '==',
                'value'    => 'info',
            ),
            array(
                'setting'  => "enable_top_bar",
                'operator' => '==',
                'value'    => true,
            ),
        ),
    ));

}

/*
    template functions
*/

function materialis_header_top_bar_content_print_info_fields($areaName, $type)
{
    if ($type == 'info') {
        materialis_print_header_top_bar_info_fields($areaName);
    }
}

add_action("materialis_header_top_bar_content_print", 'materialis_header_top_bar_content_print_info_fields', 1, 2);


function materialis_print_header_top_bar_info_fields($area)
{
    $defaults = materialis_top_bar_fields_defaults();

    for ($i = 0; $i < count($defaults); $i++) {
        $preview_atts = "";
        if (materialis_is_customize_preview()) {
            $setting      = "header_top_bar_{$area}_info_field_{$i}_icon";
            $preview_atts = "data-focus-control='" . esc_attr($setting) . "'";
        }

        $can_show   = materialis_can_show_demo_content();
        $is_enabled = materialis_get_theme_mod("header_top_bar_{$area}_info_field_{$i}_enabled", true);
        $icon       = materialis_get_theme_mod("header_top_bar_{$area}_info_field_{$i}_icon", $defaults[$i]['icon']);
        $text       = materialis_get_theme_mod("header_top_bar_{$area}_info_field_{$i}_text", $can_show ? $defaults[$i]['text'] : "");

        if ( ! intval($is_enabled)) {
            continue;
        }

        if ( ! $can_show && ! $text) {
            continue;
        }

        ?>
        <div class="top-bar-field" data-type="group" <?php echo $preview_atts; ?> data-dynamic-mod="true">
            <i class="mdi <?php echo esc_attr($icon) ?>"></i>
            <span><?php echo materialis_wp_kses_post($text); ?></span>
        </div>
        <?php

    }

}
