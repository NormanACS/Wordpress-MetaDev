<?php 
/**
Template Name: Homepage
*/

get_header();

do_action( 'storely_sections', false );
get_template_part('template-parts/sections/section','blog');
	
get_footer(); ?>