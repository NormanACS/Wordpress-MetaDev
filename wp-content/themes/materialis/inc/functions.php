<?php
materialis_require("inc/variables.php");
materialis_require("inc/defaults-dark.php");
materialis_require("inc/defaults.php");

function materialis_mod_default($name, $fallback = null)
{
    if (materialis_has_in_memory('materialis_mod_default')) {
        $defaults = materialis_get_from_memory('materialis_mod_defaults');
    } else {
        $defaults = materialis_theme_defaults();

        $default = $fallback;

        if (isset($defaults[$name])) {
            $default = $defaults[$name];
        }
    }

    return $default;
}


function materialis_get_theme_mod($key, $fallback = null)
{
    return get_theme_mod($key, materialis_mod_default($key, $fallback));
}

function materialis_set_in_memory($key, $value = false)
{
    
    if ( ! isset($GLOBALS['MATERIALIS_MEMORY_CACHE'])) {
        $GLOBALS['MATERIALIS_MEMORY_CACHE'] = array();
    }
    
    $GLOBALS['MATERIALIS_MEMORY_CACHE'][$key] = $value;
}

function materialis_has_in_memory($key)
{
    
    if (isset($GLOBALS['MATERIALIS_MEMORY_CACHE']) && isset($GLOBALS['MATERIALIS_MEMORY_CACHE'][$key])) {
        return $key;
    } else {
        return false;
    }
}

function materialis_get_from_memory($key)
{
    if (materialis_has_in_memory($key)) {
        return $GLOBALS['MATERIALIS_MEMORY_CACHE'][$key];
    }
    
    return false;
}

function materialis_skip_customize_register()
{
    return isset($_REQUEST['materialis_skip_customize_register']);
}

function materialis_get_cache_option_key()
{
    return "__materialis_cached_values__";
}

function materialis_can_show_cached_value($slug)
{
    global $wp_customize;
    
    if ($wp_customize || materialis_is_customize_preview() || wp_doing_ajax() || WP_DEBUG ) {
        return false;
    }
    
    if ($value = materialis_get_from_memory("materialis_can_show_cached_value_{$slug}")) {
        return $value;
    }
    
    $result = (materialis_get_cached_value($slug) !== null);
    
    materialis_set_in_memory("materialis_can_show_cached_value_{$slug}", $result);
    
    return $result;
}

function materialis_cache_value($slug, $value, $cache_on_ajax = false)
{
    
    if (wp_doing_ajax()) {
        if ( ! $cache_on_ajax) {
            return;
        }
    }
    
    if (materialis_is_customize_preview()) {
        return;
    }

    $cached_values = get_option(materialis_get_cache_option_key(), array());
    
    $cached_values[$slug] = $value;
    
    update_option(materialis_get_cache_option_key(), $cached_values, 'yes');
    
}

function materialis_remove_cached_value($slug)
{
    $cached_values = get_option(materialis_get_cache_option_key(), array());
    
    if (isset($cached_values[$slug])) {
        unset($cached_values[$slug]);
    }
    
    update_option(materialis_get_cache_option_key(), $cached_values, 'yes');
}

function materialis_get_cached_value($slug)
{
    $cached_values = get_option(materialis_get_cache_option_key(), array());
    
    if (isset($cached_values[$slug])) {
        return $cached_values[$slug];
    }
    
    return null;
}

function materialis_clear_cached_values()
{
    // cleanup old cached values
    $slugs = get_option('materialis_cached_values_slugs', array());
    
    if (count($slugs)) {
        foreach ($slugs as $slug) {
            materialis_remove_cached_value($slug);
        }
        
        delete_option('materialis_cached_values_slugs');
    }
    // cleanup old cached values
    
    delete_option(materialis_get_cache_option_key());
    
    if (class_exists('autoptimizeCache')) {
        autoptimizeCache::clearall();
    }
}

add_action('cloudpress\companion\clear_caches', 'materialis_clear_cached_values');

function materialis_get_var($name)
{
    global $materialis_variables;

    return $materialis_variables[$name];
}

function materialis_wrap_with_single_quote($element)
{
    return "&apos;{$element}&apos;";
}

function materialis_wrap_with_double_quotes($element)
{
    return "&quot;{$element}&quot;";
}

