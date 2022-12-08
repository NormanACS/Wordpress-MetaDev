<?php

function materialis_get_column_width_kirki_output($selector, $args = array(), $js_vars = false)
{

    $result = array();
    $base   = array_merge(array(
        "element"     => $selector,
        "property"    => null,
        "units"       => "%",
        "media_query" => null,
    ), $args);

    $props = array(
        "-webkit-flex-basis",
        "-moz-flex-basis",
        "-ms-flex-preferred-size",
        "flex-basis",
        "max-width",
        "width",
    );


    if ($js_vars) {
        $propData = array_merge($base,
            array(
                'property' => implode(',', $props),
                'function' => 'style',
            )
        );

        $result[] = $propData;
    } else {

        foreach ($props as $prop) {
            $propData = array_merge($base,
                array(
                    "property" => $prop,
                ));


            $result[] = $propData;
        }
    }

    return $result;
}


function materialis_header_media_box_vertical_align()
{
    return array(
        'top-sm'    => esc_html__('Top', 'materialis'),
        'middle-sm' => esc_html__('Middle', 'materialis'),
        'bottom-sm' => esc_html__('Bottom', 'materialis'),
    );
}


function materialis_hero_media_vertical_align($align)
{
    $value = materialis_get_theme_mod('header_media_box_vertical_align', $align);
    if ( ! array_key_exists($value, materialis_header_media_box_vertical_align())) {
        $value = $align;
    }

    return $value;
}


function materialis_hero_content_vertical_align($align_class)
{
    return materialis_get_theme_mod('header_text_box_text_vertical_align', $align_class);
}


function materialis_header_description_classes($classes)
{

    if (get_theme_mod('header_content_fullwidth', false)) {
        $classes = array_diff($classes, array('gridContainer'));
    }

    return $classes;
}

