<?php


materialis_add_kirki_field(array(
    'type'     => 'sectionseparator',
    'label'    => esc_html__('Shop Page Settings', 'materialis'),
    'settings' => "woocommerce_shop_page_separator_options",
    'section'  => 'materialis_woocommerce_product_list',
    'priority' => '1',

));

add_action('customize_register', 'materialis_add_shop_page_setting_options');

function materialis_add_shop_page_setting_options()
{
    do_action('materialis_customizer_prepend_woocommerce_list_options', 'materialis_woocommerce_product_list');
}

materialis_add_kirki_field(array(
    'type'     => 'number',
    'settings' => "woocommerce_products_per_page",
    'label'    => esc_html__('Products per page', 'materialis'),
    'section'  => 'materialis_woocommerce_product_list',
    'default'  => 12,
    'priority' => '10',
));

materialis_add_kirki_field(array(
    'type'     => 'number',
    'settings' => "woocommerce_list_item_desktop_cols",
    'label'    => esc_html__('Products per row on desktop', 'materialis'),
    'section'  => 'materialis_woocommerce_product_list',
    'default'  => 4,
    'choices'  => array(
        'min'  => 2,
        'max'  => 8,
        'step' => 1,
    ),
    'priority' => '10',
));


materialis_add_kirki_field(array(
    'type'     => 'number',
    'settings' => "woocommerce_list_item_tablet_cols",
    'label'    => esc_html__('Products per row on tablet', 'materialis'),
    'section'  => 'materialis_woocommerce_product_list',
    'default'  => 2,
    'choices'  => array(
        'min'  => 1,
        'max'  => 6,
        'step' => 1,
    ),
    'priority' => '10',
));


materialis_add_kirki_field(array(
    'type'     => 'sectionseparator',
    'label'    => esc_html__('Related products Settings', 'materialis'),
    'settings' => "woocommerce_related_products_separator_options",
    'section'  => 'materialis_woocommerce_product_list',
    'priority' => '21',

));

materialis_add_kirki_field(array(
    'type'      => 'number',
    'settings'  => "woocommerce_related_list_item_desktop_cols",
    'label'     => esc_html__('Related products per row on desktop', 'materialis'),
    'section'   => 'materialis_woocommerce_product_list',
    'default'   => 4,
    'choices'  => array(
        'min'  => 2,
        'max'  => 8,
        'step' => 1,
    ),
    'priority'  => '30',
));


materialis_add_kirki_field(array(
    'type'     => 'number',
    'settings' => "woocommerce_related_list_item_tablet_cols",
    'label'    => esc_html__('Related products per row on tablet', 'materialis'),
    'section'  => 'materialis_woocommerce_product_list',
    'default'  => 2,
    'choices'  => array(
        'min'  => 2,
        'max'  => 6,
        'step' => 1,
    ),
    'priority' => '30',
));

materialis_add_kirki_field(array(
    'type'     => 'sectionseparator',
    'label'    => esc_html__('Upsell products Settings', 'materialis'),
    'settings' => "woocommerce_up_sell_products_separator_options",
    'section'  => 'materialis_woocommerce_product_list',
    'priority' => '41',

));

materialis_add_kirki_field(array(
    'type'     => 'ope-info',
    'label'    => esc_html__('The upsell product list appears in the product page, before the related products list', 'materialis'),
    'section'  => 'materialis_woocommerce_product_list',
    'settings' => "woocommerce_upsells_list_item_desktop_cols_info",
    'priority' => '50',
));

materialis_add_kirki_field(array(
    'type'     => 'number',
    'settings' => "woocommerce_upsells_list_item_desktop_cols",
    'label'    => esc_html__('Upsell products per row on desktop', 'materialis'),
    'section'  => 'materialis_woocommerce_product_list',
    'default'  => 4,
    'choices'  => array(
        'min'  => 2,
        'max'  => 8,
        'step' => 1,
    ),
    'priority' => '50',
));

materialis_add_kirki_field(array(
    'type'     => 'number',
    'settings' => "woocommerce_upsells_list_item_tablet_cols",
    'label'    => esc_html__('Upsell products per row on tablet', 'materialis'),
    'section'  => 'materialis_woocommerce_product_list',
    'default'  => 2,
    'choices'  => array(
        'min'  => 2,
        'max'  => 6,
        'step' => 1,
    ),
    'priority' => '50',
));

materialis_add_kirki_field(array(
    'type'     => 'sectionseparator',
    'label'    => esc_html__('Cross-sell products Settings', 'materialis'),
    'settings' => "woocommerce_cross_sell_products_separator_options",
    'section'  => 'materialis_woocommerce_product_list',
    'priority' => '61',

));