function materialis_wp_kses_post($text)
{
    // fix the issue with rgb / rgba colors in style atts

    $rgbRegex = "#rgb\(((?:\s*\d+\s*,){2}\s*[\d]+)\)#i";
    $text     = preg_replace($rgbRegex, "rgb__$1__rgb", $text);

    $rgbaRegex = "#rgba\(((\s*\d+\s*,){3}[\d\.]+)\)#i";
    $text      = preg_replace($rgbaRegex, "rgba__$1__rgb", $text);


    // fix google fonts
    $fontsOption       = apply_filters('materialis_google_fonts', materialis_get_general_google_fonts());
    $fonts             = array_keys($fontsOption);
    $singleQuotedFonts = array_map('materialis_wrap_with_single_quote', $fonts);
    $doubleQuotedFonts = array_map('materialis_wrap_with_double_quotes', $fonts);


    $text = str_replace($singleQuotedFonts, $fonts, $text);
    $text = str_replace($doubleQuotedFonts, $fonts, $text);


    $text = wp_kses_post($text);


    $text = str_replace("rgba__", "rgba(", $text);
    $text = str_replace("rgb__", "rgb(", $text);
    $text = str_replace("__rgb", ")", $text);

    return $text;
}

/**
 * wrapper over esc_url with small fixes
 */
function materialis_esc_url($url)
{
    $url = str_replace("^", "%5E", $url); // fix ^ in file name before escape

    return esc_url($url);
}

function materialis_setup()
{
    global $content_width;

    if ( ! isset($content_width)) {
        $content_width = 3840; // 4k :) - content width should be adapted from css not hardcoded
    }

    load_theme_textdomain('materialis', get_template_directory() . '/languages');

    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    set_post_thumbnail_size(1232, 0, false);

    register_default_headers(array(
        'homepage-image' => array(
            'url'           => '%s/assets/images/header-bg-image-default.jpg',
            'thumbnail_url' => '%s/assets/images/header-bg-image-default.jpg',
            'description'   => esc_html__('Homepage Header Image', 'materialis'),
        ),
    ));

    add_theme_support('custom-header', apply_filters('materialis_custom_header_args', array(
        'default-image' => materialis_mod_default('inner_page_header_background', get_template_directory_uri() . "/assets/images/header-bg-image-default.jpg"),
        'width'         => 1920,
        'height'        => 800,
        'flex-height'   => true,
        'flex-width'    => true,
        'header-text'   => false,
    )));

    add_theme_support('custom-logo', array(
        'flex-height' => true,
        'flex-width'  => true,
        'width'       => 150,
        'height'      => 70,
    ));

    add_theme_support('customize-selective-refresh-widgets');

    add_theme_support('custom-background', array(
        'default-color' => '#f5fafd',
    ));

    add_image_size('materialis-full-hd', 1920, 1080);

    register_nav_menus(array(
        'primary'     => esc_html__('Primary Menu', 'materialis'),
        'footer_menu' => esc_html__('Footer Menu', 'materialis'),
    ));

    include_once get_template_directory() . '/customizer/kirki/kirki.php';

    Kirki::add_config('materialis', array(
        'capability'  => 'edit_theme_options',
        'option_type' => 'theme_mod',
    ));

    materialis_theme_page();
    materialis_suggest_plugins();

}

add_action('after_setup_theme', 'materialis_setup');

function materialis_full_hd_image_size_label($sizes)
{
    return array_merge($sizes, array(
        'materialis-full-hd' => __('Full HD', 'materialis'),
    ));
}

add_filter('image_size_names_choose', 'materialis_full_hd_image_size_label');

