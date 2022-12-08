<?php

require_once get_template_directory() . "/inc/header-options/content-options/content-type.php";
require_once get_template_directory() . "/inc/header-options/content-options/inner-pages.php";
require_once get_template_directory() . "/inc/header-options/content-options/title.php";
require_once get_template_directory() . "/inc/header-options/content-options/subtitle.php";
materialis_require("/inc/header-options/content-options/subtitle2.php");
require_once get_template_directory() . "/inc/header-options/content-options/buttons.php";


function materialis_customize_register_options_header_content_settings_group()
{
    materialis_add_options_group(array(
        "materialis_front_page_header_title_options"    => array(
            // section, prefix, priority
            "header_background_chooser",
            "header",
            6,
        ),
        "materialis_front_page_header_subtitle_options" => array(
            "header_background_chooser",
            "header",
            6,
        ),
        "materialis_front_page_header_buttons_options"  => array(
            "header_background_chooser",
            "header",
            6,
        ),

        "materialis_front_page_header_content_options" => array(
            "header_background_chooser",
            "header",
            5,
        ),

        "materialis_inner_pages_header_content_options" => array(
            "header_image",
            "inner_header",
            9,
        ),
    ));
}

add_action("materialis_customize_register_options", 'materialis_customize_register_options_header_content_settings_group');


if ( ! function_exists("materialis_print_header_content")) {
    function materialis_print_header_content()
    {
        do_action("materialis_print_header_content");
    }
}

function materialis_get_media_types()
{
    return apply_filters('materialis_media_type_choices', array(
        "image" => esc_html__("Image", "materialis"),
    ));
}

function materialis_get_partial_types()
{
    return apply_filters('materialis_header_content_partial', array(
        "content-on-center" => esc_html__("Text on center", "materialis"),
        "content-on-right"  => esc_html__("Text on right", "materialis"),
        "content-on-left"   => esc_html__("Text on left", "materialis"),
        "media-on-left"     => esc_html__("Text with media on left", "materialis"),
        "media-on-right"    => esc_html__("Text with media on right", "materialis"),
    ));
}

function materialis_get_front_page_header_media_and_partial()
{
    $partial   = materialis_get_theme_mod('header_content_partial', materialis_mod_default('header_content_partial'));
    $mediaType = materialis_get_theme_mod('header_content_media', 'image');

    if ( ! array_key_exists($partial, materialis_get_partial_types())) {
        $partial = materialis_mod_default('header_content_partial');
    }

    if ( ! array_key_exists($mediaType, materialis_get_media_types())) {
        $mediaType = 'image';
    }

    return array(
        'partial' => $partial,
        'media'   => $mediaType,
    );

}

function materialis_print_front_page_header_content()
{
    $headerContent = materialis_get_front_page_header_media_and_partial();
    $partial       = $headerContent['partial'];
    $classes       = apply_filters('materialis_header_description_classes', array($partial, "gridContainer"));

    do_action('materialis_before_front_page_header_content');

    ?>

    <div class="header-description <?php echo esc_attr(implode(" ", $classes)); ?>">
        <?php get_template_part('template-parts/header/hero', $partial); ?>
    </div>

    <?php

    do_action('materialis_after_front_page_header_content');
}

function materialis_print_header_media_frame($media)
{
    $frame_type = materialis_get_theme_mod('header_content_frame_type', "border");
    if ($frame_type === "none") {
        echo $media;

        return;
    }


    $frame_width  = intval(materialis_get_theme_mod('header_content_frame_width', "100"));
    $frame_height = intval(materialis_get_theme_mod('header_content_frame_height', "100"));

    $frame_offset_left = intval(materialis_get_theme_mod('header_content_frame_offset_left', "-13"));
    $frame_offset_top  = intval(materialis_get_theme_mod('header_content_frame_offset_top', "10"));
    $frame_over_image  = materialis_get_theme_mod('header_content_frame_show_over_image', false);
    $frame_color       = materialis_get_theme_mod('header_content_frame_color', "rgba(255,255,255,0.726)");
    $frame_thickness   = intval(get_theme_mod('header_content_frame_thickness', 11));
    $frame_shadow      = materialis_get_theme_mod('header_content_frame_shadow', true);
    $frame_hide        = materialis_get_theme_mod('header_content_frame_hide_on_mobile', true);

    $z_index = $frame_over_image ? 1 : -1;

    $style = "transform:translate($frame_offset_left%, $frame_offset_top%);";
    $style .= "width:{$frame_width}%;height:{$frame_height}%;";
    $style .= "{$frame_type}-color:{$frame_color};";
    $style .= "z-index:$z_index;";

    if ($frame_type == "border") {
        $style .= "border-width:{$frame_thickness}px;";
    }

    $classes = "overlay-box-offset  offset-" . $frame_type . " ";

    if ($frame_shadow) {
        $classes .= "mdc-elevation--z4 ";
    }

    if ($frame_hide) {
        $classes .= "hide-xs ";
    }

    $headerContent = materialis_get_front_page_header_media_and_partial();
    $partial       = $headerContent['partial'];
    
    $style_overlay = '';
    if ($headerContent['partial'] == 'media-on-top')
    {
        $style_overlay = 'margin-bottom:' . abs($frame_offset_top) . '%';
    }
    
    if ($headerContent['partial'] == 'media-on-bottom')
    {
        $style_overlay = 'margin-top:' . abs($frame_offset_top) . 'px';
    }

    $align = "";
    if (in_array($partial, array("media-on-right", "media-on-left"))) {
        $align = "end-sm";
    }
    ?>
    <div class="flexbox center-xs <?php echo $align; ?> middle-xs">
        <div class="overlay-box"  style="<?php echo esc_attr($style_overlay); ?>">
            <div class="<?php echo esc_attr($classes); ?>" style="<?php echo esc_attr($style); ?>"></div>
            <?php echo $media; ?>
        </div>
    </div>
    <?php
}

