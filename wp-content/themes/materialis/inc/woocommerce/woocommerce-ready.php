<?php


add_action('customize_register', function ($wp_customize) {

    $panel = 'materialis_woocommerce_panel';

    $wp_customize->add_section(
        $panel,
        array(
            'capability' => 'edit_theme_options',
            'title'      => esc_html__('WooCommerce Options', 'materialis'),
        )
    );


    materialis_add_kirki_field(array(
        'type'     => 'ope-info',
        'label'    => materialis_wp_kses_post('Materialis theme is <b>WooCommerce ready</b>. After you install the <b>WooCommerce</b> plugin you will be able to customize the shop inside this section.', 'materialis'),
        'section'  => $panel,
        'settings' => "woocommerce_ready",
    ));

}, 10, 1);