function materialis_suggest_plugins()
{

    require_once get_template_directory() . '/inc/companion.php';

    /* tgm-plugin-activation */
    require_once get_template_directory() . '/class-tgm-plugin-activation.php';

    $plugins = array(
        'materialis-companion' => array(
            'title'       => esc_html__('Materialis Companion', 'materialis'),
            'description' => esc_html__('Materialis Companion plugin adds drag and drop functionality and many other features to the Materialis theme.', 'materialis'),
            'activate'    => array(
                'label' => esc_html__('Activate', 'materialis'),
            ),
            'install'     => array(
                'label' => esc_html__('Install', 'materialis'),
            ),
        ),
        'contact-form-7'       => array(
            'title'       => esc_html__('Contact Form 7', 'materialis'),
            'description' => esc_html__('The Contact Form 7 plugin is recommended for the Materialis contact section.', 'materialis'),
            'activate'    => array(
                'label' => esc_html__('Activate', 'materialis'),
            ),
            'install'     => array(
                'label' => esc_html__('Install', 'materialis'),
            ),
        ),
    );
    $plugins = apply_filters('materialis_theme_info_plugins', $plugins);
    \Materialis\Companion_Plugin::init(array(
        'slug'           => 'materialis-companion',
        'activate_label' => esc_html__('Activate Materialis Companion', 'materialis'),
        'activate_msg'   => esc_html__('This feature requires the Materialis Companion plugin to be activated.', 'materialis'),
        'install_label'  => esc_html__('Install Materialis Companion', 'materialis'),
        'install_msg'    => esc_html__('This feature requires the Materialis Companion plugin to be installed.', 'materialis'),
        'plugins'        => $plugins,
    ));
}

function materialis_tgma_suggest_plugins()
{
    $plugins = array(
        array(
            'name'     => 'Materialis Companion',
            'slug'     => 'materialis-companion',
            'required' => false,
        ),

        array(
            'name'     => 'Contact Form 7',
            'slug'     => 'contact-form-7',
            'required' => false,
        ),
    );

    $plugins = apply_filters('materialis_tgmpa_plugins', $plugins);

    $config = array(
        'id'           => 'materialis',
        'default_path' => '',
        'menu'         => 'tgmpa-install-plugins',
        'has_notices'  => true,
        'dismissable'  => true,
        'dismiss_msg'  => '',
        'is_automatic' => false,
        'message'      => '',
    );

    $config = apply_filters('materialis_tgmpa_config', $config);

    tgmpa($plugins, $config);
}

add_action('tgmpa_register', 'materialis_tgma_suggest_plugins');

function materialis_can_show_demo_content()
{
    return apply_filters("materialis_can_show_demo_content", current_user_can('edit_theme_options'));
}

function materialis_get_version()
{
    $theme = wp_get_theme();

    if ($theme->get('Template')) {
        $theme = wp_get_theme($theme->get('Template'));
    }

    $ver = $theme->get('Version');
    $ver = apply_filters('materialis_get_version', $ver);

    if ($ver === '@@buildnumber@@') {
        $ver = "99.99." . time();
    }

    return $ver;
}

function materialis_get_text_domain()
{
    $theme = wp_get_theme();

    $textDomain = $theme->get('TextDomain');

    if ($theme->get('Template')) {
        $templateData = wp_get_theme($theme->get('Template'));
        $textDomain   = $templateData->get('TextDomain');
    }

    return $textDomain;
}

function materialis_require($path)
{
    $path = trim($path, "\\/");

    $isInPro = locate_template("/pro/$path") && ! (defined("MATERIALIS_ONLY_FREE") && MATERIALIS_ONLY_FREE);

    if ($isInPro) {
        require_once get_template_directory() . "/{$path}";
    } else {
        if (file_exists(get_template_directory() . "/{$path}")) {
            require_once get_template_directory() . "/{$path}";
        }
    }

}

if ( ! class_exists("Kirki")) {
    include_once get_template_directory() . '/customizer/kirki/kirki.php';
}

materialis_require('/inc/templates-functions.php');
materialis_require('/inc/theme-options.php');


function materialis_add_kirki_field($args)
{
   $has_cached_values = materialis_can_show_cached_value("materialis_cached_kirki_style_materialis");
   
	if ( ! $has_cached_values) {
        $args = apply_filters('materialis_kirki_field_filter', $args);

		$fallback = isset($args['default']) ? $args['default'] : null;
   	 	$default  = materialis_mod_default($args['settings'], $fallback);
    	$args['default'] = $default;
    	
		Kirki::add_field('materialis', $args);
    }
}

// SCRIPTS AND STYLES

function materialis_replace_file_extension($filename, $old_extenstion, $new_extension)
{
    return preg_replace('#\\' . $old_extenstion . '$#', $new_extension, $filename);
}