function materialis_front_page_header_media_box_options($section, $prefix, $priority)
{

    $group = "header_media_box_settings";

    materialis_add_kirki_field(array(
        'type'            => 'sidebar-button-group',
        'settings'        => $group,
        'label'           => esc_html__('Media box settings', 'materialis'),
        'section'         => $section,
        'priority'        => $priority,
        'active_callback' => array(
            array(
                'setting'  => 'header_content_partial',
                'operator' => 'contains',
                'value'    => 'media',
            ),
        ),
    ));

    materialis_add_kirki_field(array(
        'type'     => 'sectionseparator',
        'label'    => esc_html__('Media Box Settings', 'materialis'),
        'section'  => $section,
        'settings' => 'header_media_box_media_separator',
        'priority' => $priority,
        'group'    => $group,
    ));

    materialis_add_kirki_field(array(
        'type'     => 'slider',
        'settings' => 'header_media_box_top_bottom_width',
        'label'    => esc_html__('Media width', 'materialis'),
        'choices'  => array(
            'min'  => '0',
            'max'  => '100',
            'step' => '1',
        ),

        'default' => 50,

        'transport' => 'postMessage',
        'section'   => $section,
        'priority'  => $priority,
        'group'     => $group,

        'output' => array(
            array(
                'element'     => '.media-on-bottom .header-media-container, .media-on-top .header-media-container',
                'property'    => 'width',
                'units'       => '%',
                'media_query' => '@media only screen and (min-width: 768px)',
            ),
        ),

        'js_vars' => array(
            array(
                'element'     => '.media-on-bottom .header-media-container, .media-on-top .header-media-container',
                'property'    => 'width',
                'function'    => 'css',
                'units'       => '%',
                'media_query' => '@media only screen and (min-width: 768px)',
            ),
        ),


        'active_callback' => array(
            array(
                'setting'  => 'header_content_partial',
                'operator' => 'in',
                'value'    => array('media-on-top', 'media-on-bottom'),
            ),
        ),
    ));


    materialis_add_kirki_field(array(
        'type'      => 'select',
        'settings'  => 'header_media_box_vertical_align',
        'label'     => esc_html__('Media Vertical Align', 'materialis'),
        'section'   => $section,
        'default'   => 'middle-sm',
        'transport' => 'postMessage',
        'choices'   => materialis_header_media_box_vertical_align(),

        'active_callback' => array(
            array(
                'setting'  => 'header_content_partial',
                'operator' => 'in',
                'value'    => array('media-on-left', 'media-on-right'),
            ),
        ),

        'group' => $group,
    ));


    add_filter('materialis_hero_media_vertical_align', 'materialis_hero_media_vertical_align');

    materialis_add_kirki_field(array(
        'type'        => 'cropped_image',
        'settings'    => 'header_content_image',
        'label'       => esc_html__('Image', 'materialis'),
        'section'     => $section,
        'default'     => get_template_directory_uri() . "/assets/images/media-image-default.jpg",
        'height'      => '600',
        'width'       => '420',
        'flex_height' => true,
        'flex_width'  => true,

        'active_callback' => array(
            array(
                'setting'  => 'header_content_media',
                'operator' => 'in',
                'value'    => array('image'),
            ),
        ),
        "group"           => $group,
    ));

    materialis_add_kirki_field(array(
        'type'     => 'slider',
        'label'    => esc_html__('Image width', 'materialis'),
        'section'  => $section,
        'settings' => 'header_column_width',

        'choices' => array(
            'min'  => '0',
            'max'  => '100',
            'step' => '1',
        ),

        'default' => 29,

        'transport' => 'postMessage',

        "output" => array_merge(
            materialis_get_column_width_kirki_output(".header-hero-media",
                array(
                    "media_query" => "@media only screen and (min-width: 768px)",
                )
            ),
            materialis_get_column_width_kirki_output(".header-hero-content",
                array(
                    'prefix'      => 'calc(100% - ',
                    'suffix'      => ')!important',
                    "media_query" => "@media only screen and (min-width: 768px)",
                )
            )
        ),

        "js_vars"         => array_merge(
            materialis_get_column_width_kirki_output(".header-hero-media",
                array(
                    "media_query" => "@media only screen and (min-width: 768px)",
                ),
                true
            ),
            materialis_get_column_width_kirki_output(".header-hero-content",
                array(
                    'prefix'      => 'calc(100% - ',
                    'suffix'      => ')!important',
                    "media_query" => "@media only screen and (min-width: 768px)",
                ),
                true
            )
        ),
        'active_callback' => array(
            array(
                'setting'  => 'header_content_partial',
                'operator' => 'in',
                'value'    => array('media-on-left', 'media-on-right'),
            ),
        ),
        "group"           => $group,
    ));


    materialis_add_kirki_field(array(
        'type'      => 'spacing',
        'settings'  => 'header_content_media_spacing',
        'label'     => esc_html__('Media Box Spacing', 'materialis'),
        'section'   => $section,
        'default'   => array(
            'top'    => '0px',
            'bottom' => '0px',
        ),
        'transport' => 'postMessage',
        'output'    => array(
            array(
                'element'  => '.header-description-bottom.media, .header-description-top.media',
                'property' => 'margin',
            ),
        ),
        'js_vars'   => array(
            array(
                'element'  => '.header-description-bottom.media, .header-description-top.media',
                'function' => 'style',
                'property' => 'margin',
            ),
        ),

        'active_callback' => array(
            array(
                'setting'  => 'header_content_partial',
                'operator' => 'in',
                'value'    => array('media-on-top', 'media-on-bottom'),
            ),
        ),

        "group" => $group,
    ));
}

function materialis_get_medias_with_frame()
{
    return apply_filters("materialis_get_medias_with_frame", array('media-on-left', 'media-on-right', 'media-on-top', 'media-on-bottom'));
}

