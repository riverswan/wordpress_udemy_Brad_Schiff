<?php declare( strict_types=1 );
if (!is_user_logged_in()){
	wp_redirect( site_url('/') );
	exit();
}
get_header();
while ( have_posts() ) {
	the_post();
	page_banner(array(
		'title' => 'Notes'
	));
	?>



	<div class="container container--narrow page-section">

	</div>

<?php }

get_footer();