materialis_add_kirki_field(array(
    'type'     => 'ope-info',
    'label'    => esc_html__('The cross-sell product list appears in the shopping cart page', 'materialis'),
    'section'  => 'materialis_woocommerce_product_list',
    'settings' => "woocommerce_cross_sell_list_item_desktop_cols_info",
    'priority' => '70',
));


materialis_add_kirki_field(array(
    'type'     => 'number',
    'settings' => "woocommerce_cross_sells_product_no",
    'label'    => esc_html__('Number of cross-sell products to display', 'materialis'),
    'section'  => 'materialis_woocommerce_product_list',
    'default'  => 2,
    'choices'  => array(
        'min'  => 0,
        'max'  => 50,
        'step' => 1,
    ),
    'priority' => '70',
));

materialis_add_kirki_field(array(
    'type'     => 'number',
    'settings' => "woocommerce_cross_sell_list_item_desktop_cols",
    'label'    => esc_html__('Cross-sell products per row on desktop', 'materialis'),
    'section'  => 'materialis_woocommerce_product_list',
    'default'  => 2,
    'choices'  => array(
        'min'  => 2,
        'max'  => 8,
        'step' => 1,
    ),
    'priority' => '70',
));


materialis_add_kirki_field(array(
    'type'     => 'number',
    'settings' => "woocommerce_cross_sell_list_item_tablet_cols",
    'label'    => esc_html__('Cross-sell products per row on tablet', 'materialis'),
    'section'  => 'materialis_woocommerce_product_list',
    'default'  => 2,
    'choices'  => array(
        'min'  => 2,
        'max'  => 6,
        'step' => 1,
    ),
    'priority' => '70',
));


add_filter('cloudpress\customizer\global_data', function ($data) {

    $key = wp_create_nonce('materialis_woocommerce_api_nonce');
    set_theme_mod('materialis_woocommerce_api_nonce', $key);

    if ( ! isset($_REQUEST['materialis_woocommerce_api_nonce'])) {
        $data['materialis_woocommerce_api_nonce'] = $key;
    }

    return $data;
});

materialis_add_kirki_field(array(
    'type'     => 'sectionseparator',
    'label'    => esc_html__('Shop Header Settings', 'materialis'),
    'settings' => "woocommerce_shop_header_separator_options",
    'section'  => 'materialis_woocommerce_general_options',

));

materialis_add_kirki_field(array(
    'type'     => 'checkbox',
    'settings' => 'woocommerce_cart_display_near_menu',
    'label'    => esc_html__('Show cart button in menu', 'materialis'),
    'section'  => 'materialis_woocommerce_general_options',
    'default'  => true,
));


materialis_add_kirki_field(array(
    'type'     => 'select',
    'settings' => 'woocommerce_header_type',
    'label'    => esc_html__('Shop header', 'materialis'),
    'section'  => 'materialis_woocommerce_general_options',
    'default'  => 'default',
    'choices'  => apply_filters('materialis_woocommerce_shop_header_type_choices', array(
        "default" => esc_html__("Large header with title", "materialis"),
        "small"   => esc_html__("Navigation only", "materialis"),
    )),
));


materialis_add_kirki_field(array(
    'type'     => 'select',
    'settings' => 'woocommerce_product_header_type',
    'label'    => esc_html__('Product detail header', 'materialis'),
    'section'  => 'materialis_woocommerce_general_options',
    'default'  => 'default',
    'choices'  => apply_filters('materialis_woocommerce_shop_header_type_choices', array(
        "default" => esc_html__("Large header with title", "materialis"),
        "small"   => esc_html__("Navigation only", "materialis"),
    )),
));


materialis_add_kirki_field(array(
    'type'            => 'checkbox',
    'settings'        => 'woocommerce_product_header_image',
    'label'           => esc_html__('Set shop/product featured image as header background', 'materialis'),
    'description'     => esc_html__('Must have inner pages hero background set to image, and shop page and/or product featured image added.', 'materialis'),
    'section'         => 'materialis_woocommerce_general_options',
    'default'         => true,
    'active_callback' => array(
        array(
            'setting'  => 'woocommerce_product_header_type',
            'operator' => '!=',
            'value'    => 'small',
        ),
    ),
));


add_filter("materialis_inner_header_background_type", function ($type) {
    if (materialis_is_woocommerce_product_page() && get_theme_mod("woocommerce_product_header_image", true)) {
        return "image";
    }

    return $type;
}, 1);
