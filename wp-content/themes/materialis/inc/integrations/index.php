<?php

if ( ! defined('ABSPATH')) {
    die('Silence is golden');
}


function materialis_get_integration_modules()
{
    $integrationModules = wp_cache_get('materialis_integration_modules');

    if ( ! $integrationModules) {
        $integrationModules = apply_filters('materialis_integration_modules', array());
        wp_cache_set('materialis_integration_modules', $integrationModules);
    }

    return $integrationModules;
}

function materialis_load_integration_modules()
{
    $modules            = materialis_get_integration_modules();
    $normmalizedABSPATH = wp_normalize_path(ABSPATH);

    foreach ($modules as $module) {
        $module = wp_normalize_path($module);

        if (file_exists("{$module}/integration.php")) {
            require "{$module}/integration.php";
        } else {
            materialis_require("{$module}/integration.php");
        }

    }
}

add_action('after_setup_theme', 'materialis_load_integration_modules', 2);