function materialis_enqueue($type = 'style', $handle = '', $args = array())
{
    $theme = wp_get_theme();
    $ver   = $theme->get('Version');
    $data  = array_merge(array(
        'src'        => '',
        'deps'       => array(),
        'has_min'    => false,
        'in_footer'  => true,
        'media'      => 'all',
        'ver'        => $ver,
        'in_preview' => true,
    ), $args);

    if (materialis_is_customize_preview() && $data['in_preview'] === false) {
        return;
    }

    $isScriptDebug = defined("SCRIPT_DEBUG") && SCRIPT_DEBUG;

    if ($data['has_min'] && ! $isScriptDebug) {
        if ($type === 'style') {
            $data['src'] = materialis_replace_file_extension($data['src'], '.css', '.min.css');
        }

        if ($type === 'script') {
            $data['src'] = materialis_replace_file_extension($data['src'], '.js', '.min.js');
        }
    }

    if ($type == 'style') {
        wp_enqueue_style($handle, $data['src'], $data['deps'], $data['ver'], $data['media']);
    }

    if ($type == 'script') {
        wp_enqueue_script($handle, $data['src'], $data['deps'], $data['ver'], $data['in_footer']);
    }

}

function materialis_enqueue_style($handle, $args)
{
    materialis_enqueue('style', $handle, $args);
}

function materialis_enqueue_script($handle, $args)
{
    materialis_enqueue('script', $handle, $args);
}

function materialis_add_script_data($data)
{

    add_filter('materialis_script_data', function ($value) use ($data) {
        foreach ((array)$data as $key => $value) {
            $value[$key] = $value;
        }

        return $value;
    });

}

function materialis_associative_array_splice($oldArray, $offset, $key, $data)
{
    $newArray = array_slice($oldArray, 0, $offset, true) +
    array($key => $data) +
    array_slice($oldArray, $offset, null, true);

    return $newArray;
}

function materialis_enqueue_styles($textDomain, $ver, $is_child)
{
    
    materialis_enqueue_style(
        $textDomain . '-style',
        array(
            'src'     => get_stylesheet_uri(),
            'has_min' => apply_filters('materialis_stylesheet_has_min', ! $is_child),
            'deps'    => apply_filters('materialis_stylesheet_deps', array()),
        )
    );
    
    if (apply_filters('materialis_load_bundled_version', true)) {

        /*
            icon font files have relative paths to ../../assets/fonts/vendor/mdi/ that break for pro path
            and can't be bundled and webpack crashes on second sass compile for material-icons
        */

        materialis_enqueue_style(
            $textDomain . '-material-icons',
            array(
                'src'     => get_template_directory_uri() . '/assets/css/material-icons.css',
                'has_min' => true,
            )
        );

        materialis_enqueue_style(
            $textDomain . '-style-bundle',
            array(
                'src' => get_template_directory_uri() . '/assets/css/theme.bundle.min.css',
            )
        );

    } else {

	    materialis_enqueue_style(
		$textDomain . '-material-icons',
		array(
		    'src'     => get_template_directory_uri() . '/assets/css/material-icons.css',
		    'has_min' => true,
		)
	    );

	    materialis_enqueue_style(
		'animate',
		array(
		    'src'     => get_template_directory_uri() . '/assets/css/animate.css',
		    'has_min' => true,
		)
	    );

	    materialis_enqueue_style(
		$textDomain . '-webgradients',
		array(
		    'src'     => get_template_directory_uri() . '/assets/css/webgradients.css',
		    'has_min' => true,
		)
	    );
     }
}

function materialis_defer_js_scripts($tag)
{
    $matches = array(
        'theme.bundle.min.js',
        'companion.bundle.min.js',
        includes_url('/js/masonry.min.js'),
        includes_url('/js/imagesloaded.min.js'),
        includes_url('/js/wp-embed.min.js'),
    );
    
    foreach ($matches as $match) {
        if (strpos($tag, $match) !== false) {
            return str_replace('src', ' defer="defer" src', $tag);
        }
    }
    
    return $tag;
    
}

add_filter('script_loader_tag', 'materialis_defer_js_scripts', 11, 1);

function materialis_defer_css_scripts($tag)
{
    if (!is_admin())
    {
        $matches = array(
            'fonts.googleapis.com',
            'companion.bundle.min.css',
        );
    
    } else {
        $matches = array();

    }
    
    if ( ! materialis_is_customize_preview()) {
        foreach ($matches as $match) {
            if (strpos($tag, $match) !== false) {
                return str_replace('href', ' data-href', $tag);
            }
        }
    }
    
    return $tag;
}