function materialis_front_page_header_frame_options($section, $prefix, $priority)
{

    $group = "header_media_box_settings";

    $media_with_frame = materialis_get_medias_with_frame();

    $active_callback = array(
        array(
            'setting'  => 'header_content_media',
            'operator' => 'in',
            'value'    => array('image'),
        ),

        array(
            'setting'  => 'header_content_partial',
            'operator' => 'in',
            'value'    => $media_with_frame,
        ),

        array(
            'setting'  => 'header_content_frame_type',
            'operator' => 'in',
            'value'    => array('border', 'background'),
        ),


    );

    materialis_add_kirki_field(array(
        'type'            => 'sectionseparator',
        'label'           => esc_html__('Frame Options', 'materialis'),
        'section'         => $section,
        'settings'        => $prefix . 'header_content_frame_separator',
        'priority'        => $priority,
        'group'           => $group,
        'active_callback' => array(
            array(
                'setting'  => 'header_content_media',
                'operator' => 'in',
                'value'    => array('image'),
            ),
        ),
    ));

    materialis_add_kirki_field(array(
        'type'              => 'select',
        'settings'          => 'header_content_frame_type',
        'label'             => esc_html__('Frame Type', 'materialis'),
        'section'           => $section,
        'choices'           => apply_filters('materialis_header_header_content_frame_types', array(
            "none"       => esc_html__("None", 'materialis'),
            "background" => esc_html__("Background", 'materialis'),
            "border"     => esc_html__("Border", 'materialis'),
        )),
        'default'           => 'border',
        'sanitize_callback' => 'sanitize_text_field',
        'priority'          => $priority,
        "group"             => $group,
        'active_callback'   => array(
            array(
                'setting'  => 'header_content_media',
                'operator' => 'in',
                'value'    => array('image'),
            ),
        ),
    ));

    materialis_add_kirki_field(array(
        'type'     => 'slider',
        'label'    => esc_html__('Width', 'materialis'),
        'section'  => $section,
        'settings' => 'header_content_frame_width',
        'priority' => $priority,
        'choices'  => array(
            'min'  => '0',
            'max'  => '200',
            'step' => '1',
        ),

        'default' => 100,

        'transport' => 'postMessage',

        'active_callback' => $active_callback,
        "group"           => $group,
    ));

    materialis_add_kirki_field(array(
        'type'     => 'slider',
        'label'    => esc_html__('Height', 'materialis'),
        'section'  => $section,
        'settings' => 'header_content_frame_height',
        'priority' => $priority,
        'choices'  => array(
            'min'  => '0',
            'max'  => '200',
            'step' => '1',
        ),

        'default' => 100,

        'transport' => 'postMessage',

        'active_callback' => $active_callback,
        "group"           => $group,
    ));

    materialis_add_kirki_field(array(
        'type'     => 'slider',
        'label'    => esc_html__('Offset left', 'materialis'),
        'section'  => $section,
        'settings' => 'header_content_frame_offset_left',
        'priority' => $priority,
        'choices'  => array(
            'min'  => '-50',
            'max'  => '50',
            'step' => '1',
        ),

        'default' => -13,

        'transport' => 'postMessage',

        'active_callback' => $active_callback,
        "group"           => $group,
    ));

    materialis_add_kirki_field(array(
        'type'     => 'slider',
        'label'    => esc_html__('Offset top', 'materialis'),
        'section'  => $section,
        'settings' => 'header_content_frame_offset_top',
        'priority' => $priority,
        'choices'  => array(
            'min'  => '-50',
            'max'  => '50',
            'step' => '1',
        ),

        'default' => 10,

        'transport' => 'postMessage',

        'active_callback' => $active_callback,
        "group"           => $group,
    ));

    materialis_add_kirki_field(array(
        'type'     => 'slider',
        'label'    => esc_html__('Frame thickness', 'materialis'),
        'section'  => $section,
        'settings' => 'header_content_frame_thickness',
        'priority' => $priority,
        'choices'  => array(
            'min'  => '1',
            'max'  => '50',
            'step' => '1',
        ),

        'default' => 11,

        'transport' => 'postMessage',

        'active_callback' => array(
            array(
                'setting'  => 'header_content_media',
                'operator' => 'in',
                'value'    => array('image'),
            ),

            array(
                'setting'  => 'header_content_partial',
                'operator' => 'in',
                'value'    => $media_with_frame,
            ),

            array(
                'setting'  => 'header_content_frame_type',
                'operator' => 'in',
                'value'    => array('border'),
            ),


        ),
        "group"           => $group,
    ));

    materialis_add_kirki_field(array(
        'type'            => 'color',
        'label'           => esc_html__('Frame Color', 'materialis'),
        'section'         => $section,
        'priority'        => $priority,
        'settings'        => 'header_content_frame_color',
        'default'         => 'rgba(255,255,255,0.726)',
        'transport'       => 'postMessage',
        'choices'         => array('alpha' => true),
        'active_callback' => $active_callback,
        'group'           => $group,
    ));


    materialis_add_kirki_field(array(
        'type'      => 'checkbox',
        'label'     => esc_html__('Show frame over image', 'materialis'),
        'section'   => $section,
        'priority'  => $priority,
        'settings'  => 'header_content_frame_show_over_image',
        'default'   => false,
        'transport' => 'postMessage',

        'active_callback' => $active_callback,
        'group'           => $group,
    ));


    materialis_add_kirki_field(array(
        'type'      => 'checkbox',
        'label'     => esc_html__('Show frame shadow', 'materialis'),
        'section'   => $section,
        'priority'  => $priority,
        'settings'  => 'header_content_frame_shadow',
        'default'   => true,
        'transport' => 'postMessage',

        'active_callback' => $active_callback,
        'group'           => $group,
    ));

    materialis_add_kirki_field(array(
        'type'            => 'checkbox',
        'label'           => esc_html__('Hide frame on mobile', 'materialis'),
        'section'         => $section,
        'priority'        => $priority,
        'settings'        => 'header_content_frame_hide_on_mobile',
        'default'         => true,
        'transport'       => 'postMessage',
        'active_callback' => $active_callback,
        'group'           => $group,
    ));
}

