<?php

require_once get_template_directory() . "/inc/woocommerce/index.php";

function materialis_is_woocommerce()
{
    return function_exists('is_woocommerce') && (is_woocommerce() || is_cart() || is_checkout() || is_account_page());
}

function materialis_is_woocommerce_product_page()
{
    return function_exists('is_woocommerce') && is_product();
}

add_filter("inner_header_show_subtitle", function ($value) {
    $is_woocommerce = materialis_is_woocommerce();

    return $value && ! $is_woocommerce;
});
add_action('after_setup_theme', 'materialis_add_woocommerce_support');
function materialis_add_woocommerce_support()
{
    add_theme_support('woocommerce');


    /* WooCommerce support for latest gallery */
    if (class_exists('WooCommerce')) {
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
    }
}

function materialis_woocommerce_register_sidebars()
{

    $woo_sidebars_defaults = array(
        'before_widget' => '<div id="%1$s" class="widget %2$s mdc-elevation--z5">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="widgettitle"><i class="mdi widget-icon"></i>',
        'after_title'   => '</h5>',
    );

    register_sidebar(array_merge(array(
        'name'          => esc_html__('WooCommerce Left Sidebar', 'materialis'),
        'id'            => "ope_pro_woocommerce_sidebar_left",
        'title'         => "'WooCommerce Left Sidebar",
    ), $woo_sidebars_defaults));

    register_sidebar(array_merge(array(
        'name'          => esc_html__('WooCommerce Right Sidebar', 'materialis'),
        'id'            => "ope_pro_woocommerce_sidebar_right",
        'title'         => "'WooCommerce Right Sidebar",
    ), $woo_sidebars_defaults));

}

add_action('widgets_init', 'materialis_woocommerce_register_sidebars');


add_filter('woocommerce_enqueue_styles', 'materialis_woocommerce_enqueue_styles');

function materialis_woocommerce_enqueue_styles($woo)
{
    $version = materialis_get_version();


    $styles = array(
        'materialis-woo' => array(
            'src'     => get_template_directory_uri() . "/woocommerce.css",
            'deps'    => array('woocommerce-general'),
            'version' => $version,
            'media'   => 'all',
            'has_rtl' => false,
        ),
    );

    // wp_enqueue_style('fancybox', materialis_pro_uri( "/assets/css/jquery.fancybox.min.css") , array(), $version);
    // wp_enqueue_script('fancybox', materialis_pro_uri( "/assets/js/jquery.fancybox.min.js"), array("jquery"), $version);

    return array_merge($woo, $styles);
}


function materialis_woocommerce_get_sidebar($slug)
{
    $is_enabled = get_theme_mod("materialis_woocommerce_is_sidebar_{$slug}_enabled", true);

    if ($is_enabled) {
        get_sidebar("woocommerce-{$slug}");
    }
}

function materialis_woocommerce_container_class($echo = true)
{
    $class = array();

    $is_left_sb_enabled  = is_active_sidebar('ope_pro_woocommerce_sidebar_left');
    $is_right_sb_enabled = is_active_sidebar("ope_pro_woocommerce_sidebar_right");
    $sidebars            = intval($is_left_sb_enabled) + intval($is_right_sb_enabled);

    if (is_archive()) {
        $class = array("enabled-sidebars-{$sidebars}");
    }

    $class = apply_filters('materialis_woocommerce_container_class', $class);

    if ($echo) {
        echo implode(" ", $class);;
    }

    return implode(" ", $class);
}


function materialis_woocommerce_container_class_hide_title($classes)
{
    if (materialis_is_woocommerce_product_page()) {
        $template = get_theme_mod("materialis_woocommerce_product_header_type", "default");
        if ($template == "default") {
            array_push($classes, "no-title");
        }
    }

    return $classes;
}

add_filter('materialis_woocommerce_container_class', 'materialis_woocommerce_container_class_hide_title');


add_action('wp_enqueue_scripts', function () {
    $ver = materialis_get_version();
    wp_enqueue_script('materialis-woocommerce', get_template_directory_uri() . "/assets/js/woo.js", array('jquery'), $ver);
});


add_filter('materialis_header_title', function ($title) {

    if (materialis_is_page_template()) {
        if (is_archive() && materialis_get_current_template() === "woocommerce.php") {
            $title = woocommerce_page_title(false);
        }
    }

    return $title;
});

function materialis_navigation_sticky_attrs_always($atts)
{
    if (materialis_is_woocommerce()) {
        $atts["data-sticky-always"] = 1;
    }

    return $atts;
}

