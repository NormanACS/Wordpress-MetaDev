<?php

add_filter('materialis_header_background_types', 'materialis_header_background_slideshow');

function materialis_header_background_slideshow($types)
{

    $types['slideshow'] = esc_html__('Slideshow', 'materialis');

    return $types;
}

function materialis_background_slideshow_bg($bg_type, $inner, $prefix)
{
    if ($bg_type == 'slideshow') {
        $js = get_template_directory_uri() . "/assets/js/libs/jquery.backstretch.js";
        wp_enqueue_script(materialis_get_text_domain() . '-backstretch', $js, array('jquery'), false, true);
        add_action('wp_footer', "materialis_" . $prefix . '_slideshow_script');
    }
}

add_action("materialis_background", 'materialis_background_slideshow_bg', 1, 3);


add_filter("materialis_header_background_type_settings", 'materialis_header_background_type_slideshow_settings', 1, 6);

function materialis_header_background_type_slideshow_settings($section, $prefix, $group, $inner, $priority)
{

    $prefix  = $inner ? "inner_header" : "header";
    $section = $inner ? "header_image" : "header_background_chooser";

    $group = "{$prefix}_bg_options_group_button";

    materialis_add_kirki_field(array(
        'type'            => 'sectionseparator',
        'label'           => esc_html__('Slideshow Background Options', 'materialis'),
        'section'         => $section,
        'settings'        => $prefix . '_slideshow_background_options_separator',
        'priority'        => 2,
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_background_type',
                'operator' => '==',
                'value'    => 'slideshow',
            ),
        ),
        'group'           => $group,
    ));

    materialis_add_kirki_field(array(
        'type'            => 'repeater',
        'label'           => esc_html__('Header Slideshow Images', 'materialis'),
        'section'         => $section,
        'priority'        => 2,
        'row_label'       => array(
            'type'  => 'text',
            'value' => esc_attr__('slideshow image', 'materialis'),
        ),
        'settings'        => $prefix . '_slideshow',
        'default'         => array(
            array("url" => get_template_directory_uri() . "/assets/images/slideshow_slide1.jpg"),
            array("url" => get_template_directory_uri() . "/assets/images/slideshow_slide2.jpg"),
        ),
        'fields'          => array(
            'url' => array(
                'type'    => 'image',
                'label'   => esc_attr__('Image', 'materialis'),
                'default' => get_template_directory_uri() . "/assets/images/slideshow_slide1.jpg",
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_background_type',
                'operator' => '==',
                'value'    => 'slideshow',
            ),
        ),
        'group'           => $group,
    ));

    materialis_add_kirki_field(array(
        'type'            => 'number',
        'settings'        => $prefix . '_slideshow_duration',
        'label'           => esc_html__('Slide Duration', 'materialis'),
        'section'         => $section,
        'priority'        => 2,
        'default'         => 5000,
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_background_type',
                'operator' => '==',
                'value'    => 'slideshow',
            ),
        ),
        'transport'       => 'postMessage',
        'group'           => $group,
    ));

    materialis_add_kirki_field(array(
        'type'            => 'number',
        'priority'        => 2,
        'settings'        => $prefix . '_slideshow_speed',
        'label'           => esc_html__('Effect Speed', 'materialis'),
        'section'         => $section,
        'default'         => 1000,
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_background_type',
                'operator' => '==',
                'value'    => 'slideshow',
            ),
        ),
        'group'           => $group,
        'transport'       => 'postMessage',
    ));
}


function materialis_header_slideshow_script()
{
    materialis_add_slideshow_scripts();
}

function materialis_inner_header_slideshow_script()
{
    materialis_add_slideshow_scripts(true);
}

function materialis_add_slideshow_scripts($inner = false)
{
    $prefix = $inner ? "inner_header" : "header";

    $textDomain = materialis_get_text_domain();

    $bgSlideshow = materialis_get_theme_mod($prefix . "_slideshow", array(
        array("url" => get_template_directory_uri() . "/assets/images/slideshow_slide1.jpg"),
        array("url" => get_template_directory_uri() . "/assets/images/slideshow_slide2.jpg"),
    ));

    $images = array();
    foreach ($bgSlideshow as $key => $value) {

        if (empty($value['url'])) {
            continue;
        }

        if (is_numeric($value['url'])) {
            array_push($images, esc_url_raw(wp_get_attachment_url($value['url'])));
        } else {
            array_push($images, esc_url_raw($value['url']));
        }
    }

    $bgSlideshowSpeed    = intval(materialis_get_theme_mod($prefix . "_slideshow_speed", '1000'));
    $bgSlideshowDuration = intval(materialis_get_theme_mod($prefix . "_slideshow_duration", '5000'));

    $materialis_jssettings = array(
        'images'             => $images,
        'duration'           => intval($bgSlideshowDuration),
        'transitionDuration' => intval($bgSlideshowSpeed),
        'animateFirst'       => false,
    );

    wp_localize_script($textDomain . '-backstretch', 'materialis_backstretch', $materialis_jssettings);
}
