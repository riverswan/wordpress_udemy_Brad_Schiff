<?php
require get_theme_file_path( '/inc/search-route.php' );
require get_theme_file_path( '/inc/like-route.php' );

add_action( 'rest_api_init', 'university_custom_rest' );
function university_custom_rest() {
	register_rest_field( 'post', 'author_name', array(
		'get_callback' => function () {
			return get_the_author();
		}
	) );

	register_rest_field( 'note', 'notes_count', array(
		'get_callback' => function () {
			return count_user_posts( get_current_user_id(), 'note' );
		}
	) );
}

function university_files() {
	wp_enqueue_script( 'google-map', '//maps.googleapis.com/maps/api/js?key=AIzaSyAY1G5SCCspxFA3TDujQuGlDW5I4EwzIcY', null, '1.0', true );
	wp_enqueue_script( 'main-university-js', get_theme_file_uri( 'js/scripts-bundled.js' ), null, '1.0', true );
	wp_enqueue_style( 'custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i' );
	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
	wp_enqueue_style( 'university_main_styles', get_stylesheet_uri() );

	// add some properties to js script
	wp_localize_script( 'main-university-js', 'universityData', array(
		'root_url' => get_site_url(),
		'nonce'    => wp_create_nonce( 'wp_rest' )
	) );
}

add_action( 'wp_enqueue_scripts', 'university_files' );

function university_features() {
	register_nav_menu( 'header_menu_location', 'Header Menu Location' );
	register_nav_menu( 'footer_location_one', 'Footer Location One' );
	register_nav_menu( 'footer_location_two', 'Footer Location Two' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'professor_landscape', 400, 260, true );
	add_image_size( 'professor_portrait', 480, 650, true );
	add_image_size( 'page_banner', 1500, 350, true );
}

add_action( 'after_setup_theme', 'university_features' );


function university_adjust_queries( $query ) {

	if ( ! is_admin() && is_post_type_archive( 'program' ) && $query->is_main_query() ) {
		$query->set( 'posts_per_page', - 1 );
	}

	if ( ! is_admin() && is_post_type_archive( 'campus' ) && $query->is_main_query() ) {
		$query->set( 'orderby', 'title' );
		$query->set( 'order', 'ASC' );
		$query->set( 'posts_per_page', - 1 );
	}

	if ( ! is_admin() && is_post_type_archive( 'event' ) && $query->is_main_query() ) {
		$today = date( 'Ymd' );
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


add_filter( 'nav_menu_css_class', 'special_nav_class', 10, 2 );

function special_nav_class( $classes, $item ) {
	if ( in_array( 'current-menu-item', $classes ) ) {
		$classes[] = 'current-menu-item active';
	}

	return $classes;
}


function page_banner( $args = array() ) {
	if ( ! $args['title'] ) {
		$args['title'] = get_the_title();
	}

	if ( ! $args['subtitle'] ) {
		$args['subtitle'] = get_field( 'page_banner_subtitle' );
	}

	if ( ! $args['photo'] ) {
		if ( get_field( 'page_banner_background_image' ) ) {
			$args['photo'] = get_field( 'page_banner_background_image' )['sizes']['page_banner'];
		} else {
			$args['photo'] = get_theme_file_uri( '/images/ocean.jpg' );
		}
	}
	?>
    <div class="page-banner">
        <div class="page-banner__bg-image"
             style="background-image: url(<?php
		     echo $args['photo'];
		     ?>);"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title">
				<?php echo $args['title'] ?>
            </h1>
            <div class="page-banner__intro">
				<?php echo $args['subtitle'] ?>
            </div>
        </div>
    </div>
	<?php
}

add_filter( 'acf/fields/google_map/api', 'university_map_key' );

function university_map_key( $api ) {
	$api['key'] = 'AIzaSyAY1G5SCCspxFA3TDujQuGlDW5I4EwzIcY';

	return $api;
}

add_action( 'admin_init', 'redirect_subs_to_frontend' );

function redirect_subs_to_frontend() {
	$curr_user = wp_get_current_user();
	if ( count( $curr_user->roles ) === 1 && $curr_user->roles[0] === 'subscriber' ) {
		wp_redirect( site_url( '/' ) );
		exit();
	}
}

add_action( 'wp_loaded', 'no_admin_bar' );

function no_admin_bar() {
	$curr_user = wp_get_current_user();
	if ( count( $curr_user->roles ) === 1 && $curr_user->roles[0] === 'subscriber' ) {
		show_admin_bar( false );
	}
}


add_filter( 'login_headerurl', 'our_header_url' );

function our_header_url() {
	return esc_url( site_url( '/' ) );
}

add_action( 'login_enqueue_scripts', 'our_login_css' );

function our_login_css() {
	wp_enqueue_style( 'university_main_styles', get_stylesheet_uri() );
	wp_enqueue_style( 'custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i' );
}


add_filter( 'login_headertitle', 'our_login_title' );

function our_login_title() {
	return get_bloginfo( 'name' );
}


add_filter( 'wp_insert_post_data', 'make_note_private', 10, 2 );

function make_note_private( $data, $post_array ) {
	if ( $data['post_type'] === 'note' ) {
		if ( count_user_posts( get_current_user_id(), 'note' ) > 5 && ! $post_array['ID'] ) {
			die( 'You have reached note limit' );
		}
		$data['post_content'] = sanitize_textarea_field( $data['post_content'] );
		$data['post_title']   = sanitize_text_field( $data['post_title'] );
	}

	if ( $data['post_type'] === 'note' && $data['post_status'] !== 'trash' ) {
		$data['post_status'] = 'private';
	}

	return $data;
}

/*---------------------------------------------*/

function add_style_select_buttons( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
// Register our callback to the appropriate filter
add_filter( 'mce_buttons_2', 'add_style_select_buttons' );

//add custom styles to the WordPress editor
function my_custom_styles( $init_array ) {

	$style_formats = array(
		// These are the custom styles
		array(
			'title' => 'Bold',
			'block' => 'span',
			'classes' => 'bold',
			'wrapper' => true,
		)
	);
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = json_encode( $style_formats );

	return $init_array;

}
// Attach callback to 'tiny_mce_before_init'
add_filter( 'tiny_mce_before_init', 'my_custom_styles' );


function custom_editor_styles() {
	add_editor_style('css/base/baseline.css');
}

add_action('init', 'custom_editor_styles');
