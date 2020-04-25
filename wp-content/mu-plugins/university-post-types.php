<?php
function university_post_types() {
	register_post_type( 'event', array(
		'has_archive'       => true,
		'public'            => true,
		'labels'            => array(
			'name'          => 'Events',
			'add_new_item'  => 'Add New Event',
			'edit_item'     => 'Edit Event',
			'all_items'     => 'All Events',
			'singular_name' => 'Event'
		),
		'menu_icon'         => 'dashicons-calendar',
		'show_in_admin_bar' => true,
		'rewrite' => array(
			'slug' => 'events'
		),
		'supports' => array(
			'title','editor','excerpt',
		)
	) );

	register_post_type( 'program', array(
		'has_archive'       => true,
		'public'            => true,
		'labels'            => array(
			'name'          => 'Programs',
			'add_new_item'  => 'Add New Program',
			'edit_item'     => 'Edit Program',
			'all_items'     => 'All Programs',
			'singular_name' => 'Event'
		),
		'menu_icon'         => 'dashicons-calendar',
		'show_in_admin_bar' => true,
		'rewrite' => array(
			'slug' => 'programs'
		),
		'supports' => array(
			'title','editor',
		)
	) );


	register_post_type( 'professor', array(
		'has_archive'       => false,
		'public'            => true,
		'labels'            => array(
			'name'          => 'Professors',
			'add_new_item'  => 'Add New Professor',
			'edit_item'     => 'Edit Professor',
			'all_items'     => 'All Professors',
			'singular_name' => 'Event'
		),
		'menu_icon'         => 'dashicons-welcome-learn-more',
		'show_in_admin_bar' => true,
		'supports' => array(
			'title','editor','thumbnail'
		)
	) );


	
	
	
}

add_action( 'init', 'university_post_types' );