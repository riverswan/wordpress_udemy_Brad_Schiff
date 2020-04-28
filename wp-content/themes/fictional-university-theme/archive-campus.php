<?php
get_header();
page_banner(array('title' => 'All Campuses','subtitle'=>'Several campuses   '));
?>


	<div class="container container--narrow page-section">
		<ul class="link-list min-list">
			<?php while ( have_posts() ) {
				the_post();
				$map_location = get_field('map_location')
				?>

				<div data-lat="<?php echo $map_location['lat'] ?>" data-lng="<?php echo $map_location['lng'] ?>" class="marker"></div>

			<?php }
			echo paginate_links();
			?>
		</ul>
	</div>

<?php get_footer();