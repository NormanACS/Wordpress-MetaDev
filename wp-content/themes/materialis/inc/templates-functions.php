<?php

function materialis_get_current_template()
{
    global $template;

    $current_template = str_replace("\\", "/", $template);
    $pathParts        = explode("/", $current_template);
    $current_template = array_pop($pathParts);

    return $current_template;
}

function materialis_is_page_template()
{

    $templates   = wp_get_theme()->get_page_templates();
    $templates   = array_keys($templates);
    $templates[] = "woocommerce.php";

    $current_template = materialis_get_current_template();

    foreach ($templates as $_template) {
        if ($_template === $current_template) {
            return true;
        }

    }

    return false;

}

/**
 * @param bool $is_homepage_template
 *
 * @return bool
 */

function materialis_is_front_page($is_homepage_template = false)
{
    $is_front_page = (is_front_page() && !is_home() && !is_archive());
    $template      = materialis_get_current_template();

    if ($is_front_page && $template !== "homepage.php") {
        $is_front_page = false;
    } else {
        if ($is_homepage_template && !$is_front_page && $template === "homepage.php") {
            $is_front_page = true;
        }
    }

    $is_front_page = apply_filters('materialis_is_front_page', $is_front_page, $is_homepage_template, $template);

    return $is_front_page;
}

function materialis_is_inner_page($include_fp_template = false)
{
    global $post;

    return ($post && $post->post_type === "page" && !materialis_is_front_page($include_fp_template));
}

function materialis_is_inner($include_fp_template = false)
{

    return !materialis_is_front_page($include_fp_template);
}

function materialis_is_blog()
{
    return (is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag()) && 'post' == get_post_type();
}

function materialis_page_content_wrapper_class($default = array())
{

    $class = array('gridContainer', 'content');
    $class = apply_filters('materialis_page_content_wrapper_class', $class);
    $class = $class + $default;
    $class = array_unique($class);

    echo esc_attr(implode(' ', $class));
}

function materialis_page_content_class()
{
    $class = apply_filters('materialis_page_content_class', array());

    echo esc_attr(implode(' ', $class));
}

function materialis_posts_wrapper_class()
{
    $class = is_active_sidebar('sidebar-1') ? 'col-sm-8 col-md-9' : 'col-sm-12';

    if (!apply_filters('materialis_blog_sidebar_enabled', true)) {
        $class = 'col-sm-12';
    }

    echo esc_attr($class);
}

function materialis_get_header($header = null)
{
    $name = apply_filters('materialis_header', $header);

    if ( ! $name) {
        $name = $header;
    }


    do_action("materialis_before_header", $name);

    $fileName = $name ? "header-{$name}" : "header";

    $isInPro = locate_template("pro/{$fileName}.php");

    if ($isInPro) {
        do_action('get_header', $name);
        locate_template("/pro/{$fileName}.php", true);
    }

    if ( ! $isInPro) {
        get_header($name);
    }

}

function materialis_get_sidebar($name = null)
{
    $isInPRO = locate_template("pro/sidebar-{$name}.php", false);

    if ($isInPRO) {
        do_action('get_sidebar', $name);
        locate_template("pro/sidebar-{$name}.php", true);
    }

    if ( ! $isInPRO) {
        get_sidebar($name);
    }
}

function materialis_get_navigation($navigation = null)
{
    $template = apply_filters('materialis_navigation', null);

    if ( ! $template || $template === "default") {
        $template = $navigation;
    }

    get_template_part('template-parts/navigation/navigation', $template);
}

function materialis_header_main_class()
{
    $inner   = materialis_is_inner(true);
    $classes = array();

    $prefix = $inner ? "inner_header" : "header";

    if (materialis_get_theme_mod("{$prefix}_nav_boxed", false)) {
        $classes[] = "boxed";
    }

    $transparent_nav = materialis_get_theme_mod($prefix . '_nav_transparent', materialis_mod_default("{$prefix}_nav_transparent"));

    if ( ! $transparent_nav) {
        $classes[] = "coloured-nav";
    }

    if (materialis_get_theme_mod("{$prefix}_nav_border", materialis_mod_default("{$prefix}_nav_border"))) {
        $classes[] = "bordered";
    }

    if (materialis_is_front_page(true)) {
        $classes[] = "homepage";
    }

    $classes = apply_filters("materialis_header_main_class", $classes, $prefix);

    echo esc_attr(implode(" ", $classes));
}