add_action('materialis_before_header', function ($template) {
    if ($template == "small") {
        add_filter("materialis_navigation_sticky_attrs", "materialis_navigation_sticky_attrs_always");
    }
});

add_filter('materialis_header', 'materialis_get_header_woocommerce', 10, 2);

function materialis_get_header_woocommerce($template)
{

    global $post;
    $header = false;

    if ($post) {
        $header = get_post_meta($post->ID, 'materialis_post_header', true);
    }

    if ( ! $header) {
        $header = $template;
    }

    if (materialis_is_woocommerce()) {
        $setting = "woocommerce_header_type";
        if (materialis_is_woocommerce_product_page()) {
            $setting = "woocommerce_product_header_type";
        }

        $template = get_theme_mod($setting, "default");
        if ($template == "default") {
            $template = "";
        }
    }

    return $template;
}


add_filter('woocommerce_show_page_title', '__return_false');


add_filter('woocommerce_cross_sells_total', 'materialis_cross_sells_product_no');

function materialis_cross_sells_product_no($columns)
{
    $result = get_theme_mod('woocommerce_cross_sells_product_no', 4);

    return absint($result);
}


add_action('woocommerce_before_shop_loop', 'materialis_woocommerce_cart_button', 5);

function materialis_woocommerce_cart_button()
{

    $fragments = opr_woo_cart_button(array());
    ?>
    <div class="cart-contents-content">
        <h4><?php echo __('Cart Content: ', 'materialis'); ?></h4>
        <?php echo $fragments['a.cart-contents']; ?>
        <?php woocommerce_breadcrumb(); ?>
    </div>
    <?php
}

add_filter('woocommerce_add_to_cart_fragments', 'opr_woo_cart_button');

function opr_woo_cart_button($fragments)
{
    global $woocommerce;
    ob_start();
    ?>

    <a class="cart-contents button" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'materialis'); ?>">
        <i class="mdi mdi-cart"></i>
        <?php
        echo
            /* translators: %d is number of items */
        sprintf(_n('%d item', '%d items', absint($woocommerce->cart->cart_contents_count), 'materialis'), absint($woocommerce->cart->cart_contents_count)); ?> - <?php echo wp_kses($woocommerce->cart->get_cart_total(), array(
            'span' => array(
                'class' => array(),
            ),
        )); ?></a>
    <?php
    $fragments['a.cart-contents'] = ob_get_clean();

    return $fragments;
}

add_action('woocommerce_before_single_product_summary', 'woocommerce_breadcrumb', 5, 0);

add_filter('materialis_override_with_thumbnail_image', function ($value) {

    global $product;

    if (isset($product)) {
        $value = get_theme_mod('woocommerce_product_header_image', true);

        $value = (intval($value) === 1);

    }

    return $value;
});


add_filter('materialis_overriden_thumbnail_image', function ($url) {
    global $post;


    if (function_exists('is_shop') && is_shop()) {
        $page_id = wc_get_page_id('shop');
        $url     = get_the_post_thumbnail_url($page_id);
    }

    return $url;
});

add_filter('woocommerce_rest_check_permissions', function ($permission, $context, $n, $object) {

    $nonce        = isset($_REQUEST['materialis_woocommerce_api_nonce']) ? $_REQUEST['materialis_woocommerce_api_nonce'] : '';
    $isNonceValid = is_materialis_woocommerce_api_key_valid($nonce);
    if ($isNonceValid && $context === "read") {
        {
            return true;
        }
    }

    return $permission;

}, 10, 4);


function materialis_woocommerce_query_maybe_add_category_args($args, $category, $operator = "IN")
{
    if ( ! empty($category)) {
        if (empty($args['tax_query'])) {
            $args['tax_query'] = array();
        }
        $args['tax_query'][] = array(
            array(
                'taxonomy' => 'product_cat',
                'terms'    => array_map('sanitize_title', explode(',', $category)),
                'field'    => 'id',
                'operator' => $operator,
            ),
        );
    }

    return $args;
}

function materialis_woocommerce_query_maybe_add_tags_args($args, $tag, $operator = "IN")
{
    if ( ! empty($tag)) {
        if (empty($args['tax_query'])) {
            $args['tax_query'] = array();
        }
        $args['tax_query'][] = array(
            array(
                'taxonomy' => 'product_tag',
                'terms'    => array_map('sanitize_title', explode(',', $tag)),
                'field'    => 'id',
                'operator' => $operator,
            ),
        );
    }

    return $args;
}


add_filter('body_class', 'materialis_wc_body_class', 20);

