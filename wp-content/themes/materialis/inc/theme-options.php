<?php

add_action('customize_register', 'materialis_customize_register', 10, 1);
add_action('customize_register', 'materialis_customize_reorganize', PHP_INT_MAX, 1);

require_once get_template_directory() . "/inc/general-options.php";
require_once get_template_directory() . "/inc/header-options.php";
require_once get_template_directory() . "/inc/footer-options.php";
require_once get_template_directory() . "/inc/blog-options.php";

function materialis_add_options_group($options)
{
    foreach ($options as $option => $args) {
        do_action_ref_array($option . "_before", $args);
        call_user_func_array($option, $args);
        do_action_ref_array($option . "_after", $args);
    }
}

function materialis_customize_register($wp_customize)
{
    /** @var WP_Customize_Manager $wp_customize */
    $wp_customize->get_setting('background_color')->transport = 'refresh';

    materialis_customize_register_controls($wp_customize);

    do_action('materialis_customize_register', $wp_customize);
}

function materialis_add_sections($wp_customize)
{

    /** @var WP_Customize_Manager $wp_customize */
    $wp_customize->add_section('header_layout', array(
        'title'    => esc_html__('Front Page Header Designs', 'materialis'),
        'priority' => 1,
    ));

    $wp_customize->add_panel('navigation_panel',
        array(
            'priority'       => 2,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
            'title'          => esc_html__('Navigation', 'materialis'),
            'description'    => '',
        )
    );

    $wp_customize->add_panel('header',
        array(
            'priority'       => 2,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
            'title'          => esc_html__('Hero', 'materialis'),
            'description'    => '',
        )
    );

    $wp_customize->add_section(
        new \Materialis\FrontPageSection(
            $wp_customize,
            'page_content',
            array(
                'priority' => 2,
                'title'    => esc_html__('Front Page content', 'materialis'),
            )
        )
    );

    $wp_customize->add_section('footer_settings', array(
        'title'    => esc_html__('Footer Settings', 'materialis'),
        'priority' => 3,
    ));

    if (!apply_filters('materialis_is_companion_installed', false)) {
        $wp_customize->add_section('layout_settings', array(
            'title'    => esc_html__('Layout', 'materialis'),
            'priority' => 4,
        ));
    }

    $wp_customize->add_panel('general_settings', array(
        'title'    => esc_html__('General Settings', 'materialis'),
        'priority' => 5,
    ));
    $wp_customize->add_section('blog_settings', array(
        'title'    => esc_html__('Blog Settings', 'materialis'),

        'priority' => 5,
    ));

    do_action('materialis_add_sections', $wp_customize);

    $sections = array(

        'header_background_chooser' => array(
            'title' => esc_html__('Front Page Hero', 'materialis'),
            'panel' => 'header',
        ),

        'header_content'            => array(
            'title' => esc_html__('Front Page Hero Content', 'materialis'),
            'panel' => 'header',
        ),

        'header_image'              => array(
            'title' => esc_html__('Inner Pages Hero', 'materialis'),
            'panel' => 'header',
        ),

        'page_settings'             => array(
            'title' => esc_html__('Page Settings', 'materialis'),
            'panel' => 'general_settings',
        ),

    );

    foreach ($sections as $name => $value) {
        $wp_customize->add_section($name, $value);
    }

}

function materialis_register_kirki_control_types($controls)
{
    $controls['sectionseparator']            = '\\Materialis\\Kirki_Controls_Separator_Control';
    $controls['ope-info']                    = '\\Materialis\\Info_Control';
    $controls['ope-info-pro']                = '\\Materialis\\Info_PRO_Control';
    $controls['web-gradients']               = "\\Materialis\\WebGradientsControl";
    $controls['sidebar-button-group']        = "\\Materialis\\SidebarGroupButtonControl";
    $controls['radio-html']                  = '\\Materialis\\Kirki_Controls_Radio_HTML_Control';
    $controls['material-icons-icon-control'] = "\\Materialis\\MaterialIconsIconControl";
    $controls['gradient-control']            = "\\Materialis\\GradientControl";

    return $controls;
}

function materialis_customize_register_controls($wp_customize)
{
    /** @var WP_Customize_Manager $wp_customize */
    $wp_customize->register_control_type('\\Materialis\\Kirki_Controls_Separator_Control');
    $wp_customize->register_control_type("\\Materialis\\WebGradientsControl");
    $wp_customize->register_control_type("\\Materialis\\SidebarGroupButtonControl");
    $wp_customize->register_control_type('\Materialis\Kirki_Controls_Radio_HTML_Control');
    $wp_customize->register_control_type('\\Materialis\MaterialIconsIconControl');
    $wp_customize->register_control_type('Materialis\\GradientControl');

    // Register our custom control with Kirki
    add_filter('kirki/control_types', 'materialis_register_kirki_control_types');

    require_once get_template_directory() . "/customizer/customizer-controls.php";
    require_once get_template_directory() . "/customizer/WebGradientsControl.php";
    require_once get_template_directory() . "/customizer/SidebarGroupButtonControl.php";
    require_once get_template_directory() . "/customizer/GradientControl.php";

    materialis_add_sections($wp_customize);
    materialis_add_general_settings($wp_customize);
}

