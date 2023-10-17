<?php
/**
 * Event content for:
 *
 * 1. Full / Single
 * 2. Short / Multiple
 */

// No direct access
if (! defined( 'ABSPATH' )) exit;

// Get data
// $date (localized range), $start_date, $end_date, $start_time, $end_time, $start_time_formatted, $end_time_formatted, $hide_time_range, $time (description), $time_range, $time_range_and_description, $time_range_or_description, $venue, $address, $show_directions_link, $directions_url, $map_lat, $map_lng, $map_type, $map_zoom
// Recurrence fields, $recurrence_note and $recurrence_note_short are also provided as well as $excluded_dates_note (Pro).
extract( ctfw_event_data() );

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

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'resurrect-entry-full resurrect-event-full' ); ?>>

		<?php get_template_part( 'content-event-header' ); ?>

		<?php if ($google_map) : ?>
			<div class="resurrect-event-full-map">
				<?php echo $google_map; ?>
			</div>
		<?php endif; ?>

		<?php if ($directions_url || $registration_url) : ?>

			<div id="resurrect-event-buttons">

				<ul class="resurrect-list-buttons">

					<?php

					// Make sure there is no whitespace between items since they are inline-block

					if ($directions_url) :

						?><li>
							<a href="<?php echo esc_url( $directions_url ); ?>" target="_blank" rel="noopener noreferrer">
								<span class="resurrect-button-icon <?php resurrect_icon_class( 'event-directions' ); ?>"></span>
								<?php echo esc_html( _x( 'Get Directions', 'event', 'resurrect' ) ); ?>
							</a>
						</li><?php

					endif;

					if ($registration_url) :

						?><li>
							<a href="<?php echo esc_url( $registration_url ); ?>" target="_blank" rel="noopener noreferrer">
								<span class="resurrect-button-icon <?php resurrect_icon_class( 'event-register' ); ?>"></span>
								<?php echo esc_html( _x( 'Register', 'event', 'resurrect' ) ); ?>
							</a>
						</li><?php

					endif;

					?>

				</ul>

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

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'resurrect-entry-short resurrect-event-short' ); ?>>

		<?php get_template_part( 'content-event-header' ); ?>

		<?php if (ctfw_has_excerpt() || ctfw_has_more_tag()) : ?>
			<div class="resurrect-entry-content resurrect-clearfix">
				<?php resurrect_short_content(); // output excerpt or post content up until <!--more--> quicktag used ?>
			</div>
		<?php endif; ?>

		<?php get_template_part( 'content-footer-short' ); // show appropriate button(s) ?>

	</article>

<?php endif; ?>
