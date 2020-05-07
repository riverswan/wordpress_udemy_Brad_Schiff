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
        <div class="create-note">
            <h2 class="headline--medium headline">Create new note</h2>
            <input type="text" placeholder="Title" class="new-note-title">
            <textarea name="" id="" cols="30" rows="10" placeholder="Your note here" class="new-note-body"></textarea>
            <span class="submit-note">Create Note</span>
        </div>
        <ul class="min-list link-list" id="mynotes">
			<?php
			$user_notes = new WP_Query( array(
				'post_type'      => 'note',
				'posts_per_page' => - 1,
				'author'         => get_current_user_id()
			) );

			while ( $user_notes->have_posts() ) {
				$user_notes->the_post(); ?>

                <li data-id="<?php the_ID(); ?>">
                    <input readonly class="note-title-field" type="text" value="<?php echo str_replace('Private: ','',esc_attr( get_the_title() )) ?>">
                    <span class="edit-note"><i class="fa fa-pencil"></i>Edit</span>
                    <span class="delete-note"><i class="fa fa-trash-o"></i>Delete</span>
                    <textarea readonly class="note-body-field" name="" id="" cols="30"
                              rows="10"><?php echo esc_textarea( get_the_content() ) ?></textarea>
	                <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right"></i>Save</span>
                </li>

				<?php
			}
			?>
        </ul>
    </div>

<?php }

get_footer();