<?php

function materialis_smooth_scroll()
{
    $section = "page_settings";

    materialis_add_kirki_field(array(
        'type'     => 'checkbox',
        'settings' => 'enable_smooth_scroll',
        'label'    => esc_html__('Enable smooth scrolling', 'materialis'),
        'section'  => $section,
        'default'  => false,
        'transport' => 'postMessage',
    ));
}

//materialis_smooth_scroll();


add_action('wp_head', 'materialis_add_smooth_scroll');

function materialis_add_smooth_scroll()
{
    $enable_smooth_scroll = false;//materialis_get_theme_mod("enable_smooth_scroll", false);
    if ($enable_smooth_scroll) {
        $materialis_smooth_scroll = array("enabled" => true);
    	wp_localize_script(materialis_get_text_domain() . '-theme', 'materialis_smooth_scroll', $materialis_smooth_scroll);
    }
}
