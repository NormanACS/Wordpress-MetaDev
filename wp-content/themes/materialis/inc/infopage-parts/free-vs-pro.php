<?php

$comparisionArray = array(
    array(
        "feature" => __("Live editing in Customizer", 'materialis'),
        "free"    => '<span class="dashicons dashicons-yes"></span>',
        "pro"     => '<span class="dashicons dashicons-yes"></span>',
    ),
    array(
        "feature" => __("Front page header designs", 'materialis'),
        "free"    => __("5", 'materialis'),
        "pro"     => __("19", 'materialis'),
    ),
    array(
        "feature" => __("Video and slideshow backgrounds", 'materialis'),
        "free"    => '<span class="dashicons dashicons-yes"></span>',
        "pro"     => __("Unlimited", 'materialis'),
    ),
    array(
        "feature" => __("Header overlay and separators", 'materialis'),
        "free"    => '<span class="dashicons dashicons-yes"></span>',
        "pro"     => '<span class="dashicons dashicons-yes"></span>',
    ),
    array(
        "feature" => __("Header layout options", 'materialis'),
        "free"    => __("3", 'materialis'),
        "pro"     => __("17", 'materialis'),
    ),
    array(
        "feature" => __("Header media types", 'materialis'),
        "free"    => __("1 (image)", 'materialis'),
        "pro"     => __("4 (image, video, lightbox, multiple images)", 'materialis'),
    ),
    array(
        "feature" => __("Page content sections", 'materialis'),
        "free"    => __("35+", 'materialis'),
        "pro"     => __("150+", 'materialis'),
    ),
    array(
        "feature" => __("Create multiple pages using predefined sections", 'materialis'),
        "free"    => __("homepage only", 'materialis'),
        "pro"     => __("unlimited", 'materialis'),
    ),
    array(
        "feature" => __("About and features sections", 'materialis'),
        "free"    => '<span class="dashicons dashicons-yes"></span>',
        "pro"     => '<span class="dashicons dashicons-yes"></span>',
    ),
    array(
        "feature" => __("Portfolio sections", 'materialis'),
        "free"    => '<span class="dashicons dashicons-yes"></span>',
        "pro"     => '<span class="dashicons dashicons-yes"></span>',
    ),
    array(
        "feature" => __("Team and testimonials sections", 'materialis'),
        "free"    => '<span class="dashicons dashicons-yes"></span>',
        "pro"     => '<span class="dashicons dashicons-yes"></span>',
    ),
    array(
        "feature" => __("Contact form sections", 'materialis'),
        "free"    => '<span class="dashicons dashicons-yes"></span>',
        "pro"     => '<span class="dashicons dashicons-yes"></span>',
    ),
    array(
        "feature" => __("Video and slideshow background", 'materialis'),
        "free"    => '<span class="dashicons dashicons-yes"></span>',
        "pro"     => '<span class="dashicons dashicons-yes"></span>',
    ),
    array(
        "feature" => __("Widgetized footer", 'materialis'),
        "free"    => '<span class="dashicons dashicons-yes"></span>',
        "pro"     => '<span class="dashicons dashicons-yes"></span>',
    ),
    array(
        "feature" => __("Parallax background", 'materialis'),
        "free"    => '<span class="dashicons dashicons-yes"></span>',
        "pro"     => '<span class="dashicons dashicons-yes"></span>',
    ),
    array(
        "feature" => __("Logo and navigation colors", 'materialis'),
        "free"    => '<span class="dashicons dashicons-dismiss"></span>',
        "pro"     => '<span class="dashicons dashicons-yes"></span>',
    ),
    array(
        "feature" => __("Typography style and colors", 'materialis'),
        "free"    => '<span class="dashicons dashicons-dismiss"></span>',
        "pro"     => '<span class="dashicons dashicons-yes"></span>',
    ),
    array(
        "feature" => __("Customize background for each section", 'materialis'),
        "free"    => '<span class="dashicons dashicons-dismiss"></span>',
        "pro"     => '<span class="dashicons dashicons-yes"></span>',
    ),
    array(
        "feature" => __("Google maps sections", 'materialis'),
        "free"    => '<span class="dashicons dashicons-dismiss"></span>',
        "pro"     => '<span class="dashicons dashicons-yes"></span>',
    ),
    array(
        "feature" => __("Photo gallery sections", 'materialis'),
        "free"    => '<span class="dashicons dashicons-dismiss"></span>',
        "pro"     => '<span class="dashicons dashicons-yes"></span>',
    ),
    array(
        "feature" => __("Pricing table sections", 'materialis'),
        "free"    => '<span class="dashicons dashicons-dismiss"></span>',
        "pro"     => '<span class="dashicons dashicons-yes"></span>',
    ),
    array(
        "feature" => __("Newsletter subscribe sections", 'materialis'),
        "free"    => '<span class="dashicons dashicons-dismiss"></span>',
        "pro"     => '<span class="dashicons dashicons-yes"></span>',
    ),
    array(
        "feature" => __("Customize footer text and colors", 'materialis'),
        "free"    => '<span class="dashicons dashicons-dismiss"></span>',
        "pro"     => '<span class="dashicons dashicons-yes"></span>',
    ),
    array(
        "feature" => __("Woocommerce integration", 'materialis'),
        "free"    => __("Coming soon, limited support", 'materialis'),
        "pro"     => __("Coming soon", 'materialis'),
    ),
    array(
        "feature" => __("Multilanguage support", 'materialis'),
        "free"    => '<span class="dashicons dashicons-dismiss"></span>',
        "pro"     => __("Coming soon", 'materialis'),
    ),
);

?>
<div class="tab-cols">
    <h2><?php _e('Free and PRO versions compared', 'materialis'); ?></h2>
    <table class="fixed pages striped widefat wp-list-table comparision-table">
        <thead>
        <tr>
            <td></td>
            <td class="table-col-title"><h4><?php _e('Free Version', 'materialis'); ?></h4></td>
            <td class="table-col-title"><h4><?php _e('Pro Version', 'materialis'); ?></h4></td>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($comparisionArray as $row): ?>
            <tr>
                <td class="table-col-feature"><h4><?php echo esc_html($row['feature']); ?></h4></td>
                <td class="table-col-value"><?php echo $row['free']; ?></td>
                <td class="table-col-value"><?php echo $row['pro']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
