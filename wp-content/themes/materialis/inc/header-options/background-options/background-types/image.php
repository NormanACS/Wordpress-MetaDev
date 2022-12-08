<?php


add_filter('materialis_header_background_types', 'materialis_header_background_image');

function materialis_header_background_image($types)
{
    $types['image'] = esc_html__('Image', 'materialis');

    return $types;
}

function materialis_override_inner_header_with_thumbnail_image_on_page($value)
{

    global $post;
    if ((isset($post) && $post->post_type === 'page')) {
        $value = materialis_get_theme_mod('inner_header_show_featured_image', true);
        $value = (intval($value) === 1);

    }

    return $value;
}

add_filter('materialis_override_with_thumbnail_image', 'materialis_override_inner_header_with_thumbnail_image_on_page');


function materialis_override_inner_header_with_thumbnail_image_on_post($value)
{

    global $post;

    if (isset($post) && $post->post_type === 'post') {
        $value = materialis_get_theme_mod('blog_show_post_featured_image', true);
        $value = (intval($value) === 1);

    }

    return $value;
}

add_filter('materialis_override_with_thumbnail_image', 'materialis_override_inner_header_with_thumbnail_image_on_post');


function materialis_header_background_atts_image_filter($attrs, $bg_type, $inner)
{


    if ($bg_type == 'image') {
        $prefix        = $inner ? "inner_header" : "header";
        $bgImage       = $inner ? get_header_image() : materialis_get_theme_mod($prefix . '_front_page_image', materialis_mod_default($prefix . '_front_page_image'));
        $bgImageMobile = $inner ? get_header_image() : materialis_get_theme_mod($prefix . '_front_page_image_mobile', false);

        $bgColor = materialis_get_theme_mod($prefix . '_bg_color_image', "#6a73da");

        if ($inner && apply_filters('materialis_override_with_thumbnail_image', false)) {
            global $post;
            if ($post) {
                $thumbnail = get_the_post_thumbnail_url($post->ID, 'materialis-full-hd');

                $thumbnail = apply_filters('materialis_overriden_thumbnail_image', $thumbnail);

                if ($thumbnail) {
                    $bgImage = $thumbnail;
                }
            }
        }

        $attrs['style'] .= '; background-image:url("' . materialis_esc_url($bgImage) . '")';
        $attrs['style'] .= '; background-color:' . $bgColor;

        if ($bgImageMobile) {
            $attrs['class'] = isset($attrs['class']) ? $attrs['class'] . " custom-mobile-image " : "custom-mobile-image ";
        }

        $parallax = materialis_get_theme_mod($prefix . "_parallax");
        if ($parallax) {
            $attrs['data-parallax-depth'] = "20";
        }
    }

    return $attrs;
}

add_filter("materialis_header_background_atts", 'materialis_header_background_atts_image_filter', 1, 3);


function materialis_header_background_mobile_image()
{
    $inner = materialis_is_inner(true);

    if ($inner) {
        return;
    }

    $prefix                 = $inner ? "inner_header" : "header";
    $bgType                 = materialis_get_theme_mod($prefix . '_background_type', $inner ? 'gradient' : 'image');
    $bgImageMobile          = $inner ? get_header_image() : materialis_get_theme_mod($prefix . '_front_page_image_mobile', false);
    $bgMobilePosition       = (strpos(materialis_get_theme_mod($prefix . "_bg_position_mobile", '50%'), '%') !== false) ? materialis_get_theme_mod($prefix . "_bg_position_mobile", '50%') : (materialis_get_theme_mod($prefix . "_bg_position_mobile", '50') . '%');
    $bgMobilePositionOffset = materialis_get_theme_mod($prefix . "_bg_position_mobile_offset", '0');

    $bgMobilePosition = $bgMobilePosition . " " . $bgMobilePositionOffset . "px";

    if ($bgType === "image"):
        ?>
        <style type="text/css" data-name="custom-mobile-image-position">
            @media screen and (max-width: 767px) {
                /*Custom mobile position*/
            <?php echo $inner ? '.header' : '.header-homepage' ?> {
                background-position: <?php echo  esc_attr($bgMobilePosition) ?> !important;
            }
            }
        </style>

        <style type="text/css" data-name="custom-mobile-image">
            /*Custom mobile image*/
            <?php if($bgImageMobile): ?>
            @media screen and (max-width: 767px) {
                .custom-mobile-image {
                    background-image: url(<?php echo esc_url_raw(  $bgImageMobile) ?>) !important;
                }

            <?php endif; ?>
            }

        </style>
    <?php
    endif;
}

