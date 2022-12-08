<?php

require_once get_template_directory() . "/inc/header-options/navigation-options/top-bar.php";
require_once get_template_directory() . "/inc/header-options/navigation-options/nav-bar.php";
require_once get_template_directory() . "/inc/header-options/navigation-options/offscreen.php";


function materialis_customizer_add_navigation_sections($wp_customize)
{
    $sections = array(
        'navigation_top_bar'    => esc_html__('Top Bar', 'materialis'),
        'front_page_navigation' => esc_html__('Front Page Navigation', 'materialis'),
        'inner_page_navigation' => esc_html__('Inner Page Navigation', 'materialis'),
        'navigation_offscreen'  => esc_html__('Mobile (Offscreen) Navigation', 'materialis'),
    );

    foreach ($sections as $id => $title) {
        $wp_customize->add_section($id, array(
            'title' => $title,
            'panel' => 'navigation_panel',
        ));
    }

}

add_action('materialis_add_sections', 'materialis_customizer_add_navigation_sections');
