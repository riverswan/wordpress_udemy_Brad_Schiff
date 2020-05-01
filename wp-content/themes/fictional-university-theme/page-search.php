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

		<?php
		$theParent = wp_get_post_parent_id( get_the_ID() );
		if ( $theParent !== 0 ) : ?>
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <a class="metabox__blog-home-link" href="<?php echo get_permalink( $theParent ) ?>">
                        <i class="fa fa-home" aria-hidden="true">
                        </i> Back to <?php echo get_the_title( $theParent ) ?>
                    </a>
                    <span class="metabox__main">
                         <?php the_title() ?>
                     </span>
                </p>
            </div>
		<?php endif; ?>

		<?php
		$testArray = get_pages(
			array(
				'child_of' => get_the_ID()
			)
		);
		if ( $theParent or $testArray ) : ?>

            <div class="page-links">
                <h2 class="page-links__title"><a
                            href="<?php echo get_permalink( $theParent ) ?>"><?php echo get_the_title( $theParent ) ?></a>
                </h2>
                <ul class="min-list">
					<?php
					$findChildrenOf = 0;
					if ( $theParent !== 0 ) {
						$findChildrenOf = $theParent;
					} else {
						$findChildrenOf = get_the_ID();
					}
					$args = array(
						'title_li'    => null,
						'child_of'    => $findChildrenOf,
						'sort_column' => 'menu_order'
					);
					wp_list_pages( $args );
					?>
                </ul>
            </div>
		<?php endif; ?>
        <div class="generic-content">
            <form action="<?php echo esc_url( site_url( '/' ) ) ?>">
                <input type="search" name="s">
                <input type="submit" value="Search">
            </form>
        </div>

    </div>

<?php }

get_footer();