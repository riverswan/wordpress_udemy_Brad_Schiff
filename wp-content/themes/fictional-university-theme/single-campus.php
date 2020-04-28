<?php declare( strict_types=1 );
get_header();
while ( have_posts() ) {
	the_post();
	page_banner();
	?>

	<div class="container container--narrow page-section">
		<div class="metabox metabox--position-up metabox--with-home-link">
			<p>
				<a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link( 'campus' ) ?>">
					<i class="fa fa-home" aria-hidden="true">
					</i> All Campuses
				</a>
				<span class="metabox__main">
					<?php the_title() ?>
                     </span>
			</p>
		</div>
		<div class="generic-content"><?php the_content(); ?></div>
		<div class="container container--narrow page-section">
			<div class="acf-map">
				<?php $map_location = get_field('map_location') ?>

				<div data-lat="<?php echo $map_location['lat'] ?>" data-lng="<?php echo $map_location['lng'] ?>" class="marker">
					<h3><?php the_title() ?></h3>
					<?php echo $map_location['address'] ?>
				</div>
			</div>
		</div>
		<?php

		$related_programs = new WP_Query( array(
			'post_type'      => 'program',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
			'meta_query'     => array(
				array(
					'key'     => 'related_campuses',
					'compare' => 'LIKE',
					'value'   => '"' . get_the_ID() . '"',
				)
			)
		) );


		if ($related_programs->have_posts()) {
			echo '<hr class="section-break"/>';
			echo '<h2 class="headline headline--medium ">Programs available at this campus</h2>';
			echo '<ul class="min-list link-list">';
			while ( $related_programs->have_posts() ) {
				$related_programs->the_post();
				?>
				<li >
					<a href="<?php the_permalink(); ?>">
						<?php the_title() ?>
					</a>
				</li>
				<?php

			}
			wp_reset_postdata();
			echo '</ul>';
		}
		?>

		<?php


		$today          = date( 'Ymd' );
		$homePageEvents = new WP_Query( array(
			'post_type'      => 'event',
			'posts_per_page' => 2,
			'meta_key'       => 'event_date',
			'orderby'        => 'meta_value_num',
			'order'          => 'ASC',
			'meta_query'     => array(
				array(
					'key'     => 'event_date',
					'compare' => '>=',
					'value'   => $today,
					'type'    => 'numeric'
				),
				array(
					'key'     => 'related_programs',
					'compare' => 'LIKE',
					'value'   => '"' . get_the_ID() . '"',
				)
			)
		) );


		if ($homePageEvents->have_posts()) {
			echo '<hr class="section-break"/>';
			echo '<h2 class="headline headline--medium ">Upcoming '. get_the_title() .' Event</h2>';
			while ( $homePageEvents->have_posts() ) {
				$homePageEvents->the_post();
				get_template_part('/template-parts/event');
			}
			wp_reset_postdata();
		}
		?>
	</div>

<?php }
get_footer();