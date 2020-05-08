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

function create_like($data){
	if (is_user_logged_in()) {
		$professor = sanitize_text_field( $data['professorId'] );
		$exist_query = new WP_Query(array(
			'author' => get_current_user_id(),
			'post_type' => 'like',
			'meta_query' => array(
				array(
					'key' => 'like_professor_id',
					'compare' => '=',
					'value' => $professor
				)
			)
		));
		if ($exist_query->found_posts === 0  && get_post_type($professor) === 'professor'){
			return wp_insert_post(array(
				'post_type' => 'like',
				'post_status' => 'publish',
				'post_title' => '2 Our PHP test',
				'meta_input' => array(
					'like_professor_id' => $professor
				)
			));
		}else {
			die('Invalid professor id');
		}

	} else {
		die('Only logged in users can create a like');
	}


}

function delete_like(){
	return 'like deleted';
}
