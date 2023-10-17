<?php
/**
 * Location content for:
 *
 * 1. Full / Single
 * 2. Short / Multiple
 */

// No direct access
if (! defined( 'ABSPATH' )) exit;

// Get data
// $address, $show_directions_link, $directions_url, $phone, $times, $map_lat, $map_lng, $map_type, $map_zoom
extract( ctfw_location_data() );

/*************************************
 * 1. FULL / SINGLE
 *************************************/

if (is_singular( get_post_type() )) :

	$google_map = ctfw_google_map( array(
		'latitude'	=> $map_lat,
		'longitude'	=> $map_lng,
		'type'		=> $map_type,
		'zoom'		=> $map_zoom
	) );

?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'resurrect-entry-full resurrect-location-full' ); ?>>

		<?php get_template_part( 'content-location-header' ); ?>

		<?php if ($google_map) : ?>
			<div class="resurrect-location-full-map">
				<?php echo $google_map; ?>
			</div>
		<?php endif; ?>

		<?php if ($directions_url) : ?>
			<div class="resurrect-location-full-direction">
				<a href="<?php echo esc_url( $directions_url ); ?>" target="_blank" rel="noopener noreferrer" class="resurrect-button">
					<span class="<?php resurrect_icon_class( 'location-directions' ); ?> resurrect-button-icon"></span>
					<?php _ex( 'Get Directions', 'location', 'resurrect' ); ?>
				</a>
			</div>
		<?php endif; ?>

		<?php if (ctfw_has_content()) : // might not be any content, so let header sit flush with bottom ?>
			<div class="resurrect-entry-content resurrect-clearfix">

				<?php the_content(); ?>

				<?php do_action( 'resurrect_after_content' ); ?>

			</div>
		<?php endif; ?>

		<?php get_template_part( 'content-footer-full' ); // multipage nav, term lists, "Edit" button, etc. ?>

	</article>

<?php

/*************************************
 * 2. SHORT / MULTIPLE
 *************************************/

else :

?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'resurrect-entry-short resurrect-location-short' ); ?>>

		<?php get_template_part( 'content-location-header' ); ?>

		<?php if (ctfw_has_excerpt() || ctfw_has_more_tag()) : ?>
			<div class="resurrect-entry-content resurrect-clearfix">
				<?php resurrect_short_content(); // output excerpt or post content up until <!--more--> quicktag used ?>
			</div>
		<?php endif; ?>

		<?php get_template_part( 'content-footer-short' ); // show appropriate button(s) ?>

	</article>

<?php endif; ?>
