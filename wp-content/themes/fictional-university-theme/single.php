<?php declare( strict_types=1 );
get_header();
while ( have_posts() ) {
	the_post(); ?>
	<h1><?php the_title() ?></h1>
	<?php the_content(); ?>
	<?php
}
get_footer();