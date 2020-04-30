<?php declare( strict_types=1 );

add_action( 'rest_api_init', 'university_register_search' );

function university_register_search() {
	register_rest_route( 'university/v1', 'search', array(
		'methods'  => WP_REST_Server::READABLE,
		'callback' => 'university_search_results'
	) );
}

function university_search_results( $data ) {
	$professors = new WP_Query( array(
		'post_type' => array( 'post', 'page', 'professor', 'event', 'program', 'campus' ),
		's'         => sanitize_text_field( $data['term'] )
	) );
	$results    = array(
		'general_info' => array(),
		'professor'    => array(),
		'program'      => array(),
		'event'        => array(),
		'campus'       => array()
	);

	while ( $professors->have_posts() ) {
		$professors->the_post();
		if ( get_post_type() === 'post' || get_post_type() === 'page' ) {
			array_push( $results['general_info'], array(
				'title'       => get_the_title(),
				'permalink'   => get_the_permalink(),
				'post_type'   => get_post_type(),
				'author_name' => get_the_author()
			) );
		}

		if ( get_post_type() === 'professor' ) {
			array_push( $results['professor'], array(
				'title'     => get_the_title(),
				'permalink' => get_the_permalink()
			) );
		}

		if ( get_post_type() === 'program' ) {
			array_push( $results['program'], array(
				'title'     => get_the_title(),
				'permalink' => get_the_permalink()
			) );
		}

		if ( get_post_type() === 'event' ) {
			array_push( $results['event'], array(
				'title'     => get_the_title(),
				'permalink' => get_the_permalink()
			) );
		}

		if ( get_post_type() === 'campus' ) {
			array_push( $results['campus'], array(
				'title'     => get_the_title(),
				'permalink' => get_the_permalink()
			) );
		}

	}

	return $results;
}