add_filter('style_loader_tag', 'materialis_defer_css_scripts', 11, 1);

add_action('wp_head', function () {
    ?>
    <script type="text/javascript" data-name="async-styles">
        (function () {
            var links = document.querySelectorAll('link[data-href]');
            for (var i = 0; i < links.length; i++) {
                var item = links[i];
                item.href = item.getAttribute('data-href')
            }
        })();
    </script>
    <?php
});
function materialis_print_scripts_data()
{
    $data      = apply_filters('materialis_theme_data_script', array());
    $data_text = json_encode($data);
    $script    = "MaterialisTheme = {$data_text}";
    wp_add_inline_script('jquery-core', $script, 'after');
}

add_action('wp_enqueue_scripts', 'materialis_print_scripts_data', 40);

function materialis_enqueue_scripts($textDomain, $ver, $is_child)
{
    
    if (apply_filters('materialis_load_bundled_version', true)) {
        $theme_deps = array('jquery', 'jquery-effects-core', 'jquery-effects-slide', 'masonry');
        materialis_enqueue_script(
            $textDomain . '-theme',
            array(
                "src"  => get_template_directory_uri() . '/assets/js/theme.bundle.min.js',
                "deps" => $theme_deps,
            )
        );
        
    } else {

	    materialis_enqueue_script(
		$textDomain . '-smoothscroll',
		array(
		    'src'     => get_template_directory_uri() . '/assets/js/smoothscroll.js',
		    'deps'    => array('jquery', 'jquery-effects-core'),
		    'has_min' => true,
		)
	    );

	    materialis_enqueue_script(
		$textDomain . '-ddmenu',
		array(
		    'src'     => get_template_directory_uri() . '/assets/js/drop_menu_selection.js',
		    'deps'    => array('jquery-effects-slide', 'jquery'),
		    'has_min' => true,
		)
	    );

	    materialis_enqueue_script(
		'kube',
		array(
		    'src'     => get_template_directory_uri() . '/assets/js/kube.js',
		    'deps'    => array('jquery'),
		    'has_min' => true,
		)
	    );

	    materialis_enqueue_script(
		$textDomain . '-fixto',
		array(
		    'src'     => get_template_directory_uri() . '/assets/js/libs/fixto.js',
		    'deps'    => array('jquery'),
		    'has_min' => true,
		)
	    );

	    wp_enqueue_script($textDomain . '-sticky', get_template_directory_uri() . '/assets/js/sticky.js', array($textDomain . '-fixto'), $ver, true);
	    $theme_deps = apply_filters("materialis_theme_deps", array('jquery', 'masonry'));

	    wp_enqueue_script($textDomain . '-theme', get_template_directory_uri() . '/assets/js/theme.js', $theme_deps, $ver, true);

	    materialis_add_script_data(apply_filters('materialis_theme_data_script', array()));
    }	

    $maxheight = intval(materialis_get_theme_mod('logo_max_height', 70));
    wp_add_inline_style($textDomain . '-style', sprintf('img.logo.dark, img.custom-logo{width:auto;max-height:%1$s;}', $maxheight . "px"));

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}


function materialis_do_enqueue_assets()
{

    $theme        = wp_get_theme();
    $ver          = $theme->get('Version');
    $isChildTheme = ($theme->get('Template'));
    $textDomain   = materialis_get_text_domain();

    materialis_enqueue_styles($textDomain, $ver, $isChildTheme);
    materialis_enqueue_scripts($textDomain, $ver, $isChildTheme);
}    
 
add_action('wp_enqueue_scripts', 'materialis_do_enqueue_assets');


function materialis_customize_controls_enqueue_scripts_spectrum()
{

    $theme = wp_get_theme();
    $ver   = $theme->get('Version');

    if ( ! apply_filters('materialis_load_bundled_version', true)) {
    wp_enqueue_style('materialis-customizer-spectrum', get_template_directory_uri() . '/customizer/libs/spectrum.css', array(), $ver);
    wp_enqueue_script('materialis-customizer-spectrum', get_template_directory_uri() . '/customizer/libs/spectrum.js', array(), $ver, true);
    }
}

