<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php
if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
} else { 
	do_action( 'wp_body_open' ); 
}
?>
<?php materialis_print_skip_link(); ?>
<div id="page-top" class="header-top">
    <?php materialis_print_header_top_bar(); ?>
    <?php materialis_get_navigation(); ?>
</div>

<div id="page" class="site">
    <div class="header-wrapper">
        <div <?php echo materialis_header_background_atts(); ?>>
            <?php do_action('materialis_before_header_background'); ?>
            <?php materialis_print_video_container(); ?>
            <?php materialis_print_inner_pages_header_content(); ?>
            <?php materialis_print_header_separator(); ?>
        </div>
    </div>
