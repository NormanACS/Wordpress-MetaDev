# IONOS Helper

## References
There is a possibility to query multiple themes and plugins information at the same time.
https://meta.trac.wordpress.org/ticket/1304


## Examples
### Theme data
```php
wp_send_json_success([
    'info' => array(
        'page' => 1,
        'pages' => 1,
        'results' => 1
    ),
    'themes' => array(
        array(
            "name" => "Twenty Twenty-One",
            "slug" => "twentytwentyone",
            "version" => "1.4",
            "preview_url" => "http://wp-themes.com/twentytwentyone/",
            "author" => "WordPress.org",
            "screenshot_url" => "//ts.w.org/wp-content/themes/twentytwentyone/screenshot.png?ver=1.4",
            "rating" => 82,
            "num_ratings" => "33",
            "reviews_url" => "https://wordpress.org/support/theme/twentytwentyone/reviews/",
            "homepage" => "https://wordpress.org/themes/twentytwentyone/",
            "description" => "Twenty Twenty-One is a blank canvas for your ideas and it makes the block editor your best brush. With new block patterns, which allow you to create a beautiful layout in a matter of seconds, this theme’s soft colors and eye-catching — yet timeless — design will let your work shine. Take it for a spin! See how Twenty Twenty-One elevates your portfolio, business website, or personal blog.",
            "requires" => "5.3",
            "requires_php" => "5.6",
            "install_url" => "http://localhost:8078/wp-admin/update.php?action=install-theme&theme=twentytwentyone&_wpnonce=e5f7251906",
            "activate_url" => "http://localhost:8078/wp-admin/themes.php?action=activate&_wpnonce=0c5c912c13&stylesheet=twentytwentyone",
            "customize_url" => "http://localhost:8078/wp-admin/customize.php?theme=twentytwentyone&return=%2Fwp-admin%2Ftheme-install.php",
            "stars" => "<div class=\"star-rating\"><span class=\"screen-reader-text\">4.0 rating based on 33 ratings</span><div class=\"star star-full\" aria-hidden=\"true\"></div><div class=\"star star-full\" aria-hidden=\"true\"></div><div class=\"star star-full\" aria-hidden=\"true\"></div><div class=\"star star-full\" aria-hidden=\"true\"></div><div class=\"star star-empty\" aria-hidden=\"true\"></div></div>",
            "compatible_wp" => true,
            "compatible_php" => true
        )
    )
]);
```
### Plugin data
