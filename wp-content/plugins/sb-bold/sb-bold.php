<?php
/**
 * Plugin Name:       Add Bold to text
 * Plugin URI:        https://github.com/riverswan/
 * Description:       Adds "bold" class to selected element
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Pavel Lebedev
 * Author URI:        https://github.com/riverswan/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

add_filter( 'mce_buttons_2', 'add_style_select_buttons' );
add_filter( 'tiny_mce_before_init', 'my_custom_styles' );
add_filter( 'mce_css', 'sb_custom_editor_style' );
add_action( 'wp_enqueue_scripts', 'sb_bold_style' );


function add_style_select_buttons( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}


function my_custom_styles( $init_array ) {

	$style_formats = array(
		array(
			'title' => 'Bold',
			'block' => 'span',
			'classes' => 'bold',
			'wrapper' => false,
		)
	);
	$init_array['style_formats'] = json_encode( $style_formats );

	return $init_array;

}

function sb_custom_editor_style( $mce_css ){

	$mce_css .= ', ' . plugin_dir_url( __FILE__ ) . 'sb-bold.css' ;
	return $mce_css;
}


function sb_bold_style(){
	wp_enqueue_style( 'sb-bold', plugin_dir_url( __FILE__ ) . 'sb-bold.css' );
}