function materialis_print_logo($footer = false)
{

    $preview_atts = "";
    if (materialis_is_customize_preview()) {
        $preview_atts = "data-focus-control='blogname'";
    }

    if ($footer) {
        printf('<span data-type="group" ' . $preview_atts . ' data-dynamic-mod="true">%1$s</span>', esc_html(get_bloginfo('name')));

        return;
    }

    if (function_exists('has_custom_logo') && has_custom_logo()) {
        $dark_logo_image = materialis_get_theme_mod('logo_dark', false);
        if ($dark_logo_image) {
            $dark_logo_html = sprintf('<a href="%1$s" class="logo-link dark" rel="home" itemprop="url">%2$s</a>',
                esc_url(home_url('/')),
                wp_get_attachment_image(absint($dark_logo_image), 'full', false, array(
                    'class'    => 'logo dark',
                    'itemprop' => 'logo',
                ))
            );

            echo $dark_logo_html;
        }

        the_custom_logo();
    } else {
        printf('<a class="text-logo" data-type="group" ' . $preview_atts . ' data-dynamic-mod="true" href="%1$s">%2$s</a>', esc_url(home_url('/')), materialis_bold_text(get_bloginfo('name')));
    }
}

function materialis_single_item_title($before = "", $after = "")
{
    if (materialis_get_theme_mod('show_single_item_title', true)) {
        the_title($before, $after);
    }
}


if ( ! function_exists('materialis_print_header_content_holder_class')) {
    function materialis_print_header_content_holder_class()
    {
        $align = materialis_get_theme_mod('header_text_box_text_align', materialis_mod_default('header_text_box_text_align'));

        $shadow_class       = '';
        $background_enabled = materialis_get_theme_mod('header_text_box_background_enabled', false);
        $shadow_value       = materialis_get_theme_mod('header_text_box_background_shadow', 0);

        if ($background_enabled && $shadow_value) {
            $shadow_class = 'mdc-elevation--z' . $shadow_value . " ";
        }

        echo "align-holder " . esc_attr($shadow_class . $align);
    }
}


//FOOTER FUNCTIONS

function materialis_get_footer_content($footer = null)
{
    $template = apply_filters('materialis_footer', null);

    if ( ! $template) {
        $template = $footer;
    }

    $slug = 'template-parts/footer/footer';

    if (locate_template("pro/{$slug}-{$template}.php")) {
        $slug = "pro/{$slug}";
    }

    get_template_part($slug, $template);
}

function materialis_get_footer_copyright()
{
    $copyrightText = sprintf(
    // Translators: %s is the link to the theme.
        esc_html__('Built using WordPress and the %s', 'materialis'),
        '<a rel="nofollow" target="_blank" href="https://extendthemes.com/go/built-with-materialis/">' . __('Materialis Theme', 'materialis') . '</a>'
    );

    $previewAtts = "";

    if (materialis_is_customize_preview()) {
        $previewAtts = 'data-footer-copyright="true"';
    }

    $copyright = '<p ' . $previewAtts . ' class="copyright">&copy;&nbsp;' . "&nbsp;" . date_i18n(__('Y', 'materialis')) . '&nbsp;' . esc_html(get_bloginfo('name')) . '.&nbsp;' . wp_kses_post($copyrightText) . '</p>';

    return apply_filters('materialis_get_footer_copyright', $copyright, $previewAtts);
}

function materialis_get_footer_copyright_small()
{
    $previewAtts = "";
    if (materialis_is_customize_preview()) {
        $previewAtts = 'data-footer-copyright="true"';
    }
    $copyright = '<p ' . $previewAtts . ' class="copyright">&copy;&nbsp;' . "&nbsp;" . date_i18n(__('Y', 'materialis')) . '&nbsp;' . esc_html(get_bloginfo('name')) . '</p>';

    return apply_filters('materialis_get_footer_copyright', $copyright, $previewAtts);
}