function materialis_add_general_settings($wp_customize)
{

    /* logo max height */

    materialis_add_kirki_field(array(
        'type'      => 'number',
        'label'     => esc_html__('Logo Max Height (px)', 'materialis'),
        'settings'  => 'logo_max_height',
        'section'   => 'title_tagline',
        'default'   => 70,
        'transport' => 'postMessage',
        'priority'  => 8,
    ));

    $wp_customize->add_setting('bold_logo', array(
        'default'           => true,
        'sanitize_callback' => 'materialis_sanitize_boolean',
    ));
    $wp_customize->add_control('bold_logo', array(
        'label'    => esc_html__('Alternate text logo words', 'materialis'),
        'section'  => 'title_tagline',
        'priority' => 9,
        'type'     => 'checkbox',
    ));

    $wp_customize->add_setting('logo_dark', array(
        'default'           => false,
        'sanitize_callback' => 'absint',
    ));

    $custom_logo_args = get_theme_support('custom-logo');
    $wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'logo_dark', array(
        'label'         => esc_html__('Dark Logo', 'materialis'),
        'section'       => 'title_tagline',
        'priority'      => 9,
        'height'        => $custom_logo_args[0]['height'],
        'width'         => $custom_logo_args[0]['width'],
        'flex_height'   => $custom_logo_args[0]['flex-height'],
        'flex_width'    => $custom_logo_args[0]['flex-width'],
        'button_labels' => array(
            'select'       => __('Select logo', 'materialis'),
            'change'       => __('Change logo', 'materialis'),
            'remove'       => __('Remove', 'materialis'),
            'default'      => __('Default', 'materialis'),
            'placeholder'  => __('No logo selected', 'materialis'),
            'frame_title'  => __('Select logo', 'materialis'),
            'frame_button' => __('Choose logo', 'materialis'),
        ),
    )));

    // remove partial refresh to display the site name properly in customizer
    $wp_customize->selective_refresh->remove_partial('custom_logo');
    $wp_customize->get_setting('custom_logo')->transport = 'refresh';
}

function materialis_customize_reorganize($wp_customize)
{
    $generalSettingsSections = array(
        'title_tagline',
        'colors',
        'layout_settings',
        'general_site_style',
        'background_image',
        'static_front_page',
        'custom_css',
        'user_custom_widgets_areas',
//        'blog_settings',
    );

    $priority = 1;
    foreach ($generalSettingsSections as $section_id) {
        $section = $wp_customize->get_section($section_id);

        if ($section) {
            $section->panel    = 'general_settings';
            $section->priority = $priority;
            $priority++;
        }

    }
}

function materialis_customize_controls_enqueue_scripts()
{

    $textDomain = materialis_get_text_domain();

    $cssUrl = get_template_directory_uri() . "/customizer/";
    $jsUrl  = get_template_directory_uri() . "/customizer/js/";

    wp_enqueue_style('thickbox');
    wp_enqueue_script('thickbox');

    wp_enqueue_style($textDomain . '-webgradients', get_template_directory_uri() . '/assets/css/webgradients.css');

    if (apply_filters('materialis_load_bundled_version', true)) {
        wp_enqueue_script($textDomain . '-customize', $jsUrl . "/customize.bundle.min.js", array('jquery', 'customize-base', 'customize-controls', 'media-views'), true);
        wp_enqueue_style($textDomain . '-customizer-base', $cssUrl . '/customizer.bundle.min.css');
    } else {
		wp_enqueue_style($textDomain . '-customizer-base', $cssUrl . '/customizer.css');
        wp_enqueue_script($textDomain . '-customize', $jsUrl . "/customize.js", array('jquery', 'customize-base', 'customize-controls'), true);
    }

    $settings = array(
        'stylesheetURL' => get_template_directory_uri(),
        'templateURL'   => get_template_directory_uri(),
        'includesURL'   => includes_url(),
        'l10n'          => array(
            'closePanelLabel'     => esc_attr__('Close Panel', 'materialis'),
            'chooseImagesLabel'   => esc_attr__('Choose Images', 'materialis'),
            'chooseGradientLabel' => esc_attr__("Web Gradients", 'materialis'),
            'chooseMDILabel'      => esc_attr__("Material Icons", 'materialis'),
            'selectGradient'      => esc_attr__("Select Gradient", 'materialis'),
            'deselect'            => esc_attr__("Deselect", 'materialis'),
            'changeImageLabel'    => esc_attr__('Change image', 'materialis'),
        ),
    );

    wp_localize_script('customize-base', 'materialis_customize_settings', $settings);
}

add_action('customize_controls_enqueue_scripts', 'materialis_customize_controls_enqueue_scripts');