function materialis_print_header_media_image($mediaType)
{
    if ($mediaType == "image") {
        $roundImage   = materialis_get_theme_mod('header_content_image_rounded', false);
        $extraClasses = "";
        if (intval($roundImage)) {
            $extraClasses .= " round";
        }

        $image = materialis_get_theme_mod('header_content_image', get_template_directory_uri() . "/assets/images/media-image-default.jpg");

        $customizerLink = "";

        if (materialis_is_customize_preview()) {
            $customizerLink = "data-type=\"group\" data-focus-control=\"header_content_image\"";
        }

        if (is_numeric($image)) {
            $image = wp_get_attachment_image_src(absint($image), 'full', false);
            if ($image) {
                list($src, $width, $height) = $image;
                $image = $src;
            } else {
                $image = "#";
            }
        }

        if ( ! empty($image)) {
            $image = sprintf('<img class="homepage-header-image %2$s" %3$s src="%1$s"/>', esc_url($image), esc_attr($extraClasses), $customizerLink);
            materialis_print_header_media_frame($image);
        }
    }
}

add_action("materialis_print_header_media", 'materialis_print_header_media_image');

if ( ! function_exists('materialis_print_header_media')) {
    function materialis_print_header_media()
    {
        $headerContent = materialis_get_front_page_header_media_and_partial();
        $mediaType     = $headerContent['media'];

        do_action('materialis_print_header_media', $mediaType);

    }
}

add_action('materialis_after_front_page_header_content', 'materialis_print_default_after_header_content');
add_action('materialis_after_inner_page_header_content', 'materialis_print_default_after_header_content');

function materialis_get_header_top_spacing_script()
{
    ob_start();
    ?>
    <script>
        (function ($) {
            function setHeaderTopSpacing() {
                $('.header-wrapper .header,.header-wrapper .header-homepage').css({
                    'padding-top': $('.header-top').height()
                });

             setTimeout(function() {
                  var headerTop = document.querySelector('.header-top');
                  var headers = document.querySelectorAll('.header-wrapper .header,.header-wrapper .header-homepage');

                  for (var i = 0; i < headers.length; i++) {
                      var item = headers[i];
                      item.style.paddingTop = headerTop.getBoundingClientRect().height + "px";
                  }

                    var languageSwitcher = document.querySelector('.materialis-language-switcher');

                    if(languageSwitcher){
                        languageSwitcher.style.top = "calc( " +  headerTop.getBoundingClientRect().height + "px + 1rem)" ;
                    }
                    
                }, 100);

            }

            jQuery(window).on('resize orientationchange', setHeaderTopSpacing);
            window.materialisSetHeaderTopSpacing = setHeaderTopSpacing

        })(jQuery);
    </script>
    <?php

    $content = ob_get_clean();
    $content = strip_tags($content);

    return $content;
}

add_action('wp_enqueue_scripts', 'materialis_enqueue_header_top_spacing_script', 40);
function materialis_enqueue_header_top_spacing_script()
{
    wp_add_inline_script('jquery', materialis_get_header_top_spacing_script());
}

function materialis_print_default_after_header_content()
{
    //  execute top spacing script as soon as possible to prevent repositioning flicker
    ?>
    <script>
		if (window.materialisSetHeaderTopSpacing) {
			window.materialisSetHeaderTopSpacing();
		}
    </script>
    <?php
}


add_action('wp_head', 'materialis_print_background_content_color', PHP_INT_MAX);

function materialis_print_background_content_color()
{

    ?>
    <style data-name="background-content-colors">
        .materialis-front-page .content.blog-page,
        .materialis-inner-page .page-content,
        .materialis-inner-page .content,
        .materialis-front-page.materialis-content-padding .page-content {
            background-color: #<?php echo sanitize_hex_color_no_hash( get_background_color() ); ?>;
        }
    </style>
    <?php
}
