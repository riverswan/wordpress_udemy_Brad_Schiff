<?php declare( strict_types=1 );

function university_files(){
	wp_enqueue_style('fontawesome',get_theme_file_uri() . '/vendor/fontawesome/css/all.css');
	wp_enqueue_style('university_main_styles', get_stylesheet_uri());
};

add_action('wp_enqueue_scripts','university_files');
