<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
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
<div id="page-top" class="header-top small">
	<?php materialis_print_header_top_bar(); ?>
	<?php materialis_get_navigation(); ?>
</div>

<div id="page" class="site">
