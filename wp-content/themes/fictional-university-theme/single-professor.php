<?php declare( strict_types=1 );
get_header();
while ( have_posts() ) {
	the_post(); ?>

	<?php page_banner() ?>

    <div class="container container--narrow page-section">

        <div class="generic-content">
            <div class="row group">
                <div class="one-third"><?php the_post_thumbnail( 'professor_portrait' ); ?></div>
                <div class="two-thirds">
                    <?php
                        $like_count = new WP_Query(array(
                        	'post_type' => 'like',
	                        'meta_query' => array(
	                        	array(
	                        		'key' => 'like_professor_id',
			                        'compare' => '=',
			                        'value' => get_the_ID()
		                        )
	                        )
                        ));

                        $exist_status = 'no';

                        $exist_query = new WP_Query(array(
                        	'author' => get_current_user_id(),
                        	'post_type' => 'like',
	                        'meta_query' => array(
	                        	array(
	                        		'key' => 'like_professor_id',
			                        'compare' => '=',
			                        'value' => get_the_ID()
		                        )
	                        )
                        ));

                        if ($exist_query->found_posts) {
                        	$exist_status = 'yes';
                        }
                    ?>
                    <span class="like-box" data-exists="<?php echo $exist_status?>">
                        <i class="fa fa-heart-o"></i>
                        <i class="fa fa-heart"></i>
                        <span class="like-count"><?php echo $like_count->found_posts ?></span>
                    </span>
                    <?php the_content(); ?></div>
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