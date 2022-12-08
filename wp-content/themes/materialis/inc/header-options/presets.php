<?php

function materialis_get_header_presets()
{
    global $MATERIALIS_HEADER_PRESETS;

    $result       = array();
    $presets_file = get_template_directory() . '/customizer/presets.php';
    if (file_exists($presets_file) && ! isset($MATERIALIS_HEADER_PRESETS)) {
        $MATERIALIS_HEADER_PRESETS = require $presets_file;
    }

    if (isset($MATERIALIS_HEADER_PRESETS)) {
        $result = $MATERIALIS_HEADER_PRESETS;
    }


    $result = apply_filters('materialis_header_presets', $result);

    return $result;

}

function materialis_customize_register_header_presets($wp_customize) {
    /** @var WP_Customize_Manager $wp_customize */
    $wp_customize->add_setting('header_presets', array(
        'default'           => "",
        'sanitize_callback' => 'esc_html',
        "transport"         => "postMessage",
    ));

    $wp_customize->add_control(new Materialis\RowsListControl($wp_customize, 'header_presets', array(
        'label'       => esc_html__('Background Type', 'materialis'),
        'section'     => 'header_layout',
        "insertText"  => esc_html__("Apply Preset", "materialis"),
        'pro_message' => false,
        "type"        => "presets_changer",
        "dataSource"  => materialis_get_header_presets(),
        "priority"    => 2,
    )));


    $wp_customize->add_setting('frontpage_header_presets_pro', array(
        'default'           => "",
        'sanitize_callback' => 'esc_html',
        "transport"         => "postMessage",
    ));


    if ( ! apply_filters('materialis_is_companion_installed', false)) {
        $wp_customize->add_control(new Materialis\Info_PRO_Control($wp_customize, 'frontpage_header_presets_pro',
            array(
                'label'     => esc_html__('18 more beautiful header designs are available in the PRO version. @BTN@', 'materialis'),
                'section'   => 'header_layout',
                'priority'  => 10,
                'transport' => 'postMessage',
            )));
    }
}

add_action("materialis_customize_register", 'materialis_customize_register_header_presets' );
