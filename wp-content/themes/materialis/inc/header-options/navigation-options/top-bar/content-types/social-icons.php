<?php

function materialis_get_content_types_register_social_icons($types)
{
    $types['social'] = esc_html__("Social Icons", 'materialis');

    return $types;
}

add_filter("materialis_get_content_types", 'materialis_get_content_types_register_social_icons');

function materialis_get_content_types_options_register_social_icons($options)
{
    $options['social'] = "materialis_top_bar_social_icons_fields_options";

    return $options;
}

add_filter("materialis_get_content_types_options", 'materialis_get_content_types_options_register_social_icons');

function materialis_top_bar_default_icons()
{
    $default_icons                                       = materialis_default_icons();
    $default_icons[count($default_icons) - 1]['enabled'] = false;

    return $default_icons;
}

function materialis_top_bar_social_icons_fields_options($area, $section, $priority, $prefix)
{

    materialis_add_kirki_field(array(
        'type'     => 'sectionseparator',
        'label'    => esc_html__('Social Icons', 'materialis'),
        'section'  => $section,
        'priority' => $priority,
        'settings' => "{$prefix}_social_fields_icons_separator",
    ));

    $group_choices = array(
        "{$prefix}_social_fields_colors_separator",
        "{$prefix}_social_icons_options_icon_color",
        "{$prefix}_social_icons_options_icon_hover_color",
        "{$prefix}_social_fields_icons_separator",
    );

    $default_icons = materialis_top_bar_default_icons();


    for ($i = 0; $i < count($default_icons); $i++) {
        materialis_add_kirki_field(array(
            'type'     => 'checkbox',
            'label'    => sprintf(esc_html__('Show Icon %d', 'materialis'), ($i + 1)),
            'section'  => $section,
            'priority' => $priority,
            'settings' => "{$prefix}_social_icon_{$i}_enabled",
            'default'  => $default_icons[$i]['enabled'],
        ));

        $active_callback = array(
            array(
                'setting'  => "{$prefix}_social_icon_{$i}_enabled",
                'operator' => '==',
                'value'    => true,
            ),
        );

        $group_choices[] = "{$prefix}_social_icon_{$i}_enabled";

        materialis_add_kirki_field(array(
            'type'            => 'material-icons-icon-control',
            'settings'        => "{$prefix}_social_icon_{$i}_icon",
            'label'           => sprintf(esc_html__('Icon %d icon', 'materialis'), ($i + 1)),
            'section'         => $section,
            'priority'        => $priority,
            'default'         => $default_icons[$i]['icon'],
            'active_callback' => $active_callback,

        ));

        $group_choices[] = "{$prefix}_social_icon_{$i}_icon";

        materialis_add_kirki_field(array(
            'type'            => 'text',
            'settings'        => "{$prefix}_social_icon_{$i}_link",
            'label'           => sprintf(esc_html__('Field %d link', 'materialis'), ($i + 1)),
            'section'         => $section,
            'priority'        => $priority,
            'transport'       => 'postMessage',
            'default'         => $default_icons[$i]['link'],
            'active_callback' => $active_callback,
        ));

        $group_choices[] = "{$prefix}_social_icon_{$i}_link";
    }

    materialis_add_kirki_field(array(
        'type'            => 'sidebar-button-group',
        'settings'        => "{$prefix}_social_icons_group_button",
        'label'           => esc_html__('Social Icons Options', 'materialis'),
        'section'         => $section,
        'priority'        => $priority,
        "choices"         => $group_choices,
        'active_callback' => array(
            array(
                'setting'  => "{$prefix}_content",
                'operator' => '==',
                'value'    => 'social',
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

function materialis_header_top_bar_content_print_social_icons($areaName, $type)
{
    if ($type == 'social') {
        $defaultIcons = materialis_top_bar_default_icons();

        materialis_print_area_social_icons('header_top_bar', $areaName, "top-bar-social-icons", count($defaultIcons), $defaultIcons);
    }
}

add_action("materialis_header_top_bar_content_print", 'materialis_header_top_bar_content_print_social_icons', 1, 2);

function materialis_default_icons()
{
    return array(
        array(
            "icon"    => "mdi-facebook-box",
            "link"    => "https://facebook.com",
            "enabled" => true,
        ),
        array(
            "icon"    => "mdi-twitter-box",
            "link"    => "https://twitter.com",
            "enabled" => true,
        ),
        array(
            "icon"    => "mdi-instagram",
            "link"    => "https://instagram.com",
            "enabled" => true,
        ),
        array(
            "icon"    => "mdi-google-plus-box",
            "link"    => "https://plus.google.com",
            "enabled" => true,
        ),
        array(
            "icon"    => "mdi-youtube-play",
            "link"    => "https://www.youtube.com",
            "enabled" => true,
        ),
    );
}

function materialis_print_area_social_icons($prefix, $area, $class = "social-icons", $max = 4, $defaultIcons = null)
{

    $defaults = is_array($defaultIcons) ? $defaultIcons : materialis_default_icons();

    $preview_atts = "";
    if (materialis_is_customize_preview()) {
        $setting      = "{$prefix}_{$area}_social_icon_0_enabled";
        $preview_atts = "data-focus-control='" . esc_attr($setting) . "'";
    }

    ?>
    <div data-type="group" <?php echo $preview_atts; ?> data-dynamic-mod="true" class="<?php echo esc_attr($class); ?>">
        <?php

        for ($i = 0; $i < min(count($defaults), $max); $i++) {

            $is_enabled = materialis_get_theme_mod("{$prefix}_{$area}_social_icon_{$i}_enabled", isset($defaults[$i]['enabled']) ? $defaults[$i]['enabled'] : true);
            $icon       = materialis_get_theme_mod("{$prefix}_{$area}_social_icon_{$i}_icon", $defaults[$i]['icon']);
            $link       = materialis_get_theme_mod("{$prefix}_{$area}_social_icon_{$i}_link", $defaults[$i]['link']);

            $hidden_attr = "";

            if ( ! intval($is_enabled)) {
                $hidden_attr = "data-reiki-hidden='true'";
            }

            if ( ! materialis_can_show_demo_content() && ! $link) {
                continue;
            }

            if(intval($is_enabled)) {
              ?>
              <a target="_blank" <?php echo $hidden_attr ?> class="social-icon" href="<?php echo esc_url($link) ?>">
                  <i class="mdi <?php echo esc_attr($icon) ?>"></i>
              </a>
              <?php
            }

        }
        ?>

    </div>

    <?php
}
