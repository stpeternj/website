<?php
/**
 * Events Widget Template (Homepage)
 *
 * Produces output for appropriate widget class in framework.
 * $this, $instance (sanitized field values) and $args are available.
 * $GLOBALS['ctfw_current_widget'] can be used inside get_template_part();
 *
 * $this->ctfw_get_posts() can be used to produce a query according to widget field values.
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Events page URL
$events_url = ctfw_post_type_archive_url( 'ctc_event' ); // calendar first, upcoming events otherwise, default archive if neither

// Today and tomorrow in local time
$today = date_i18n( 'Y-m-d' );
$today_ts = strtotime( $today );
$tomorrow =  date_i18n( 'Y-m-d', $today_ts + DAY_IN_SECONDS ); // add one day in seconds to today

// Abbreviate date format (from settings)
// Withour args, abbreviates month and removes year from format in settings
$date_format = ctfw_abbreviate_date_format();

// Get posts
$instance['limit'] = 4; // always 4 (setting hidden when used on homepage)
$instance['timeframe'] = 'upcoming'; // setting hidden when used on homepage
$posts = ctfw_get_events( $instance ); // get events based on options - upcoming/past, limit, etc.

// Is this first of all widgets on homepage?
$is_first_widget = ctfw_is_first_widget(); // first widget in section

?>

<section class="saved-colored-section saved-color-main-bg<?php if ( $is_first_widget ) : ?> saved-first-home-widget<?php endif; ?>" <?php echo saved_homepage_section_id_attr(); ?>>

	<div class="saved-colored-section-inner">

		<div class="saved-colored-section-content saved-centered-large">

			<?php if ( $posts ) : ?>

				<div class="saved-colored-section-entries">

					<?php

					// Array of event items.
					$event_items = array();

					// Loop events.
					foreach ( $posts as $post ) {

						setup_postdata( $post );

						// Get data
						// $date (localized range), $start_date, $end_date, $start_time, $end_time, $start_time_formatted, $end_time_formatted, $hide_time_range, $time (description), $time_range, $time_range_and_description, $time_range_or_description, $venue, $address, $show_directions_link, $directions_url, $map_lat, $map_lng, $map_has_coordinates, $map_type, $map_zoom
						// Recurrence fields, $recurrence_note and $recurrence_note_short are also provided as well as $excluded_dates_note (Pro).
						extract( ctfw_event_data( $args ) );

						// Short Date
						// To Do: Consider adding to framework. Events widget on homepage and footer ($image_date) use it - repeating code (only date format is different)
						$short_date = '';
						$short_date_ts = '';

							// Have a start date
							if ( $start_date ) {

								// Start and end dates as local timestamps
								$start_date_ts = strtotime( date_i18n( 'Y-m-d', strtotime( $start_date ) ) );
								$end_date_ts = strtotime( date_i18n( 'Y-m-d', strtotime( $end_date ) ) );

								// Today, tomorrow or date
								if ( $today_ts >= $start_date_ts && $today_ts <= $end_date_ts ) { // start date or any date in range is today

									$short_date = _x( 'Today', 'widget date relative', 'saved' );
									$short_date_ts = $today_ts;

									// This is a multi-day event and today is excluded (Pro).
									$excluded_dates_array = isset( $excluded_dates ) ? explode( ',', $excluded_dates ) : array();
									if ( $start_date && $end_date && $start_date !== $end_date && in_array( $today, $excluded_dates_array ) ) {

										// Get next day in range that is not excluded.
										$check_date = $today;
										$next_date = false;
										while ( $check_date <= $end_date ) {

											// Get next date in range that is not excluded.
											if ( ! in_array( $check_date, $excluded_dates_array ) ) {

												$next_date = $check_date;

												break;

											}

											// Add one day to current date then check again if is excluded.
										 	else {
												$check_date = date_i18n( 'Y-m-d', strtotime( $check_date ) + DAY_IN_SECONDS ); // add one day in seconds to today.
											}

										}

										// Have next date to use in place of today.
										if ( $next_date ) {

											$next_date_ts = strtotime( $next_date );

											if ( $next_date === $tomorrow ) {
												$short_date = _x( 'Tomorrow', 'widget date relative', 'saved' );
											} else {
												$short_date = date_i18n( $date_format, $next_date_ts );
											}

											$short_date_ts = $next_date_ts;

										}

										// No next date available, so don't show event at all.
										else {
											continue;
										}

									}

								} elseif ( $start_date == $tomorrow ) {
									$short_date = _x( 'Tomorrow', 'widget date relative', 'saved' );
									$short_date_ts = $start_date_ts;
								} else {
									$short_date = date_i18n( $date_format, $start_date_ts );
									$short_date_ts = $start_date_ts;
								}

							}

						// Buffer output.
						ob_start();
						?>

							<article <?php post_class( 'saved-colored-section-entry' ); ?>>

								<?php if ( $short_date ) : ?>

									<time class="saved-colored-section-label" datetime="<?php echo esc_attr( date_i18n( 'c', $short_date_ts ) ); ?>">
										<?php echo esc_html( $short_date ); ?>
									</time>

								<?php endif; ?>

								<?php if ( ctfw_has_title() ) : ?>

									<h3 class="saved-colored-section-title">
										<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
									</h3>

								<?php endif; ?>

								<?php if ( $time_range_or_description ) : ?>

									<div class="saved-colored-section-meta">
										<?php echo wptexturize( $time_range_or_description ); // show Time Range if given; otherwise Description (not both) ?>
									</div>

								<?php endif; ?>

							</article>

						<?php

						// Capture output into sortable array.
						$sorting_key = $short_date_ts . '-' . $start_time . '-' . $post->ID; // sort by date and time, with ID for uniqueness.
						$event_items[ $sorting_key ] = ob_get_clean();

					}

					// Sort event items by date/time in case a multi-day event with today excluded caused change of date.
					ksort( $event_items );

					// Output events.
					echo implode( '', $event_items );

					?>

				</div>

				<?php if ( $events_url ) : ?>

					<div class="saved-colored-section-button">

						<a href="<?php echo esc_url( $events_url ); ?>" class="saved-button saved-button-light saved-button-no-hover-line">

							<span class="saved-colored-section-button-full">
								<?php echo esc_html( _x( 'More Events', 'events widget', 'saved' ) ); ?>
							</span>

							<span class="saved-colored-section-button-short">

								<?php
								/* translators: Abbreviated version of "More Events", shows on mobile */
								echo esc_html( _x( 'More', 'events widget', 'saved' ) );
								?>

							</span>

						</a>

					</div>

				<?php endif; ?>

			<?php else : ?>

				<p>
					<?php echo esc_html( _x( 'There are no events to show.', 'events widget', 'saved' ) ); ?>
				</p>

			<?php endif; ?>

		</div>

	</div>

</section>

<?php

// Reset post data
wp_reset_postdata();