add_action('wp_head', 'materialis_header_background_mobile_image');

add_action("materialis_header_background_type_settings", 'materialis_header_background_type_image_settings', 1, 6);

function materialis_header_background_type_image_settings($section, $prefix, $group, $inner, $priority)
{
    $prefix  = $inner ? "inner_header" : "header";
    $section = $inner ? "header_image" : "header_background_chooser";

    $group = "{$prefix}_bg_options_group_button";

    /* image settings */

    materialis_add_kirki_field(array(
        'type'            => 'sectionseparator',
        'label'           => esc_html__('Image Background Options', 'materialis'),
        'section'         => $section,
        'settings'        => $prefix . '_image_background_options_separator',
        'priority'        => 2,
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_background_type',
                'operator' => '==',
                'value'    => 'image',
            ),
        ),
        'group'           => $group,
    ));

    if ( ! $inner) {
        materialis_add_kirki_field(array(
            'type'              => 'image',
            'settings'          => $prefix . '_front_page_image',
            'label'             => esc_html__('Header Image', 'materialis'),
            'section'           => $section,
            'sanitize_callback' => 'esc_url_raw',
            'default'           => materialis_mod_default($prefix . '_front_page_image'),
            "priority"          => 2,
            'group'             => $group,
            'active_callback'   => array(
                array(
                    'setting'  => $prefix . '_background_type',
                    'operator' => '==',
                    'value'    => 'image',
                ),
            ),
        ));

    }

    materialis_add_kirki_field(array(
        'type'            => 'select',
        'settings'        => $prefix . '_bg_position',
        'label'           => esc_html__('Background Position', 'materialis'),
        'section'         => $section,
        'priority'        => 2,
        'default'         => "center bottom",
        'choices'         => array(
            "left top"    => "left top",
            "left center" => "left center",
            "left bottom" => "left bottom",

            "center top"    => "center top",
            "center center" => "center center",
            "center bottom" => "center bottom",

            "right top"    => "right top",
            "right center" => "right center",
            "right bottom" => "right bottom",

        ),
        "output"          => array(
            array(
                'element'  => $inner ? '.header' : '.header-homepage',
                'property' => 'background-position',
            ),
        ),
        'transport'       => 'postMessage',
        'js_vars'         => array(
            array(
                'element'  => $inner ? '.header' : '.header-homepage',
                'property' => 'background-position',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_background_type',
                'operator' => '==',
                'function' => 'style',
                'value'    => 'image',
            ),
        ),
        'group'           => $group,
    ));


    materialis_add_kirki_field(array(
        'type'      => 'color',
        'label'     => esc_html__('Background Color', 'materialis'),
        'section'   => $section,
        'priority'  => 2,
        'settings'  => $prefix . '_bg_color_image',
        'default'   => '#6a73da',
        'transport' => 'postMessage',

        'choices' => array(
            'alpha' => true,
        ),

        'active_callback' => array(
            array(
                'setting'  => $prefix . '_background_type',
                'operator' => '==',
                'value'    => 'image',
            ),
        ),
        'js_vars'         => array(
            array(
                'element'  => $inner ? '.header' : '.header-homepage',
                'property' => 'background-color',
                'suffix'   => ' !important',
            ),
        ),
        'group'           => $group,
    ));

    if ($inner) {
        materialis_add_kirki_field(array(
            'type'            => 'checkbox',
            'settings'        => $prefix . '_show_featured_image',
            'label'           => esc_html__('Show page featured image when available', 'materialis'),
            'section'         => $section,
            'priority'        => 3,
            'default'         => true,
            'active_callback' => array(
                array(
                    'setting'  => $prefix . '_background_type',
                    'operator' => '==',
                    'value'    => 'image',
                ),
            ),
            'group'           => $group,
        ));

    }

    materialis_add_kirki_field(array(
        'type'            => 'checkbox',
        'settings'        => $prefix . '_parallax',
        'label'           => esc_html__('Enable parallax effect', 'materialis'),
        'section'         => $section,
        'priority'        => 3,
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_background_type',
                'operator' => '==',
                'value'    => 'image',
            ),
        ),
        'group'           => $group,
    ));


    if ( ! $inner) {


        materialis_add_kirki_field(array(
            'type'            => 'sectionseparator',
            'label'           => esc_html__('Mobile Image Background Options', 'materialis'),
            'section'         => $section,
            'settings'        => $prefix . '_image_mobile_background_options_separator',
            'priority'        => 2,
            'active_callback' => array(
                array(
                    'setting'  => $prefix . '_background_type',
                    'operator' => '==',
                    'value'    => 'image',
                ),
            ),
            'group'           => $group,
        ));

        materialis_add_kirki_field(array(
            'type'              => 'image',
            'settings'          => $prefix . '_front_page_image_mobile',
            'label'             => esc_html__('Mobile Only Image', 'materialis'),
            'description'       => esc_html__('Leave this field empty if you want to use the main image header image', 'materialis'),
            'section'           => $section,
            'sanitize_callback' => 'esc_url_raw',
            "priority"          => 2,
            'group'             => $group,
            'active_callback'   => array(
                array(
                    'setting'  => $prefix . '_background_type',
                    'operator' => '==',
                    'value'    => 'image',
                ),
            ),
        ));


        materialis_add_kirki_field(array(
            'type'     => 'select',
            'settings' => $prefix . '_bg_position_mobile',
            'label'    => esc_html__('Mobile Bg. Horizontal Position', 'materialis'),
            'section'  => $section,
            'priority' => 2,
            'default'  => "50%",
            'choices'  => array(
                "0%"   => "left",
                "50%"  => "center",
                "100%" => "right",
            ),

            'transport'       => 'postMessage',
            'active_callback' => array(
                array(
                    'setting'  => $prefix . '_background_type',
                    'operator' => '==',
                    'value'    => 'image',
                ),
            ),
            'group'           => $group,
        ));


        materialis_add_kirki_field(array(
            'type'      => 'slider',
            'label'     => esc_html__('Mobile Bg. Vertical Offset', 'materialis'),
            'section'   => $section,
            'priority'  => $priority,
            'settings'  => $prefix . '_bg_position_mobile_offset',
            'default'   => "0",
            'transport' => 'postMessage',
            'choices'   => array(
                'min'  => '-500',
                'max'  => '500',
                'step' => '1',
            ),

            'js_vars' => array(
                array(
                    'element'  => '.materialis-fake-selector',
                    'property' => 'backgroun-position-t',
                ),
            ),

            'active_callback' => array(
                array(
                    'setting'  => $prefix . '_background_type',
                    'operator' => '==',
                    'value'    => 'image',
                ),
            ),
            'group'           => $group,
        ));


    }


    add_filter($group . "_filter", function ($settings) use ($prefix) {

        $new_settings = array(
            "_parallax_pro",
        );

        foreach ($new_settings as $key => $value) {
            $settings[] = $prefix . $value;
        }

        return $settings;
    });

}

function materialis_overriden_thumbnail_image_main_filter($url)
{
    $blogPage          = get_option('page_for_posts');
    $blogPageURL       = $url;
    $modValue          = materialis_get_theme_mod('blog_show_post_featured_image', true);
    $enabledOnPostPage = (intval($modValue) === 1);

    if ($blogPage) {
        $blogPageURL = get_the_post_thumbnail_url(intval($blogPage), 'materialis-full-hd');
    }

    if (materialis_is_blog()) {
        if (is_single() && $enabledOnPostPage) {
            $url = get_the_post_thumbnail_url(get_the_ID(), 'materialis-full-hd');

            if (empty($url)) {
                $url = $blogPageURL;
            }

        } else {
            $url = $blogPageURL;
        }
    }

    return $url;
}

add_filter('materialis_overriden_thumbnail_image', 'materialis_overriden_thumbnail_image_main_filter');
