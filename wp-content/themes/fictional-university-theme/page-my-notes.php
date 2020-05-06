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
			) );

			while ( $user_notes->have_posts() ) {
				$user_notes->the_post(); ?>

                <li>
                    <input class="note-title-field" type="text" value="<?php echo esc_attr( get_the_title() ) ?>">
                    <span class="edit-note"><i class="fa fa-pencil"></i>Edit</span>
                    <span class="delete-note"><i class="fa fa-trash-o"></i>Delete</span>
                    <textarea class="note-body-field" name="" id="" cols="30"
                              rows="10"><?php echo esc_attr( get_the_content() ) ?></textarea>
                </li>

				<?php
			}
			?>
        </ul>
    </div>

<?php }

get_footer();