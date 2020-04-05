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
			'title','editor','excerpt'
		)
	) );
}

add_action( 'init', 'university_post_types' );