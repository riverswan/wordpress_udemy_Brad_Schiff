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
			'singular_name' => 'program'
		),
		'menu_icon'         => 'dashicons-calendar',
		'show_in_admin_bar' => true,
		'rewrite' => array(
			'slug' => 'programs'
		),
		'supports' => array(
			'title',
		)
	) );


	register_post_type( 'professor', array(
		'show_in_rest' => true,
		'has_archive'       => false,
		'public'            => true,
		'labels'            => array(
			'name'          => 'Professors',
			'add_new_item'  => 'Add New Professor',
			'edit_item'     => 'Edit Professor',
			'all_items'     => 'All Professors',
			'singular_name' => 'professor'
		),
		'menu_icon'         => 'dashicons-welcome-learn-more',
		'show_in_admin_bar' => true,
		'supports' => array(
			'title','editor','thumbnail'
		)
	) );



	register_post_type( 'campus', array(
		'has_archive'       => true,
		'public'            => true,
		'labels'            => array(
			'name'          => 'Campuses',
			'add_new_item'  => 'Add New Campus',
			'edit_item'     => 'Edit Campus',
			'all_items'     => 'All Campuses',
			'singular_name' => 'campus'
		),
		'menu_icon'         => 'dashicons-location-alt',
		'show_in_admin_bar' => true,
		'rewrite' => array(
			'slug' => 'campuses'
		),
		'supports' => array(
			'title','editor','excerpt',
		)
	) );




	register_post_type( 'note', array(
		'capability_type' => 'note',
		'map_meta_cap' => true,
		'show_in_rest'      => true,
		'supports' => array(
			'title','editor'
		),
		'public'            => false,
		'labels'            => array(
			'name'          => 'Notes',
			'add_new_item'  => 'Add New Note',
			'edit_item'     => 'Edit Note',
			'all_items'     => 'All Notes',
			'singular_name' => 'Note'
		),
		'menu_icon'         => 'dashicons-welcome-write-blog',
		'show_ui'           => true,
	) );

	register_post_type( 'like', array(
		'supports' => array(
			'title'
		),
		'public'            => false,
		'labels'            => array(
			'name'          => 'Likes',
			'add_new_item'  => 'Add New Like',
			'edit_item'     => 'Edit Like',
			'all_items'     => 'All Likes',
			'singular_name' => 'Like'
		),
		'menu_icon'         => 'dashicons-heart',
		'show_ui'           => true,
	) );
	
}

add_action( 'init', 'university_post_types' );