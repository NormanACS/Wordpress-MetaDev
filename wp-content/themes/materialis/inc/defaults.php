<?php
function materialis_current_default_slug() {
    return "dark-purple";
}

function materialis_theme_defaults() {

    $gradients = materialis_get_parsed_gradients();

    $defaults = array(

        'header_element_background_color'            => 'rgba(255,255,255,0.7)',
        'header_element_background_border_thickness' => array(
            'top'    => '0px',
            'bottom' => '0px',
            'left'   => '0px',
            'right'  => '0px',
        ),

        'header_element_background_spacing'             => array(
            'top'    => '10px',
            'bottom' => '10px',
            'left'   => '10px',
            'right'  => '10px',
        ),
        'header_element_background_border_color'        => '#8D99AE',
        'header_content_subtitle_background_enabled'    => false,
        'header_content_subtitle_background_color'      => 'rgba(0,0,0,1)',
        'header_content_subtitle_background_spacing'    => array(
            'top'    => '10px',
            'bottom' => '10px',
            'left'   => '10px',
            'right'  => '10px',
        ),
        'header_nav_transparent'                        => true,
        'inner_header_nav_transparent'                  => true,
        'header_slideshow'                              => array(
            array(
                'url' => esc_url(get_template_directory_uri()) . '/assets/images/slideshow_slide1.jpg',
            ),
            array(
                'url' => esc_url(get_template_directory_uri()) . '/assets/images/slideshow_slide2.jpg',
            ),
        ),
        'inner_header_slideshow'                        => array(
            array(
                'url' => esc_url(get_template_directory_uri()) . '/assets/images/slideshow_slide1.jpg',
            ),
            array(
                'url' => esc_url(get_template_directory_uri()) . '/assets/images/slideshow_slide2.jpg',
            ),
        ),
        'header_content_buttons'                        => array(
            array(
                'label'  => __( 'Action Button 1', 'materialis' ),
                'url'    => '#',
                'target' => '_self',
                'class'  => 'button btn-default big color2 mdc-elevation--z3',
            ),
            array(
                'label'  => __( 'Action Button 2', 'materialis' ),
                'url'    => '#',
                'target' => '_self',
                'class'  => 'button btn-default big white outline mdc-elevation--z3',
            ),
        ),
        'header_front_page_image'                       => esc_url(get_template_directory_uri()) . '/assets/images/header-bg-image-default.jpg',
        'header_nav_border'                             => false,
        'header_show_overlay'                           => true,
        'header_overlay_type'                           => 'color',
        'header_content_show_subtitle2'                 => false,
        'header_content_show_subtitle'                  => true,
        'header_content_partial'                        => 'content-on-center',
        'header_spacing'                                => array(
            'top'    => '20%',
            'bottom' => '24%',
        ),
        'header_bg_position'                            => "center bottom",
        'header_text_box_text_align'                    => 'center',
        'header_content_subtitle2_background_enabled'   => false,
        'header_content_title_background_enabled'       => false,
        'header_content_title_background_color'         => 'rgba(255,255,255,0.7)',
        'header_parallax'                               => true,
        'header_content_title_background_border_radius' => '8px',
        'header_overlay_color'                          => materialis_get_theme_colors( "color1" ),
        'header_overlay_opacity'                        => '0.7',
        'header_content_title_background_spacing'       => array(
            'top'    => '15px',
            'bottom' => '15px',
            'left'   => '30px',
            'right'  => '30px',
        ),
        'header_content_title_background_shadow'        => '0',
        'header_nav_border_thickness'                   => '2',
        'header_element_background_shadow'              => '0',
        'header_text_box_text_width'                    => '85',
        'header_title_color'                            => '#ffffff',
        'inner_header_bg_position'                      => "center center",
        'inner_header_parallax'                         => false,
        'inner_header_show_overlay'                     => true,
        'inner_header_overlay_color'                    => materialis_get_theme_colors( "color1" ),
        'inner_header_overlay_opacity'                  => '0.7',
        'inner_header_background_type'                  => 'image',
        'inner_header_bg_color'                         => '#228AE6',
        'inner_header_gradient'                         => 'plum_plate',
        'inner_header_text_align'                       => 'center',
        'inner_header_spacing'                          => array(
            'top'    => '10%',
            'bottom' => '10%',
        ),
        'inner_header_nav_border'                       => false,
        'inner_header_show_separator'                   => false,
        'inner_header_separator_color'                  => 'rgb(248,248,248)',
        'inner_header_separator_height'                 => '25',
        'inner_header_separator'                        => 'tilt',
        'inner_header_overlay_type'                     => 'color',
        'header_overlay_gradient_colors'                => $gradients['easter_blueberry'],
        'inner_header_overlay_gradient_colors'          => $gradients['easter_blueberry'],
        'inner_header_overlay_shape'                    => 'none',
        'header_overlay_shape'                          => 'none',
        'blog_use_homepage_header'                      => false,

    );

    $defaults = apply_filters( 'materialis_defaults', $defaults );

    return $defaults;
}

function materialis_is_modified() {
    $mods = get_theme_mods();
    $keys = array_keys( $mods );
    foreach ( $keys as $value ) {
        $value = strval( $value );
        if ( strpos( "header", $value ) !== false ) {
            return true;
        }
    }

    return false;
}


function materialis_current_default_is( $default ) {

        $mod = get_theme_mod( 'theme_default_preset', false );

        return ( $default === $mod );
}

function materialis_after_switch_theme_set_defaults_version() {
    $default_preset = get_theme_mod( 'theme_default_preset', false );
    if ( ! $default_preset && ! materialis_is_modified() ) {
        set_theme_mod( 'theme_default_preset', materialis_current_default_slug() );
    }

    materialis_clear_cached_values();
}

add_action( 'after_switch_theme', 'materialis_after_switch_theme_set_defaults_version' );
