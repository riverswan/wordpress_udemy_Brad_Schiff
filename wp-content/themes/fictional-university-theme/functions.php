<?php declare( strict_types=1 );

function university_files() {
	wp_enqueue_script( 'main-university-js', get_theme_file_uri( 'js/scripts-bundled.js' ), null, '1.0', true );
	wp_enqueue_style( 'custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i' );
	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
	wp_enqueue_style( 'university_main_styles', get_stylesheet_uri() );
}

add_action( 'wp_enqueue_scripts', 'university_files' );

function university_features() {
	register_nav_menu( 'header_menu_location', 'Header Menu Location' );
	register_nav_menu( 'footer_location_one', 'Footer Location One' );
	register_nav_menu( 'footer_location_two', 'Footer Location Two' );
	add_theme_support( 'title-tag' );
}

add_action( 'after_setup_theme', 'university_features' );


function university_adjust_queries( $query ) {
	if ( ! is_admin() && is_post_type_archive( 'event' ) && $query->is_main_query() ) {
		$today = \date('Ymd');
		$query->set( 'meta_key', 'event_date' );
		$query->set( 'orderby', 'meta_value_num' );
		$query->set( 'order', 'ASC' );
		$query->set( 'meta_query', array(
			array(
				'key'     => 'event_date',
				'compare' => '>=',
				'value'   => $today,
				'type'    => 'numeric'
			)
		) );
	}
}

add_action( 'pre_get_posts', 'university_adjust_queries' );


add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);

function special_nav_class ($classes, $item) {
	if (in_array('current-menu-item', $classes) ){
		$classes[] = 'current-menu-item active';
	}
	return $classes;
}
