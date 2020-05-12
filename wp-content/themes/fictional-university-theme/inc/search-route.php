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
				'permalink' => get_the_permalink(),
				'image'     => get_the_post_thumbnail_url( 0, 'professor_landscape' ),
			) );
		}

		if ( get_post_type() === 'program' ) {
			$related_campuses = get_field( 'related_campuses' );
			if ( $related_campuses ) {
				foreach ( $related_campuses as $related_campus ) {
					array_push( $results['campus'], array(
						'title'     => get_the_title( $related_campus ),
						'permalink' => get_the_permalink( $related_campus )
					) );
				}
			}
			array_push( $results['program'], array(
				'title'     => get_the_title(),
				'permalink' => get_the_permalink(),
				'id'        => get_the_ID()
			) );
		}

		if ( get_post_type() === 'event' ) {
			$eventDate   = new DateTime( get_field( 'event_date' ) );
			$description = null;
			if ( has_excerpt() ) {
				$description = get_the_excerpt();
			} else {
				$description = wp_trim_words( get_the_content(), 10 );
			}

			array_push( $results['event'], array(
				'title'       => get_the_title(),
				'permalink'   => get_the_permalink(),
				'month'       => $eventDate->format( 'M' ),
				'day'         => $eventDate->format( 'd' ),
				'description' => $description
			) );
		}

		if ( get_post_type() === 'campus' ) {
			array_push( $results['campus'], array(
				'title'     => get_the_title(),
				'permalink' => get_the_permalink()
			) );
		}

	}

	if ( $results['program'] ) {
		$programs_meta_query = array(
			'relation' => 'OR'
		);

		foreach ( $results['program'] as $result ) {
			array_push( $programs_meta_query, array(
				'key'     => 'related_programs',
				'compare' => 'LIKE',
				'value'   => '"' . $result['id'] . '"'
			) );
		}

		$program_relationship_query = new WP_Query( array(
			'post_type'  => array( 'professor', 'event' ),
			'meta_query' => $programs_meta_query
		) );

		while ( $program_relationship_query->have_posts() ) {
			$program_relationship_query->the_post();

			if ( get_post_type() === 'professor' ) {
				array_push( $results['professor'], array(
					'title'     => get_the_title(),
					'permalink' => get_the_permalink(),
					'image'     => get_the_post_thumbnail_url( 0, 'professor_landscape' )
				) );
			}

			if ( get_post_type() === 'event' ) {
				$eventDate   = new DateTime( get_field( 'event_date' ) );
				$description = null;
				if ( has_excerpt() ) {
					$description = get_the_excerpt();
				} else {
					$description = wp_trim_words( get_the_content(), 10 );
				}

				array_push( $results['event'], array(
					'title'       => get_the_title(),
					'permalink'   => get_the_permalink(),
					'month'       => $eventDate->format( 'M' ),
					'day'         => $eventDate->format( 'd' ),
					'description' => $description
				) );
			}

		}

		$results['professor'] = array_values( array_unique( $results['professor'], SORT_REGULAR ) );
		$results['event']     = array_values( array_unique( $results['event'], SORT_REGULAR ) );

	}


	return $results;
}