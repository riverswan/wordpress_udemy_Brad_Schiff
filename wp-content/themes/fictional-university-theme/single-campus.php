<?php declare( strict_types=1 );
get_header();
while ( have_posts() ) {
	the_post(); ?>

	<div class="page-banner">
		<div class="page-banner__bg-image"
		     style="background-image: url(<?php echo get_theme_file_uri( '/images/ocean.jpg' ) ?>);"></div>
		<div class="page-banner__content container container--narrow">
			<h1 class="page-banner__title">
				<?php the_title() ?>
			</h1>
			<div class="page-banner__intro">
				<?php echo 'DON\'T FORGET TO REPLACE ME LATER' ?>
			</div>
		</div>
	</div>
	<div class="container container--narrow page-section">
		<div class="metabox metabox--position-up metabox--with-home-link">
			<p>
				<a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link( 'program' ) ?>">
					<i class="fa fa-home" aria-hidden="true">
					</i> All Programs
				</a>
				<span class="metabox__main">
					<?php the_title() ?>
                     </span>
			</p>
		</div>
		<div class="generic-content"><?php the_content(); ?></div>
		<?php

		$related_professors = new WP_Query( array(
			'post_type'      => 'professor',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
			'meta_query'     => array(
				array(
					'key'     => 'related_programs',
					'compare' => 'LIKE',
					'value'   => '"' . get_the_ID() . '"',
				)
			)
		) );


		if ($related_professors->have_posts()) {
			echo '<hr class="section-break"/>';
			echo '<h2 class="headline headline--medium ">'. get_the_title() .' Professors</h2>';
			echo '<ul class="professor-cards">';
			while ( $related_professors->have_posts() ) {
				$related_professors->the_post();
				?>
				<li class="professor-card__list-item">
					<a class="professor-card" href="<?php the_permalink(); ?>">
						<img src="<?php the_post_thumbnail_url('professor_landscape'); ?>" alt="123" class="professor-card__image">
						<span class="professor-card__name"><?php the_title() ?></span>
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