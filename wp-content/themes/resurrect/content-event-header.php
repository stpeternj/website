<?php
/**
 * Post Header Meta (Full and Short)
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Get data
// $date (localized range), $start_date, $end_date, $start_time, $end_time, $start_time_formatted, $end_time_formatted, $hide_time_range, $time (description), $time_range, $time_range_and_description, $time_range_or_description, $venue, $address, $show_directions_link, $directions_url, $map_lat, $map_lng, $map_type, $map_zoom
// Recurrence fields, $recurrence_note and $recurrence_note_short are also provided as well as $excluded_dates_note (Pro).
extract( ctfw_event_data() );

?>

<header class="resurrect-entry-header resurrect-clearfix">

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="resurrect-entry-image">
			<?php resurrect_post_image(); ?>
		</div>
	<?php endif; ?>

	<div class="resurrect-entry-title-meta">

		<?php if ( ctfw_has_title() ) : ?>
			<h1 class="resurrect-entry-title<?php if ( is_singular( get_post_type() ) ) : ?> resurrect-main-title<?php endif; ?>">
				<?php resurrect_post_title(); // will be linked on short ?>
			</h1>
		<?php endif; ?>

		<?php if ( $date || $time || $venue || $address ) : ?>

			<ul class="resurrect-entry-meta">

				<?php if ( $date ) : ?>
					<li class="resurrect-entry-date resurrect-event-full-date resurrect-content-icon">
						<span class="<?php resurrect_icon_class( 'event-date' ); ?>"></span>
						<?php echo esc_html( $date ); ?>
					</li>
				<?php endif; ?>

				<?php if ( $recurrence_note && is_singular() ) : // no on list ?>
					<li class="resurrect-content-icon resurrect-event-meta-recurrence">

						<span class="<?php resurrect_icon_class( 'event-recurrence' ); ?>"></span>

						<?php if ( strlen( $recurrence_note ) != strlen( $recurrence_note_short ) ) : ?>

							<a href="#" title="<?php echo esc_attr( $recurrence_note ); ?>">
								<?php echo $recurrence_note_short; ?>
							</a>

						<?php else : ?>
								<?php echo $recurrence_note_short; ?>
						<?php endif; ?>

					</li>
				<?php endif; ?>

				<?php if ( $excluded_dates_note && ! $recurrence_note && is_singular() ) : // no on list and not when showing recurrence note, which itself shows excluded dates. ?>
					<li class="resurrect-content-icon resurrect-event-meta-excluded-dates">

						<span class="<?php resurrect_icon_class( 'event-excluded' ); ?>"></span>

						<a href="#" title="<?php echo esc_attr( $excluded_dates_note ); ?>">
							<?php esc_html_e( 'Excluded Dates', 'resurrect' ); ?>
						</a>

					</li>
				<?php endif; ?>

				<?php if ( $time_range_and_description ) : ?>
					<li class="resurrect-event-full-time resurrect-content-icon">
						<span class="<?php resurrect_icon_class( 'event-time' ); ?>"></span>
						<?php echo nl2br( wptexturize( $time_range_and_description ) ); ?>
					</li>
				<?php endif; ?>

				<?php if ( $venue ) : ?>
					<li class="resurrect-event-full-venue resurrect-content-icon">
						<span class="<?php resurrect_icon_class( 'event-venue' ); ?>"></span>
						<?php echo esc_html( $venue ); ?>
					</li>
				<?php endif; ?>

				<?php if ( $address ) : ?>
					<li class="resurrect-event-full-address resurrect-content-icon">
						<span class="<?php resurrect_icon_class( 'event-address' ); ?>"></span>
						<?php echo nl2br( wptexturize( $address ) ); ?>
					</li>
				<?php endif; ?>

			</ul>

		<?php endif; ?>

	</div>

</header>