// PAGE FUNCTIONS

function materialis_print_pagination($args = array(), $class = 'pagination')
{
    if ($GLOBALS['wp_query']->max_num_pages <= 1) {
        return;
    }

    $args = wp_parse_args($args, array(
        'mid_size'           => 2,
        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'materialis') . ' </span>',
        'prev_text'          => __('<i class="mdi mdi-arrow-left"></i>', 'materialis'),
        'next_text'          => __('<i class="mdi mdi-arrow-right"></i>', 'materialis'),
        'screen_reader_text' => __('Posts navigation', 'materialis'),
    ));

    $links = paginate_links($args);

    $next_link = get_previous_posts_link('<i class="mdi mdi-arrow-left"></i>');
    $prev_link = get_next_posts_link('<i class="mdi mdi-arrow-right"></i>');

    $template = apply_filters('materialis_pagination_navigation_markup_template', '
    <div class="navigation %1$s" role="navigation">
        <h2 class="screen-reader-text">%2$s</h2>
        <div class="nav-links mdc-elevation--z1"><div class="prev-navigation">%3$s</div><div class="numbers-navigation">%4$s</div><div class="next-navigation">%5$s</div></div>
    </div>', $args, $class);

    echo sprintf($template, esc_attr($class), $args['screen_reader_text'], $next_link, $links, $prev_link);
}

// POSTS, LIST functions

function materialis_print_archive_entry_class()
{
    global $wp_query;
    $classes = array("post-list-item", "col-xs-12", "space-bottom");
    $index   = $wp_query->current_post;

    $hasBigClass  = ($index === 0 && apply_filters('materialis_archive_post_highlight', true));
    $showBigEntry = (is_archive() || is_home());

    if ($showBigEntry && $hasBigClass) {
        $classes[] = "col-sm-12 col-md-12 highlighted-post";
    } else {
        $postsPerRow = apply_filters('materialis_posts_per_row', 2);
        $postsPerRow = $postsPerRow === 0 ? 1 : $postsPerRow;
        $colSize     = 12 / intval($postsPerRow);
        $classes[]   = "col-sm-12 col-md-{$colSize}";
        if ($colSize !== 12) {
            $classes[] = "multiple-per-row";
        }
    }

    $classes = apply_filters('materialis_archive_entry_class', $classes);

    $classesText = implode(" ", $classes);

    echo esc_attr($classesText);
}

function materialis_print_masonry_col_class($echo = false)
{

    global $wp_query;
    $index        = $wp_query->current_post;
    $hasBigClass  = ($index === 0 && apply_filters('materialis_archive_post_highlight', true));
    $showBigEntry = (is_archive() || is_home());

    $class = "";
    if ($showBigEntry && $hasBigClass) {
        $class = "col-md-12";
    } else {
        $postsPerRow = apply_filters('materialis_posts_per_row', 2);
        $class       = ".col-sm-12.col-md-" . (12 / intval($postsPerRow));
    }

    if ($echo) {
        echo esc_attr($class);

        return;
    }

    return esc_attr($class);
}

function materialis_print_post_thumb_image()
{
    if (has_post_thumbnail()) {
        the_post_thumbnail();
    } else {
        $placeholder_color = materialis_get_theme_mod('blog_post_thumb_placeholder_color', materialis_get_theme_colors('color1'));
        $placeholder_color = maybe_hash_hex_color($placeholder_color);
        ?>
        <svg class="materialis-post-list-item-thumb-placeholder" width="890" height="580" viewBox="0 0 890 580" preserveAspectRatio="none">
            <rect width="890" height="580" style="fill:<?php echo esc_attr($placeholder_color); ?>;"></rect>
        </svg>
        <?php
    }
}