function materialis_customize_preview_init()
{
    $textDomain = materialis_get_text_domain();

    $jsUrl = get_template_directory_uri() . "/customizer/js/";
    wp_enqueue_script($textDomain . '-customize-preview', $jsUrl . "/customize-preview.js", array('jquery', 'customize-preview'), '', true);
}

add_action('customize_preview_init', 'materialis_customize_preview_init');


function materialis_get_gradients_classes()
{
    return apply_filters("materialis_webgradients_list", array(
        "easter_blueberry",
        "plum_plate",
        "ripe_malinka",
        "new_life",
        "sunny_morning",
    ));
}

function materialis_get_parsed_gradients()
{
    return apply_filters("materialis_parsed_webgradients_list", array(

        'easter_blueberry' => array(
            'angle'  => '180',
            'colors' => array(
                0 => array(
                    'color'    => 'rgba(101,78,163, 0.8)',
                    'position' => '0%',
                ),
                1 => array(
                    'color'    => 'rgba(191,105,253,0.8)',
                    'position' => '100%',
                ),
            ),
        ),

        'plum_plate' => array(
            'angle'  => '135',
            'colors' => array(
                0 => array(
                    'color'    => 'rgba(102,126,234, 0.8)',
                    'position' => '0%',
                ),
                1 => array(
                    'color'    => 'rgba(118,75,162,0.8)',
                    'position' => '100%',
                ),
            ),
        ),

        'ripe_malinka' => array(
            'angle'    => '120',
            'colors'   => array(
                0 => array(
                    'color'    => 'rgba(240,147,251,0.8)',
                    'position' => '0%',
                ),
                1 => array(
                    'color'    => 'rgba(245,87,108,0.8)',
                    'position' => '100%',
                ),
            ),
        ),

        'new_life'   => array(
            'angle'  => '90',
            'colors' => array(
                0 => array(
                    'color'    => 'rgba(67,233,123,0.8)',
                    'position' => '0%',
                ),
                1 => array(
                    'color'    => 'rgba(56,249,215,0.8)',
                    'position' => '100%',
                ),
            ),
        ),

        'sunny_morning' => array(
            'angle'     => '120',
            'colors'    => array(
                0 => array(
                    'color'    => 'rgba(246,211,101,0.8)',
                    'position' => '0%',
                ),
                1 => array(
                    'color'    => 'rgba(253,160,133,0.8)',
                    'position' => '100%',
                ),
            ),
        ),

    ));
}

function materialis_wp_ajax_materialis_webgradients_list()
{
    $result           = array();
    $webgradients     = materialis_get_gradients_classes();
    $parsed_gradients = materialis_get_parsed_gradients();

    foreach ($webgradients as $icon) {
        $parsed   = isset($parsed_gradients[$icon]) ? $parsed_gradients[$icon] : false;
        $title    = str_replace('_', ' ', $icon);
        $result[] = array(
            'id'       => $icon,
            'gradient' => $icon,
            "title"    => $title,
            'mime'     => "web-gradient/class",
            'sizes'    => null,
            'parsed'   => $parsed,
        );
    }


    $result = apply_filters("materialis_wp_ajax_webgradients_list", $result);

    echo json_encode($result);

    exit;
}

add_action('wp_ajax_materialis_webgradients_list', 'materialis_wp_ajax_materialis_webgradients_list');

function materialis_wp_ajax_materialis_list_mdi()
{

    $result = array();
    $icons  = (require get_template_directory() . "/customizer/mdi-icons-list.php");
    foreach ($icons as $icon) {
        $title    = str_replace('-', ' ', str_replace('mdi-', '', $icon));
        $result[] = array(
            'id'    => $icon,
            'mdi'   => $icon,
            "title" => $title,
            'mime'  => "fa-icon/font",
            'sizes' => null,
        );
    }

    echo json_encode($result);
    exit;

}

add_action('wp_ajax_materialis_list_mdi', 'materialis_wp_ajax_materialis_list_mdi');

function materialis_body_class($classes)
{
    $body_class = materialis_is_front_page(true) ? "materialis-front-page" : "materialis-inner-page";
    $body_class = array($body_class);

    $classes = array_merge($classes, $body_class);

    if (in_array('materialis-front-page', $classes)) {
        $classes[] = 'materialis-content-padding';

    }

    return $classes;
}

add_filter('body_class', 'materialis_body_class');


// code from rest_sanitize_boolean
function materialis_sanitize_boolean($value)
{
    // String values are translated to `true`; make sure 'false' is false.
    if (is_string($value)) {
        $value = strtolower($value);
        if (in_array($value, array('false', '0'), true)) {
            $value = false;
        }
    }

    // Everything else will map nicely to boolean.
    return (boolean)$value;
}


/**
 * @param      $control
 * @param bool $print
 *
 * @return bool|string
 */
function materialis_customizer_focus_control_attr($control, $print = true)
{
    if ( ! materialis_is_customize_preview()) {
        return false;
    }

    $control = esc_attr($control);
    $toPrint = "data-type=\"group\" data-focus-control='{$control}'";

    if ($print) {
        echo $toPrint;
    }

    return $toPrint;
}
