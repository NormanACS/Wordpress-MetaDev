<?php

add_action("materialis_header_background_overlay_settings", "materialis_front_page_header_general_settings", 4, 5);

function materialis_front_page_header_general_settings($section, $prefix, $group, $inner, $priority)
{

    if ($inner) return;

    $priority = 5;
    $prefix   = "header";
    $section  = "header_background_chooser";
    $group = "";

    materialis_add_kirki_field(array(
        'type'      => 'checkbox',
        'label'     => esc_html__('Full Height Background', 'materialis'),
        'settings'  => 'full_height_header',
        'default'   => false,
        'transport' => 'postMessage',
        'section'   => $section,
        'priority'  => $priority,
        'group' => $group
    ));
}