function materialis_front_page_header_text_options()
{

    $priority = 5;

    $prefix  = "header";
    $section = "header_background_chooser";

    $group = "header_text_box_settings";

    materialis_add_kirki_field(array(
        'type'     => 'sidebar-button-group',
        'settings' => $group,
        'label'    => esc_html__('Text box settings', 'materialis'),
        'section'  => $section,
        'priority' => $priority,
    ));


    materialis_add_kirki_field(array(
        'type'     => 'sectionseparator',
        'label'    => esc_html__('Text settings', 'materialis'),
        'section'  => $section,
        'settings' => "header_text_box_text_separator",
        'priority' => $priority,
        'group'    => $group,
    ));

    materialis_add_kirki_field(array(
        'type'     => 'radio-buttonset',
        'label'    => esc_html__('Text Align', 'materialis'),
        'section'  => $section,
        'settings' => 'header_text_box_text_align',
        'default'  => materialis_mod_default('header_text_box_text_align'),
        'priority' => $priority,
        "choices"  => array(
            "left"   => esc_html__("Left", "materialis"),
            "center" => esc_html__("Center", "materialis"),
            "right"  => esc_html__("Right", "materialis"),
        ),

        'transport' => 'postMessage',
        'group'     => $group,
    ));


    materialis_add_kirki_field(array(
        'type'     => 'slider',
        'label'    => esc_html__('Text Width', 'materialis'),
        'section'  => $section,
        'settings' => 'header_text_box_text_width',
        'priority' => $priority,
        'choices'  => array(
            'min'  => '0',
            'max'  => '100',
            'step' => '1',
        ),

        'default'   => materialis_mod_default("header_text_box_text_width"),
        'transport' => 'postMessage',

        "js_vars" => array(
            array(
                "element"  => ".header-content .align-holder",
                "function" => "css",
                "property" => "width",
                'suffix'   => '!important',
                "units"    => "%",
            ),
        ),

        "output" => array(
            array(
                "element"     => ".header-content .align-holder",
                "property"    => "width",
                'suffix'      => '!important',
                "units"       => "%",
                "media_query" => "@media only screen and (min-width: 768px)",
            ),
        ),

        'group' => $group,
    ));


    materialis_add_kirki_field(array(
        'type'      => 'slider',
        'settings'  => 'header_text_box_overlap_media_size',
        'label'     => esc_html__('Overlap media with', 'materialis'),
        'section'   => $section,
        'priority'  => $priority,
        'default'   => 0,
        'choices'   => array(
            'min'  => '0',
            'max'  => '100',
            'step' => '1',
        ),
        'transport' => 'postMessage',
        'output'    => array(
            array(
                'element'       => '.header-description.media-on-right .header-content',
                'property'      => 'transform',
                'value_pattern' => 'translateX($%)',
                'media_query'   => '@media only screen and (min-width: 768px)',
            ),

            array(
                'element'       => '.header-description.media-on-right .header-content',
                'property'      => 'transform',
                'value_pattern' => 'translateX($%)',
                'media_query'   => '@media only screen and (min-width: 768px)',
            ),

            array(
                'element'       => '.header-description.media-on-left .header-content',
                'property'      => 'transform',
                'value_pattern' => 'translateX(-$%)',
                'media_query'   => '@media only screen and (min-width: 768px)',
            ),
        ),

        'js_vars' => array(
            array(
                'element'       => '.header-description.media-on-right .header-content',
                'function'      => 'css',
                'property'      => 'transform',
                'value_pattern' => 'translateX($%)',
                'media_query'   => '@media only screen and (min-width: 768px)',
            ),

            array(
                'element'       => '.header-description.media-on-left .header-content',
                'function'      => 'css',
                'property'      => 'transform',
                'value_pattern' => 'translateX(-$%)',
                'media_query'   => '@media only screen and (min-width: 768px)',
            ),
        ),

        'active_callback' => array(
            array(
                'setting'  => 'header_content_partial',
                'operator' => 'in',
                'value'    => array('media-on-left', 'media-on-right'),
            ),
        ),
        'group'           => $group,
    ));

    materialis_add_kirki_field(array(
        'type'      => 'select',
        'settings'  => 'header_text_box_text_vertical_align',
        'label'     => esc_html__('Text Vertical Align', 'materialis'),
        'section'   => $section,
        'default'   => 'middle-sm',
        'transport' => 'postMessage',
        'priority'  => $priority,
        'choices'   => array(
            'top-sm'    => esc_html__('Top', 'materialis'),
            'middle-sm' => esc_html__('Middle', 'materialis'),
            'bottom-sm' => esc_html__('Bottom', 'materialis'),
        ),

        'active_callback' => array(
            array(
                'setting'  => 'header_content_partial',
                'operator' => 'in',
                'value'    => array('media-on-left', 'media-on-right'),
            ),
        ),

        'group' => $group,
    ));


    materialis_add_kirki_field(array(
        'type'     => 'sectionseparator',
        'label'    => esc_html__('Background Options', 'materialis'),
        'section'  => $section,
        'settings' => "header_text_box_background_options_separator",
        'priority' => $priority,
        'group'    => $group,
    ));

    materialis_add_kirki_field(array(
        'type'     => 'checkbox',
        'label'    => esc_html__('Enable Background', 'materialis'),
        'section'  => $section,
        'settings' => 'header_text_box_background_enabled',
        'priority' => $priority,
        'default'  => materialis_mod_default('header_element_background_enabled'),
        'group'    => $group,
    ));

    materialis_add_kirki_field(array(
        'type'            => 'color',
        'label'           => esc_html__('Background Color', 'materialis'),
        'section'         => $section,
        'settings'        => 'header_text_box_background_color',
        'default'         => materialis_mod_default('header_element_background_color'),
        'transport'       => 'postMessage',
        'priority'        => $priority,
        'choices'         => array(
            'alpha' => true,
        ),
        'active_callback' => array(
            array(
                'setting'  => 'header_text_box_background_enabled',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'output'          => array(
            array(
                'element'  => '.header-homepage .align-holder',
                'property' => 'background',
            ),
        ),
        'js_vars'         => array(
            array(
                'element'  => '.header-homepage .align-holder',
                'function' => 'css',
                'property' => 'background',
            ),
        ),
        'group'           => $group,
    ));

    materialis_add_kirki_field(array(
        'type'            => 'spacing',
        'settings'        => 'header_text_box_background_spacing',
        'label'           => esc_html__('Background Spacing', 'materialis'),
        'section'         => $section,
        'priority'        => $priority,
        'default'         => materialis_mod_default('header_element_background_spacing'),
        'transport'       => 'postMessage',
        'active_callback' => array(
            array(
                'setting'  => 'header_text_box_background_enabled',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'output'          => array(
            array(
                'element'  => '.header-homepage .align-holder',
                'property' => 'padding',
            ),
        ),
        'js_vars'         => array(
            array(
                'element'  => '.header-homepage .align-holder',
                'function' => 'style',
                'property' => 'padding',
            ),
        ),
        'group'           => $group,
    ));

    materialis_add_kirki_field(array(
        'type'            => 'dimension',
        'settings'        => 'header_text_box_background_border_radius',
        'label'           => esc_html__('Border Radius', 'materialis'),
        'section'         => $section,
        'priority'        => $priority,
        'default'         => materialis_mod_default('header_element_background_radius'),
        'transport'       => 'postMessage',
        'active_callback' => array(
            array(
                'setting'  => 'header_text_box_background_enabled',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'output'          => array(
            array(
                'element'  => '.header-homepage .align-holder',
                'property' => 'border-radius',
            ),
        ),
        'js_vars'         => array(
            array(
                'element'  => '.header-homepage .align-holder',
                'function' => 'style',
                'property' => 'border-radius',
            ),
        ),
        'group'           => $group,
    ));

    materialis_add_kirki_field(array(
        'type'            => 'color',
        'settings'        => 'header_text_box_background_border_color',
        'label'           => esc_html__('Border Color', 'materialis'),
        'section'         => $section,
        'default'         => materialis_mod_default('header_element_background_border_color'),
        'transport'       => 'postMessage',
        'priority'        => $priority,
        'choices'         => array(
            'alpha' => true,
        ),
        'active_callback' => array(
            array(
                'setting'  => 'header_text_box_background_enabled',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'output'          => array(
            array(
                'element'  => '.header-homepage .align-holder',
                'property' => 'border-color',
            ),
        ),
        'js_vars'         => array(
            array(
                'element'  => '.header-homepage .align-holder',
                'function' => 'css',
                'property' => 'border-color',
            ),
        ),
        'group'           => $group,
    ));

    materialis_add_kirki_field(array(
        'type'            => 'spacing',
        'settings'        => 'header_text_box_background_border_thickness',
        'label'           => esc_html__('Background Border Thickness', 'materialis'),
        'section'         => $section,
        'priority'        => $priority,
        'default'         => materialis_mod_default('header_element_background_border_thickness'),
        'transport'       => 'postMessage',
        'active_callback' => array(
            array(
                'setting'  => 'header_text_box_background_enabled',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'group'           => $group,
    ));

    materialis_add_kirki_field(array(
        'type'            => 'slider',
        'settings'        => 'header_text_box_background_shadow',
        'label'           => esc_html__('Shadow Elevation', 'materialis'),
        'section'         => $section,
        'priority'        => $priority,
        'default'         => materialis_mod_default('header_element_background_shadow'),
        'choices'         => array(
            'min'  => '0',
            'max'  => '12',
            'step' => '1',
        ),
        'transport'       => 'postMessage',
        'active_callback' => array(
            array(
                'setting'  => 'header_text_box_background_enabled',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'group'           => $group,
    ));


}

function materialis_front_page_header_content_options($section, $prefix, $priority)
{

    materialis_add_kirki_field(array(
        'type'     => 'sectionseparator',
        'label'    => esc_html__('Content Options', 'materialis'),
        'section'  => $section,
        'settings' => 'header_content_separator',
        'priority' => $priority,
    ));

    materialis_add_kirki_field(array(
        'type'      => 'checkbox',
        'label'     => esc_html__('Make content full width', 'materialis'),
        'settings'  => 'header_content_fullwidth',
        'section'   => $section,
        'default'   => false,
        'priority'  => $priority,
        'transport' => 'postMessage',
    ));

    materialis_add_kirki_field(array(
        'type'     => 'select',
        'settings' => 'header_content_partial',
        'label'    => esc_html__('Content layout', 'materialis'),
        'section'  => $section,
        'default'  => materialis_mod_default('header_content_partial'),
        'choices'  => materialis_get_partial_types(),
        'priority' => $priority,
        'update'   => apply_filters('materialis_header_content_partial_update', array(
            array(
                'value'  => 'content-on-center',
                'fields' => array(
                    'header_text_box_text_align' => 'center',
                ),
            ),
            array(
                'value'  => 'content-on-right',
                'fields' => array(
                    'header_text_box_text_align' => 'right',
                ),
            ),
            array(
                'value'  => 'content-on-left',
                'fields' => array(
                    'header_text_box_text_align' => 'left',
                ),
            ),
            array(
                'value'  => 'media-on-right',
                'fields' => array(
                    'header_text_box_text_align' => 'left',
                    'header_spacing'             => array(
                        'top'    => '5%',
                        'bottom' => '5%',
                    ),
                ),
            ),
            array(
                'value'  => 'media-on-left',
                'fields' => array(
                    'header_text_box_text_align' => 'right',
                    'header_spacing'             => array(
                        'top'    => '5%',
                        'bottom' => '5%',
                    ),
                ),
            ),
        )),
    ));

    materialis_add_kirki_field(array(
        'type'            => 'select',
        'settings'        => 'header_content_media',
        'label'           => esc_html__('Media Type', 'materialis'),
        'section'         => $section,
        'default'         => 'image',
        'choices'         => materialis_get_media_types(),
        'active_callback' => array(
            array(
                'setting'  => 'header_content_partial',
                'operator' => 'contains',
                'value'    => 'media-on-',
            ),
        ),
        'priority'        => $priority,
    ));

    materialis_add_kirki_field(array(
        'type'      => 'ope-info-pro',
        'label'     => esc_html__('More content layouts and media types available in PRO. @BTN@', 'materialis'),
        'section'   => $section,
        'priority'  => $priority,
        'settings'  => 'header_content_pro_info',
        'default'   => true,
        'transport' => 'postMessage',
    ));

    materialis_add_kirki_field(array(
        'type'     => 'spacing',
        'label'    => esc_html__('Content Spacing', 'materialis'),
        'section'  => $section,
        'settings' => 'header_spacing',

        'default' => materialis_mod_default('header_spacing'),

        'output' => array(
            array(
                'element'  => '.header-homepage .header-description-row',
                'property' => 'padding',
            ),
        ),

        'transport' => 'postMessage',

        'js_vars'  => array(
            array(
                'element'  => '.header-homepage .header-description-row',
                'function' => 'css',
                'property' => 'padding',
            ),
        ),
        'priority' => $priority,
    ));


    materialis_add_kirki_field(array(
        'type'     => 'spacing',
        'label'    => esc_html__('Mobile Content Spacing', 'materialis'),
        'section'  => $section,
        'settings' => 'header_spacing_mobile',

        'default' => array(
            'top'    => '10%',
            'bottom' => '10%',
        ),

        'output' => array(
            array(
                'element'     => '.header-homepage .header-description-row',
                'property'    => 'padding',
                'media_query' => '@media screen and (max-width:767px)',
            ),
        ),

        'transport' => 'postMessage',

        'js_vars'  => array(
            array(
                'element'     => '.header-homepage .header-description-row',
                'function'    => 'css',
                'property'    => 'padding',
                'media_query' => '@media screen and (max-width:767px)',
            ),
        ),
        'priority' => $priority,
    ));


    add_filter('materialis_hero_content_vertical_align', 'materialis_hero_content_vertical_align');

    add_filter("materialis_header_description_classes", "materialis_header_description_classes");

    materialis_front_page_header_text_options();

    materialis_add_options_group(array(
        "materialis_front_page_header_media_box_options" => array(
            $section,
            $prefix,
            $priority,
        ),

        "materialis_front_page_header_frame_options" => array(
            $section,
            $prefix,
            $priority + 1,
        ),
    ));
}

// print hero content borders

function materialis_print_hero_content_borders_hook()
{

    $inner = materialis_is_inner(true);

    if ($inner) {
        return;
    }

    $value_holder         = array();
    $holder_bg_enabled    = false;
    $title_bg_enabled     = false;
    $subtitle_bg_enabled  = false;
    $subtitle2_bg_enabled = false;
    $buttons_bg_enabled   = false;

    if (get_theme_mod('header_text_box_background_enabled', materialis_mod_default("header_element_background_enabled"))) {
        $holder_bg_enabled = materialis_get_theme_mod('header_text_box_background_border_thickness', materialis_mod_default('header_element_background_border_thickness'));
        $value_holder      = materialis_get_theme_mod('header_text_box_background_border_thickness', materialis_mod_default('header_element_background_border_thickness'));
    }
    if (get_theme_mod('header_content_title_background_enabled', materialis_mod_default("header_element_background_enabled"))) {
        $title_bg_enabled = materialis_get_theme_mod('header_content_title_background_border_thickness', materialis_mod_default('header_element_background_border_thickness'));
        $value_title      = materialis_get_theme_mod('header_content_title_background_border_thickness', materialis_mod_default('header_element_background_border_thickness'));
    }
    if (get_theme_mod('header_content_subtitle_background_enabled', materialis_mod_default("header_element_background_enabled"))) {
        $subtitle_bg_enabled = materialis_get_theme_mod('header_content_subtitle_background_border_thickness', materialis_mod_default('header_element_background_border_thickness'));
        $value_subtitle      = materialis_get_theme_mod('header_content_subtitle_background_border_thickness', materialis_mod_default('header_element_background_border_thickness'));
    }
    if (get_theme_mod('header_content_subtitle2_background_enabled', materialis_mod_default("header_element_background_enabled"))) {
        $subtitle2_bg_enabled = materialis_get_theme_mod('header_content_subtitle2_background_border_thickness', materialis_mod_default('header_element_background_border_thickness'));
        $value_subtitle2      = materialis_get_theme_mod('header_content_subtitle2_background_border_thickness', materialis_mod_default('header_element_background_border_thickness'));
    }
    if (get_theme_mod('header_content_buttons_background_enabled', materialis_mod_default("header_element_background_enabled"))) {
        $buttons_bg_enabled = materialis_get_theme_mod('header_content_buttons_background_border_thickness', materialis_mod_default('header_element_background_border_thickness'));
        $value_buttons      = materialis_get_theme_mod('header_content_buttons_background_border_thickness', materialis_mod_default('header_element_background_border_thickness'));
    }

    ?>
    <style data-name="hero-content-border">
        <?php if($holder_bg_enabled) { ?>
        .header-homepage .align-holder {
            border-style: solid;
            border-width: <?php echo esc_attr($value_holder['top']) ?> <?php echo esc_attr($value_holder['right']) ?> <?php echo esc_attr($value_holder['bottom']) ?> <?php echo esc_attr($value_holder['left']) ?>;
        }

        <?php
        }
        if($title_bg_enabled) { ?>
        .header-homepage .hero-title {
            border-style: solid;
            border-width: <?php echo esc_attr($value_title['top']) ?> <?php echo esc_attr($value_title['right']) ?> <?php echo esc_attr($value_title['bottom']) ?> <?php echo esc_attr($value_title['left']) ?>;
        }

        <?php
        }
        if($subtitle_bg_enabled) { ?>
        .header-homepage .header-subtitle {
            border-style: solid;
            border-width: <?php echo esc_attr($value_subtitle['top']) ?> <?php echo esc_attr($value_subtitle['right']) ?> <?php echo esc_attr($value_subtitle['bottom']) ?> <?php echo esc_attr($value_subtitle['left']) ?>;
        }

        <?php
        }
        if($subtitle2_bg_enabled) { ?>
        .header-homepage .header-subtitle2 {
            border-style: solid;
            border-width: <?php echo esc_attr($value_subtitle2['top']) ?> <?php echo esc_attr($value_subtitle2['right']) ?> <?php echo esc_attr($value_subtitle2['bottom']) ?> <?php echo esc_attr($value_subtitle2['left']) ?>;
        }

        <?php
        }
        if($buttons_bg_enabled) { ?>
        .header-homepage .header-buttons-wrapper {
            border-style: solid;
            border-width: <?php echo esc_attr($value_buttons['top']) ?> <?php echo esc_attr($value_buttons['right']) ?> <?php echo esc_attr($value_buttons['bottom']) ?> <?php echo esc_attr($value_buttons['left']) ?>;
        }

        <?php } ?>
    </style>
    <?php

}

add_action('wp_head', 'materialis_print_hero_content_borders_hook');