add_action('customize_controls_enqueue_scripts', 'materialis_customize_controls_enqueue_scripts_spectrum');

function materialis_get_general_google_fonts()
{
    return array(
        array(
            'family'  => 'Roboto',
            "weights" => array("300", "300italic", "400", "400italic", "500", "500italic", "700", "700italic", "900", "900italic",),
        ),
        array(
            'family'  => 'Playfair Display',
            "weights" => array("400", "400italic", "700", "700italic"),
        ),
    );
}

function materialis_do_enqueue_google_fonts()
{
    $fontsURL = array();
    if (materialis_can_show_cached_value('materialis_google_fonts')) {
        
        $fontsURL = materialis_get_cached_value('materialis_google_fonts');
    } else {
	    $gFonts = materialis_get_general_google_fonts();

	    $fonts = array();

	    foreach ($gFonts as $font) {
		$fonts[$font['family']] = $font;
	    }

	    $gFonts    = apply_filters("materialis_google_fonts", $fonts);
	    $fontQuery = array();
	    foreach ($gFonts as $family => $font) {
		$fontQuery[] = $family . ":" . implode(',', $font['weights']);
	    }

	    $query_args = array(
		'family' => implode('%7C', $fontQuery),
		'subset' => 'latin,latin-ext',
	    );

        $fontsURL = add_query_arg($query_args, 'https://fonts.googleapis.com/css');

        materialis_cache_value('materialis_google_fonts', $fontsURL);
    }

    wp_enqueue_style('materialis-fonts', $fontsURL, array(), null);
}

add_action('wp_enqueue_scripts', 'materialis_do_enqueue_google_fonts');
/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function materialis_pingback_header()
{
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">' . "\n", esc_url(get_bloginfo('pingback_url')));
    }
}

add_action('wp_head', 'materialis_pingback_header');


/**
 * Register sidebar
 */