function materialis_wc_body_class($classes)
{
    global $post;

    if (in_array('woocommerce', $classes)) {
        $classes[] = 'page';
    }


    return $classes;
}


add_filter('wc_add_to_cart_message_html', function ($message) {
    if ('yes' !== get_option('woocommerce_cart_redirect_after_add')) {
        $message = str_replace("</a>", "</a><p>", $message);
    }

    $message .= "</p>";

    return $message;
});


function materialis_woocommerce_get_size($cols)
{
    return (intval($cols) / 12 * 100);
}

function materialis_woocommerce_cols_css($sel, $cols)
{
    $size = (100 / intval($cols));

    return "" .
           "$sel {" .
           "-webkit-flex-basis: $size%;" .
           "-moz-flex-basis: $size%;" .
           "-ms-flex-preferred-size: $size%;" .
           "flex-basis: $size%;" .
           "max-width: $size%;" .
           "}";
}


add_action('wp_enqueue_scripts', 'materialis_woocommerce_print_layout');
function materialis_woocommerce_print_layout()
{
    
    $style = "";
    if (materialis_can_show_cached_value('materialis-woo-inline-css')) {
        $style = materialis_get_cached_value('materialis-woo-inline-css');
        $style = "/* cached */\n{$style}";
    } else {
        
    $list = array(
        "list"       => array(
            "sel"     => ".woocommerce ul.products li.product:not(.in-page-section)",
            "desktop" => get_theme_mod('woocommerce_list_item_desktop_cols', 4),
            "tablet"  => get_theme_mod('woocommerce_list_item_tablet_cols', 2),
        ),
        "related"    => array(
            "sel"     => ".woocommerce.single-product .related .products li.product",
            "desktop" => get_theme_mod('woocommerce_related_list_item_desktop_cols', 4),
            "tablet"  => get_theme_mod('woocommerce_related_list_item_tablet_cols', 2),
        ),
        "upsell"     => array(
            "sel"     => ".woocommerce.single-product .upsells .products li.product",
            "desktop" => get_theme_mod('woocommerce_upsells_list_item_desktop_cols', 4),
            "tablet"  => get_theme_mod('woocommerce_upsells_list_item_tablet_cols', 2),
        ),
        "cross_sell" => array(
            "sel"     => ".woocommerce .cart-collaterals .cross-sells .products li.product",
            "desktop" => get_theme_mod('woocommerce_cross_sell_list_item_desktop_cols', 2),
            "tablet"  => get_theme_mod('woocommerce_cross_sell_list_item_tablet_cols', 2),
        ),
    );

    $style = "@media (min-width: 768px) {";
    foreach ($list as $key => $data) {
        $style .= "\n /** {$data['sel']} - {$data['tablet']} */\n";
        $style .= materialis_woocommerce_cols_css($data['sel'], $data['tablet']);
    }
    $style .= "}";

    $style .= "\n@media (min-width: 1024px) {";
    foreach ($list as $key => $data) {
        $style .= "\n /** {$data['sel']} - {$data['desktop']} */\n";
        $style .= materialis_woocommerce_cols_css($data['sel'], $data['desktop']);
    }
    $style .= "}";
        
        materialis_cache_value('materialis-woo-inline-css', $style);
    }

    wp_add_inline_style('materialis-woo', $style);
}


function materialis_compare_woocommerce_version($version, $operator)
{
    if (class_exists('WooCommerce')) {
        global $woocommerce;

        return version_compare($woocommerce->version, $version, $operator);
    }

    return false;
}

if ( ! defined('MATERIALIS_MIN_WOOCOMMERCE_VERSION')) {
    define('MATERIALIS_MIN_WOOCOMMERCE_VERSION', apply_filters('memerize_min_woocommerce_version', '3.2.0'));
}

add_action('admin_notices', 'materialis_woocommerce_version_notice');

function materialis_woocommerce_version_notice()
{
    if (materialis_compare_woocommerce_version(MATERIALIS_MIN_WOOCOMMERCE_VERSION, '>')) {
        return;
    }

    ?>
    <div class="notice notice-alt notice-error notice-large">
        <h4><?php _e('WooCommerce version outdated!', 'materialis'); ?></h4>
        <p>
            <?php _e('You need to update your <strong>WooCommerce plugin</strong> to use it with the <strong>Materialis theme</strong>.', 'materialis'); ?> <br/>
            <?php _e('<strong>Materialis theme</strong> requires the WooCommerce plugin version to be at least: ', 'materialis') ?> <strong><?php echo MATERIALIS_MIN_WOOCOMMERCE_VERSION; ?></strong>
        </p>
    </div>
    <?php
}
