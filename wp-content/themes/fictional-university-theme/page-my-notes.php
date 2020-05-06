<?php declare( strict_types=1 );
if ( ! is_user_logged_in() ) {
	wp_redirect( site_url( '/' ) );
	exit();
}
get_header();
while ( have_posts() ) {
	the_post();
	page_banner( array(
		'title' => 'Notes'
	) );
	?>

    <div class="container container--narrow page-section">
        <ul class="min-list link-list" id="mynotes">
			<?php
			$user_notes = new WP_Query( array(
				'post_type'      => 'note',
				'posts_per_page' => - 1,
				'author'         => get_current_user_id()
			) )
			?>
        </ul>
    </div>

<?php }

get_footer();