function materialis_print_post_thumb($classes = "")
{

    $show_placeholder = materialis_get_theme_mod('blog_show_post_thumb_placeholder', true);
    if ( ! has_post_thumbnail() && ! $show_placeholder) {
        return;
    }
    ?>
    <div class="post-thumbnail">
        <a href="<?php the_permalink(); ?>" class="post-list-item-thumb <?php echo esc_attr($classes); ?>">
            <?php materialis_print_post_thumb_image(); ?>
        </a>
    </div>
    <?php
}

function materialis_is_customize_preview()
{
    $is_preview = (function_exists('is_customize_preview') && is_customize_preview());

    if ( ! $is_preview) {
        $is_preview = apply_filters('materialis_is_shortcode_refresh', $is_preview);
    }

    return $is_preview;

}

function materialis_print_about_widget()
{

    if (is_single() || is_author()) {
        $author_data = get_user_by('ID', get_the_author_meta('ID'));
    } else {
        $author_data = get_user_by('email', get_option('admin_email'));
    }

    $author_description = get_the_author_meta('description', $author_data->ID);
    $author_avatar      = get_avatar_url($author_data->ID, array(
        'size'          => 160,
        'default'       => 'mystery',
        'force_default' => false,
    ));

    if (materialis_get_theme_mod("show_author_about_box", false)):
    ?>
        <div id="about-box" class="widget_about mdc-elevation--z5">
            <div class="about-box-image mdc-elevation--z7" style="background-image: url(<?php echo esc_attr($author_avatar); ?>);"></div>
            <h4><?php echo esc_html($author_data->display_name); ?></h4>
            <p class="about-box-subheading"><?php echo(get_option('blogdescription')); ?></p>
            <p class="about-box-description"><?php echo esc_html($author_description); ?></p>
            <a href="<?php echo esc_url(get_author_posts_url($author_data->ID)) ?>" class="button white outline"><?php esc_html_e('About Me', 'materialis') ?></a>
        </div>
    <?php
    endif;
}

function materialis_has_category()
{
    $categories = get_the_category();

    return (count($categories) > 0);
}

function materialis_the_category($small_buttons = false)
{
    $categories   = get_the_category();
    $linkTemplate = '<a href="%1$s"  class="button color5 link %3$s">%2$s</a>';
    $classes      = $small_buttons ? "small" : "";


    if ( ! count($categories)) {
        return;
    }

    if (is_archive() || ! is_single()) {
        $after = (count($categories) > 1) ? "<span class='has-more-categories'>[&hellip;]</span>" : "";

        printf($linkTemplate . $after,
            esc_url(get_category_link($categories[0]->term_id)),
            esc_html($categories[0]->name),
            esc_attr($classes)
        );
    } else {
        foreach ($categories as $category) {
            printf($linkTemplate,
                esc_url(get_category_link($category->term_id)),
                esc_html($category->name),
                esc_attr($classes)
            );
        }
    }
}

function materialis_footer_background($footer_class)
{
    $attrs = array(
        'class' => $footer_class . " ",
    );

    $result = "";

    $attrs = apply_filters('materialis_footer_background_atts', $attrs);

    foreach ($attrs as $key => $value) {
        $value  = esc_attr(trim($value));
        $key    = esc_attr($key);
        $result .= " {$key}='{$value}'";
    }

    return $result;
}

function materialis_set_front_page_header_for_blog_as_home($header)
{
    if (is_front_page()) {
        $header = 'homepage';
    }

    return $header;
}

add_filter('materialis_header', 'materialis_set_front_page_header_for_blog_as_home');

function materialis_is_font_page_with_posts_only($value)
{

    if (is_front_page() ) {
        $value = true;
    }

    return $value;
}

add_filter('materialis_is_front_page', 'materialis_is_font_page_with_posts_only');


function materialis_print_skip_link(){
    ?>
    <style>
        .screen-reader-text[href="#page-content"]:focus {
            background-color: #f1f1f1;
            border-radius: 3px;
            box-shadow: 0 0 2px 2px rgba(0, 0, 0, 0.6);
            clip: auto !important;
            clip-path: none;
            color: #21759b;
           
        }
    </style>
    <a class="skip-link screen-reader-text" href="#page-content"><?php _e('Skip to content', 'materialis'); ?></a>
    <?php
}
