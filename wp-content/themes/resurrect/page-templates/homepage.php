<?php
/* Template Name: Homepage */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Header
get_header();

// Start loop
while ( have_posts() ) : the_post();

?>

<div id="resurrect-home-content"<?php // adding classes to home content container allows layout to be adjusted via stylesheet

	$home_classes = array();

	// Any slides?
	if ( ! is_active_sidebar( 'ctcom-home-slider' )  ) { // no slides used
		$no_slider = true;
		$home_classes[] = 'resurrect-no-slider';
	}

	// Any highlights?
	if ( ! is_active_sidebar( 'ctcom-home-highlights' )  ) { // no highlights used
		$no_highlights = true;
		$home_classes[] = 'resurrect-no-highlights';
	}

	// Any intro content?
	if ( ! ctfw_has_content() && ! ctfw_has_title() ) { // no home intro used
		$no_intro = true;
		$home_classes[] = 'resurrect-no-intro';
	}

	// Add classes to content container
	if ( ! empty( $home_classes ) ) { // output class attribute and values
		echo ' class="' . implode( ' ', $home_classes ) . '"';
	}

?>>

	<?php if ( empty( $no_slider ) || empty( $no_highlights ) ) : ?>

		<div id="resurrect-slider-boxes" class="resurrect-clearfix">

			<?php if ( empty( $no_slider ) ) : ?>
			<?php get_sidebar( 'home-slider' ); ?>
			<?php endif; ?>

			<?php if ( empty( $no_highlights ) ) : ?>
			<?php get_sidebar( 'home-highlights' ); ?>
			<?php endif; ?>

		</div>

	<?php endif; ?>

	<?php if ( empty( $no_intro ) ) : ?>

		<section id="resurrect-intro"<?php if ( get_the_title() ) : ?> class="resurrect-intro-has-heading"<?php endif; ?>>

			<?php if ( ctfw_has_title() ) : ?>
			<h1 id="resurrect-intro-heading"><?php the_title(); ?></h1>
			<?php endif; ?>

			<?php if ( ctfw_has_content() ) : ?>
			<div id="resurrect-intro-content">
				<?php the_content(); ?>
			</div>
			<?php endif; ?>

		</section>

	<?php endif; ?>

	<?php get_sidebar( 'home-bottom' ); ?>

</div>

<?php

// End loop
endwhile;

// Footer
get_footer();