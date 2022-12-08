<?php

function materialis_inner_pages_header_content_options($section, $prefix, $priority)
{

    materialis_add_kirki_field(array(
        'type'     => 'sectionseparator',
        'label'    => esc_html__('Content', 'materialis'),
        'section'  => $section,
        'settings' => 'inner_header_content_options_separator',
        'priority' => $priority,
    ));

    materialis_add_kirki_field(array(
        'type'     => 'radio-buttonset',
        'label'    => esc_html__('Text Align', 'materialis'),
        'section'  => $section,
        'settings' => 'inner_header_text_align',
        'default'  => 'center',
        'priority' => $priority,
        'choices'  => array(
            'left'   => esc_html__('Left', 'materialis'),
            'center' => esc_html__('Center', 'materialis'),
            'right'  => esc_html__('Right', 'materialis'),
        ),
        'output' => array(
            array(
                'element'     => '.inner-header-description',
                'property'    => 'text-align',
                'suffix'      => '!important',
                'media_query' => '@media only screen and (min-width: 768px)',
            ),

        ),
        'transport' => 'postMessage',
        'js_vars' => array(
            array(
                'element'  => '.inner-header-description',
                'function' => 'css',
                'suffix'   => '!important',
                'property' => 'text-align',
            ),
        ),
    ));

    materialis_add_kirki_field(array(
        'type'     => 'spacing',
        'label'    => esc_html__('Content Spacing', 'materialis'),
        'section'  => $section,
        'settings' => 'inner_header_spacing',
        'default' => array(
            'top'    => '8%',
            'bottom' => '8%',
        ),
        'output' => array(
            array(
                'element'  => '.inner-header-description',
                'property' => 'padding',
                'suffix'   => ' !important',
            ),
        ),
        'transport' => 'postMessage',
        'js_vars'  => array(
            array(
                'element'  => '.inner-header-description',
                'function' => 'css',
                'property' => 'padding',
                'suffix'   => ' !important',
            ),
        ),
        'priority' => $priority,
    ));


    materialis_add_kirki_field(array(
        'type'     => 'checkbox',
        'settings' => 'inner_header_show_subtitle',
        'label'    => esc_html__('Show subtitle (blog description)', 'materialis'),
        'section'  => $section,
        'default'  => true,
        'priority' => $priority+1,
    ));
}


/*
    template functions
*/


function materialis_print_inner_pages_header_content()
{
    do_action('materialis_before_inner_page_header_content');
    ?>
    <div class="inner-header-description gridContainer">
        <div class="row header-description-row">
            <div class="col-xs col-xs-12">
                <h1 class="hero-title">
                    <?php echo materialis_title(); ?>
                </h1>
                <?php
                $show_subtitle = materialis_get_theme_mod('inner_header_show_subtitle', true);
                $show_subtitle = apply_filters('inner_header_show_subtitle', $show_subtitle);

                if ($show_subtitle && materialis_post_type_is(array('post', 'attachment'))):
                    ?>
                    <p class="header-subtitle"><?php echo esc_html(get_bloginfo('description')); ?></p>
                <?php endif; ?>
            </div>

        </div>
    </div>
    <?php

    do_action('materialis_after_inner_page_header_content');
}