function materialis_widgets_init()
{

    $sidebars_defaults = array(
        'before_widget' => '<div id="%1$s" class="widget %2$s mdc-elevation--z5">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="widgettitle"><i class="mdi widget-icon"></i>',
        'after_title'   => '</h5>',
    );

    register_sidebar(array_merge(array(
        'name' => esc_html__('Sidebar widget area', 'materialis'),
        'id'   => 'sidebar-1',
    ), $sidebars_defaults));

    register_sidebar(array_merge(array(
        'name' => esc_html__('Pages Sidebar', 'materialis'),
        'id'   => "materialis_pages_sidebar",
    ), $sidebars_defaults));

    register_sidebar(array(
        'name'          => esc_html__("Footer First Box Widgets", 'materialis'),
        'id'            => "first_box_widgets",
        'title'         => esc_html__("Widget Area", 'materialis'),
        'before_widget' => '<div id="%1$s" class="widget %2$s ">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widgettitle">',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => esc_html__("Footer Second Box Widgets", 'materialis'),
        'id'            => "second_box_widgets",
        'title'         => esc_html__("Widget Area", 'materialis'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widgettitle">',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => esc_html__("Footer Third Box Widgets", 'materialis'),
        'id'            => "third_box_widgets",
        'title'         => esc_html__("Widget Area", 'materialis'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widgettitle">',
        'after_title'   => '</h4>',
    ));
}

add_action('widgets_init', 'materialis_widgets_init');

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Read more' link.
 *
 * @return string '... Read more'
 */
function materialis_excerpt_more($link)
{
    if (is_admin()) {
        return $link;
    }

    return '&nbsp;&hellip;';
}

add_filter('excerpt_more', 'materialis_excerpt_more');

// UTILS


function materialis_nomenu_fallback($walker = '')
{
    $drop_down_menu_classes      = apply_filters('materialis_primary_drop_menu_classes', array('default'));
    $drop_down_menu_classes      = array_merge($drop_down_menu_classes, array('main-menu', 'dropdown-menu'));
    $drop_down_menu_main_classes = array_merge($drop_down_menu_classes, array('row'));

    return wp_page_menu(array(
        "menu_class" => esc_attr(implode(" ", $drop_down_menu_main_classes)),
        "menu_id"    => 'mainmenu_container',
        'before'     => '<ul id="main_menu" class="' . esc_attr(implode(" ", $drop_down_menu_classes)) . '">',
        'after'      => apply_filters('materialis_nomenu_after', '') . "</ul>",
        'walker'     => $walker,
    ));
}


function materialis_nomenu_cb()
{
    return materialis_nomenu_fallback('');
}

function materialis_footer_nomenu_cb_filter_depth($args)
{
    $args['depth'] = 1;

    return $args;
}

function materialis_footer_nomenu_cb()
{
    add_filter('wp_page_menu_args', 'materialis_footer_nomenu_cb_filter_depth');
    $menu = wp_page_menu(array(
        "menu_class" => "materialis-footer-menu",
        "menu_id"    => 'materialis-footer-menu',
        'before'     => '<ul id="materialis-footer-menu" class="materialis-footer-menu">',
        'after'      => apply_filters('materialis_nomenu_after', '') . "</ul>",
        'walker'     => '',
    ));
    remove_filter('wp_page_menu_args', 'materialis_footer_nomenu_cb_filter_depth');

    return $menu;
}

function materialis_no_hamburger_menu_cb()
{
    return wp_page_menu(array(
        "menu_class" => 'offcanvas_menu',
        "menu_id"    => 'offcanvas_menu',
        'before'     => '<ul id="offcanvas_menu" class="offcanvas_menu">',
        'after'      => apply_filters('materialis_nomenu_after', '') . "</ul>",
    ));
}

function materialis_title()
{
    $title = '';

    if (is_404()) {
        $title = __('Page not found', 'materialis');
    } else if (is_search()) {
        $title = sprintf(__('Search Results for &#8220;%s&#8221;', 'materialis'), get_search_query());
    } else if (is_home()) {
        if (is_front_page()) {
            $title = get_bloginfo('name');
        } else {
            $title = single_post_title();
        }
    } else if (is_archive()) {
        if (is_post_type_archive()) {
            $title = post_type_archive_title('', false);
        } else {
            $title = get_the_archive_title();
        }
    } else if (is_single()) {
        $title = get_bloginfo('name');

        global $post;
        if ($post) {
            // apply core filter
            $title = apply_filters('single_post_title', $post->post_title, $post);
        }
    } else {
        $title = get_the_title();
    }

    $value = apply_filters('materialis_header_title', materialis_wp_kses_post($title));

    return $value;
}

function materialis_bold_text($str)
{
    $bold = materialis_get_theme_mod('bold_logo', true);

    if ( ! $bold) {
        return $str;
    }

    $str   = trim($str);
    $words = preg_split("/(?<=[a-z])(?=[A-Z])|(?=[\s]+)/x", $str);

    $result = "";
    $c      = 0;
    for ($i = 0; $i < count($words); $i++) {
        $word = $words[$i];
        if (preg_match("/^\s*$/", $word)) {
            $result .= $words[$i];
        } else {
            $c++;
            if ($c % 2) {
                $result .= $words[$i];
            } else {
                $result .= '<span style="font-weight: 300;" class="span12">' . esc_html($words[$i]) . "</span>";
            }
        }
    }

    return $result;
}


function materialis_sanitize_checkbox($val)
{
    return (isset($val) && $val == true ? true : false);
}

function materialis_sanitize_textfield($val)
{
    return wp_kses_post(force_balance_tags($val));
}

if ( ! function_exists('materialis_post_type_is')) {
    function materialis_post_type_is($type)
    {
        global $wp_query;

        $post_type = $wp_query->query_vars['post_type'] ? $wp_query->query_vars['post_type'] : 'post';

        if ( ! is_array($type)) {
            $type = array($type);
        }

        return in_array($post_type, $type);
    }
}

function materialis_to_bool($value)
{
    if (is_bool($value)) {
        return $value;
    }

    if (is_string($value)) {
        if (strtolower($value) === "yes" || strtolower($value) === "true") {
            return true;
        }

        if (strtolower($value) === "no" || strtolower($value) === "false") {
            return false;
        }
    }

    if (is_numeric()) {
        return ! ! intval($value);
    }

    return ! ! $value;
}

//////////////////////////////////////////////////////////////////////////////////////


function materialis_footer_container($class)
{
    $attrs = array(
        'class' => "footer " . $class . " ",
    );

    $result = "";

    $attrs = apply_filters('materialis_footer_container_atts', $attrs);

    foreach ($attrs as $key => $value) {
        $value  = esc_attr(trim($value));
        $key    = esc_attr($key);
        $result .= " {$key}='{$value}'";
    }

    return $result;
}


// THEME PAGE
function materialis_theme_page()
{
    add_action('admin_menu', 'materialis_register_theme_page');
}

function materialis_load_theme_partial()
{
    require_once get_template_directory() . '/inc/companion.php';
    require_once get_template_directory() . "/inc/theme-info.php";
    wp_enqueue_style('materialis-theme-info', get_template_directory_uri() . "/assets/css/theme-info.css");
    wp_enqueue_script('materialis-theme-info', get_template_directory_uri() . "/assets/js/theme-info.js", array('jquery'), '', true);
}

function materialis_register_theme_page()
{
    add_theme_page(__('Materialis Info', 'materialis'), __('Materialis Info', 'materialis'), 'activate_plugins', 'materialis-welcome', 'materialis_load_theme_partial');
}


function materialis_instantiate_widget($widget, $args = array())
{

    ob_start();
    the_widget($widget, array(), $args);
    $content = ob_get_contents();
    ob_end_clean();

    if (isset($args['wrap_tag'])) {
        $tag     = $args['wrap_tag'];
        $class   = isset($args['wrap_class']) ? $args['wrap_class'] : "";
        $content = "<{$tag} class='{$class}'>{$content}</{$tag}>";
    }

    return $content;

}

// load support for woocommerce
if (class_exists('WooCommerce')) {
    require_once get_template_directory() . "/inc/woocommerce/woocommerce.php";
} else {
    require_once get_template_directory() . "/inc/woocommerce/woocommerce-ready.php";
}

materialis_require("/inc/integrations/index.php");

function materialis_is_woocommerce_page()
{

    if (function_exists("is_woocommerce") && is_woocommerce()) {
        return true;
    }

    $woocommerce_keys = array(
        "woocommerce_shop_page_id",
        "woocommerce_terms_page_id",
        "woocommerce_cart_page_id",
        "woocommerce_checkout_page_id",
        "woocommerce_pay_page_id",
        "woocommerce_thanks_page_id",
        "woocommerce_myaccount_page_id",
        "woocommerce_edit_address_page_id",
        "woocommerce_view_order_page_id",
        "woocommerce_change_password_page_id",
        "woocommerce_logout_page_id",
        "woocommerce_lost_password_page_id",
    );

    foreach ($woocommerce_keys as $wc_page_id) {
        if (get_the_ID() == get_option($wc_page_id, 0)) {
            return true;
        }
    }

    return false;
}

function materialis_customize_save_clear_data($value)
{
    
    if ( ! isset($value['changeset_status']) || $value['changeset_status'] !== "auto-draft") {
        materialis_clear_cached_values();
    }
    
    return $value;
}

add_filter("customize_save_response", "materialis_customize_save_clear_data");


function materialis_skip_link_focus_fix()
{
    // The following is minified via `terser --compress --mangle -- js/skip-link-focus-fix.js`.
    ?>
    <script>
        /(trident|msie)/i.test(navigator.userAgent) && document.getElementById && window.addEventListener && window.addEventListener("hashchange", function() {
            var t, e = location.hash.substring(1);
            /^[A-z0-9_-]+$/.test(e) && (t = document.getElementById(e)) && (/^(?:a|select|input|button|textarea)$/i.test(t.tagName) || (t.tabIndex = -1), t.focus())
        }, !1);
    </script>
<?php
}

add_action('wp_print_footer_scripts', 'materialis_skip_link_focus_fix');

function materialis_color_picker_scripts() {
	wp_enqueue_style('wp-color-picker' );
	wp_enqueue_script('iris', admin_url('js/iris.min.js'), array('jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch'), false, true);
	wp_enqueue_script('wp-color-picker', admin_url('js/color-picker.min.js'), array('iris', 'wp'), false, true);

	$colorpicker_l10n = array(
		'clear' => __( 'Clear', 'materialis' ),
		'defaultString' => __( 'Default', 'materialis' ), 
		'pick' => __( 'Select Color', 'materialis' ),	
		'current' => __( 'Current Color', 'materialis' )
	);
	wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', $colorpicker_l10n );
}

if (is_customize_preview()) {
	add_action( 'init', 'materialis_color_picker_scripts');
}
