<?php declare( strict_types=1 );


add_action('rest_api_init','university_like_routes');

function university_like_routes(){
	register_rest_route('university/v1','manageLike',array(
		'methods' => WP_REST_Server::CREATABLE,
		'callback' => 'create_like'
	));

	register_rest_route('university/v1','manageLike',array(
		'methods' => WP_REST_Server::DELETABLE,
		'callback' => 'delete_like'
	));
}

function create_like(){
	wp_insert_post(array(
		'post_type' => 'like',
		'post_status' => 'publish',
		'post_title' => '2 Our PHP test',
		'meta_input' => array(
			'like_professor_id' => 1234
		)
	));
}

function delete_like(){
	return 'like deleted';
}
