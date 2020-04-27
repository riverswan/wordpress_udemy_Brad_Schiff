<?php declare( strict_types=1 );
get_header();
while ( have_posts() ) {
	the_post(); ?>

	<?php page_banner() ?>

    <div class="container container--narrow page-section">

        <div class="generic-content">
            <div class="row group">
                <div class="one-third"><?php the_post_thumbnail( 'professor_portrait' ); ?></div>
                <div class="two-thirds"><?php the_content(); ?></div>
            </div>
        </div>


		<?php
		$related_programs = get_field( 'related_programs' );
		if ( $related_programs ) {
			echo '<hr class="section-break"/>';
			echo '<h2 class="headline headline--medium">Subject(s) thought</h2>';
			echo '<hr class="section-break"/>';
			echo '<ul class="link-list min-list">';
			foreach ( $related_programs as $related_program ) { ?>

                <li>
                    <a href="<?php echo get_the_permalink( $related_program ) ?>"><?php echo get_the_title( $related_program ) ?></a>
                </li>

				<?php
			}
			echo '</ul>';
		}
		?>
    </div>

<?php }
get_footer();