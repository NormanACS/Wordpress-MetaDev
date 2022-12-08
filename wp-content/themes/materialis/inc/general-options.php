<?php

require_once get_template_directory() . "/inc/general-options/colors.php";
require_once get_template_directory() . "/inc/general-options/layout-settings.php";
require_once get_template_directory() . "/inc/general-options/companion-options.php";

add_action('customize_register', 'materialis_pro_section_button');


function materialis_pro_section_button($wp_customize)
{
    /** @var WP_Customize_Manager $wp_customize */
    $wp_customize->add_section(new Materialis\Info_PRO_Section(
        $wp_customize,
        'materialis-pro',
        array(
            "priority"   => 0,
            'capability' => "edit_theme_options",
        )));
}

add_filter('embed_oembed_html', function ($result) {
    return "<div class='embed-container'>{$result}</div>";
});
