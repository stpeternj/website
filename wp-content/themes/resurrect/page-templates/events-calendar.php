<?php
/**
 * Template Name: Events - Calendar
 *
 * This shows a page with monthly calendar.
 *
 * See theme support feature for 'ctfw-event-calendar-redirection'
 *
 * content.php outputs the page content.
 */

// No direct access
if (! defined( 'ABSPATH' )) exit;

// Prepare calendar content to output
function resurrect_calendar_after_content() {

	global $post;

	// Event post type must be supported.
	if (! post_type_exists( 'ctc_event' )) {
		return;
	}

	// Get month/year and category from URL
	$year_month_query = isset( $_GET['month'] ) ? $_GET['month'] : ''; // default will be this month
	$category_query = isset( $_GET['category'] ) ? $_GET['category'] : ''; // default is empty (all)

	// Get calendar data
	$calendar = ctfw_event_calendar_data( array(
		'year_month' => $year_month_query,
		'category' => $category_query,
	) );

	// Get month data
	// $year_month, $year, $month (without leading 0), $month_ts (first day of month), $prev_month, $next_month
	extract( $calendar['month_data'] );

	// Get today
	// Useful for highlighting current day on calendar
	$today = date_i18n( 'Y-m-d' );
	//$today = '2015-08-31'; // debug
	$today_ts = strtotime( $today );
	$today_month = date_i18n( 'Y-m', $today_ts );
	$today_month_ts = strtotime( $today_month );

	// This year and month
	$this_year = date_i18n( 'Y' );
	$this_month = date_i18n( 'm', $today_ts );
	$this_year_month = date_i18n( 'Y-m', $today_ts );
	$this_month_ts = strtotime( $this_year_month );

	// Next year
	// This limits 'Next' button and month selector
	// Users can only view months through the next full year
	$next_year = $this_year + 1;

	// Month name
	/* translators: F is month; Y is year for calendar title (uses PHP date format) */
	$month_name = date_i18n( _x( 'F Y', 'event calendar', 'resurrect' ), $month_ts );

	// Date format
	$date_format = get_option( 'date_format' );

	// Category handling
	$categories = array();
	$category = array();
	$category_chosen = false;
	$categories_enabled = false; // taxonomy supported and there are categories with events
	if (function_exists( 'ctc_taxonomy_supported' ) && ctc_taxonomy_supported( 'events', 'ctc_event_category' )) { // theme may not support it; or old plugin version

		// Get categories (excludes those w/no posts by default)
		// Used for showing dropdown control
		$categories = get_terms( 'ctc_event_category', array(
			'parent' => 0, // top-level categories only
		) );

		// Have at least one category?
		// If so then we can show the category selector
		if ($categories) {

			// Category selector can be shown
			$categories_enabled = true;

			// Get category slug from URL
			$category_slug = isset( $_GET['category'] ) ? trim( $_GET['category'] ) : '';

			// Show a specific category
			if ($category_slug) {

				// Get taxonomy yerm
				$category = get_term_by( 'slug', $category_slug, 'ctc_event_category', ARRAY_A );

				// Have term and name
				if (! empty( $category ) && ! empty( $category['name'] )) {

					// Category filter is being used
					$category_chosen = true;

					// Get name
					$category_name = $category['name'];

				}

			}

		}

	}

	?>

	<div id="resurrect-calendar">

		<section id="resurrect-calendar-month">

			<div id="resurrect-calendar-header" class="resurrect-clearfix">

				<div id="resurrect-calendar-header-left">

					<h2 id="resurrect-calendar-title">

						<span><?php echo $month_name; ?></span>

						<?php if ($category_chosen) : ?>
							<span id="resurrect-calendar-title-category">

								<?php echo $category_name; ?>

								<?php if ($category_chosen) : ?>
									<span id="resurrect-calendar-remove-category">
										<a href="<?php
											// Note: _pjax is removed because it is no needed (this is coming from AJAX request, which is already cached)
											// Explanation : https://github.com/defunkt/jquery-pjax/issues/89
											echo esc_url( remove_query_arg( array( 'category', '_pjax' ) ) );
										?>" class="el-icon-remove resurrect-calendar-control" title="<?php echo esc_attr( _x( 'Remove Category Filter', 'event calendar', 'resurrect' ) ); ?>"></a>
									</span>
								<?php endif; ?>

							</span>
						<?php endif; ?>

					</h2>

				</div>

				<div id="resurrect-calendar-header-right">

					<?php if ($prev_month_ts >= $today_month_ts) : ?>
						<a href="<?php echo esc_url( remove_query_arg( '_pjax', add_query_arg( 'month', $prev_month ) ) ); ?>" class="resurrect-button resurrect-calendar-control" title="<?php echo esc_attr( sprintf( __( 'Previous Month &ndash; %1$s', 'resurrect' ), date_i18n( 'F', $prev_month_ts ) ) ); ?>"><span class="el-icon-chevron-left"></span></a>
					<?php endif; ?>

					<?php if ($year < $next_year || $month < 12) : ?>
						<a href="<?php echo esc_url( remove_query_arg( '_pjax', add_query_arg( 'month', $next_month ) ) ); ?>" class="resurrect-button resurrect-calendar-control" title="<?php echo esc_attr( sprintf( __( 'Next Month &ndash; %1$s', 'resurrect' ), date_i18n( 'F', $next_month_ts ) ) ); ?>"><span class="el-icon-chevron-right"></span></a>
					<?php endif; ?>

					<a href="#" id="resurrect-calendar-month-control" class="resurrect-button resurrect-calendar-dropdown-control" title="<?php echo esc_attr( _x( 'Choose Month', 'event calendar', 'resurrect' ) ); ?>"><span class="el-icon-calendar"></span></a>

					<?php if ($categories_enabled) : ?>
						<a href="#" id="resurrect-calendar-category-control" class="resurrect-button resurrect-calendar-dropdown-control" title="<?php echo esc_attr( _x( 'Choose Category', 'event calendar', 'resurrect' ) ); ?>"><span class="el-icon-folder"></span></a>
					<?php endif; ?>

				</div>

			</div>

			<table id="resurrect-calendar-table">

				<tr class="resurrect-calendar-table-top-row">
					<td colspan="7">
						<div class="resurrect-calendar-table-top"></div>
					</td>
				</tr>

				<tr class="resurrect-calendar-table-header-row">

					<?php foreach ($calendar['days_of_week'] as $day_of_week) : ?>

						<th class="resurrect-calendar-table-header">
							<div class="resurrect-calendar-table-header-content">
								<span class="resurrect-calendar-table-header-full"><?php echo $day_of_week['name']; ?></span>
								<span class="resurrect-calendar-table-header-short"><?php echo $day_of_week['name_short']; ?></span>
							</div>
						</th>

					<?php endforeach; ?>

				</tr>

				<?php foreach ($calendar['weeks'] as $week_of_month => $week) : ?>

					<tr class="<?php

							$week_classes = array();
							$week_classes[] = 'resurrect-calendar-table-week';

							// First week
							if (0 == $week_of_month) {
								$week_classes[] = 'resurrect-calendar-table-week-first';
							}

							echo implode( ' ', $week_classes );

						?>">

						<?php foreach ($week['days'] as $day_of_week => $day) : ?>

							<?php
							$day_of_week_friendly = $day_of_week + 1; // 1 - 7
							$is_today = $today == $day['date'] ? true : false;
							$is_yesterday = date_i18n( 'Y-m-d', $today_ts - DAY_IN_SECONDS ) == $day['date'] ? true : false;
							$is_tomorrow = date_i18n( 'Y-m-d', $today_ts + DAY_IN_SECONDS ) == $day['date'] ? true : false;
							$is_day_previous_week = date_i18n( 'Y-m-d', $today_ts - WEEK_IN_SECONDS ) == $day['date'] ? true : false;
							$is_day_next_week = date_i18n( 'Y-m-d', $today_ts + WEEK_IN_SECONDS ) == $day['date'] ? true : false;
							$is_last_day_of_week = 6 == $day_of_week ? true : false;
							?>

							<td class="<?php

							$day_classes = array();
							$day_classes[] = 'resurrect-calendar-table-day';

							// Day of week (1 - 7)
							$day_classes[] = 'resurrect-calendar-table-day-' . $day_of_week_friendly;

							// Day is in previous or next month
							if ($day['other_month']) {
								$day_classes[] = 'resurrect-calendar-table-day-other-month';
							}

							// Day is today
							if ($is_today) {
								$day_classes[] = 'resurrect-calendar-table-day-today';
							}

							// Day is yesterday
							if ($is_yesterday) {
								$day_classes[] = 'resurrect-calendar-table-day-yesterday';
							}

							// Day is tomorrow
							if ($is_tomorrow) {
								$day_classes[] = 'resurrect-calendar-table-day-tomorrow';
							}

							// Day is previous week
							if ($is_day_previous_week) {
								$day_classes[] = 'resurrect-calendar-table-day-previous-week';
							}

							// Day is next week
							if ($is_day_next_week) {
								$day_classes[] = 'resurrect-calendar-table-day-next-week';
							}

							// Day is last day of week
							if ($is_last_day_of_week) {
								$day_classes[] = 'resurrect-calendar-table-day-last-of-week';
							}

							// Day is in past
							if ($day['date_ts'] < $today_ts) {
								$day_classes[] = 'resurrect-calendar-table-day-past';
							}

							// Has events
							if (! empty( $day['event_ids'] )) {
								$day_classes[] = 'resurrect-calendar-table-day-has-events';
							}

							echo implode( ' ', $day_classes );

						?>" data-date="<?php echo esc_attr( $day['date'] ); ?>" data-date-formatted="<?php echo esc_attr( $day['date_formatted'] ); ?>">

								<div class="resurrect-calendar-table-day-content-container">

									<div class="resurrect-calendar-table-day-content">

										<div class="resurrect-calendar-table-day-heading">

											<?php if ($day['first_of_next_month'] || $day['last_of_previous_month']) : ?>
												<span class="resurrect-calendar-table-day-label"><?php echo date_i18n( 'M', $day['date_ts'] ); ?></span>
											<?php elseif ($is_today) : ?>
												<span class="resurrect-calendar-table-day-label"><?php _ex( 'Today', 'event calendar', 'resurrect' ); ?></span>
											<?php endif; ?>

											<span class="resurrect-calendar-table-day-number">
												<?php echo $day['day']; ?>
											</span>

											<a href="#" class="resurrect-calendar-table-day-number">
												<?php echo $day['day']; ?>
											</a>

										</div>

										<?php if ($day['event_ids'] && $day['date_ts'] >= $today_ts) : ?>

											<ul class="resurrect-calendar-table-day-events">

												<?php foreach ($day['event_ids'] as $event_id) : ?>

													<?php

													// Get event
													$event = $calendar['events'][$event_id];

													// Setup post data
													$post = $event['post'];
													setup_postdata( $post );

													// Extract friendly meta data
													extract( $event['data'] );

													?>

													<li data-event-id="<?php the_ID(); ?>">

														<a href="<?php the_permalink(); ?>" data-event-id="<?php echo the_ID(); ?>"><?php the_title(); ?></a>

														<?php if ($time_range_or_description) : ?>
															<span class="resurrect-calendar-table-day-event-time"><?php echo esc_html( $time_range_or_description ); ?></span>
														<?php endif; ?>

													</li>

												<?php endforeach; ?>

												<?php wp_reset_postdata(); ?>

											</ul>

										<?php endif; ?>

									</div>

								</div>

							</td>

						<?php endforeach; ?>

					</tr>

				<?php endforeach; ?>

				<tr class="resurrect-calendar-table-bottom-row">
					<td colspan="7">
						<div class="resurrect-calendar-table-bottom"></div>
					</td>
				</tr>

			</table>

			<!-- dropdown controls -->

			<div id="resurrect-calendar-month-dropdown" class="resurrect-dropdown resurrect-calendar-dropdown resurrect-dropdown-anchor-right">

		  		<div class="resurrect-dropdown-panel">

			  		<?php
					// Show current and future months through end of next year
					for ($year = $this_year; $year <= $next_year; $year++) :
					?>

			  			<div class="resurrect-calendar-month-dropdown-year"><?php echo $year; ?></div>

			  			<ul class="resurrect-calendar-month-dropdown-months">

				  			<?php for ($month = 1; $month <= 12; $month ++) : ?>

				  				<?php

				  				$month_ts = mktime( 0, 0, 0, $month, 1, $year );
				  				$dropdown_year_month = date_i18n( 'Y-m', $month_ts );

				  				// Is month in past?
				  				$month_is_past = false;
				  				if ($month_ts < $this_month_ts) {
				  					$month_is_past = $month_ts < $this_month_ts;
				  				}

				  				// Hide rows in which all months are past
				  				// This assumes 4 months are shown per row
				  				if ($year == $this_year && ( ( $this_month >= 5 && $month < 5 ) || ( $this_month >= 9 && $month < 9 ) )) {
				  					continue;
				  				}

				  				?>

				  				<li<?php

				  					$classes = array();

				  					// Month is currently selected
					  				if ($dropdown_year_month == $year_month) {
					  					$classes[] = 'resurrect-dropdown-selected';
					  				}

					  				// Month is in past
				  					if ($month_is_past) {
					  					$classes[] = 'resurrect-calendar-month-dropdown-past';
				  					}

					  				if ($classes) {
					  					echo ' class="' . implode( ' ', $classes ) . '"';
					  				}

				  				?>>

				  					<?php if (! $month_is_past) : ?>
										<a href="<?php echo esc_url( remove_query_arg( '_pjax', add_query_arg( 'month', $dropdown_year_month ) ) ); ?>">
									<?php endif; ?>

										<?php echo date_i18n( 'M', $month_ts ); ?>

				  					<?php if (! $month_is_past) : ?>
										</a>
									<?php endif; ?>

				  				</li>

				  			<?php endfor; ?>

				  		</ul>

			  		<?php endfor; ?>

				</div>

			</div>

			<?php if (! empty( $categories )) : ?>

				<div id="resurrect-calendar-category-dropdown" class="resurrect-dropdown resurrect-calendar-dropdown resurrect-dropdown-anchor-right">

					<ul class="resurrect-dropdown-menu">

						<li<?php if (empty( $category )) : ?> class="resurrect-dropdown-selected"<?php endif; ?>>
							<a href="<?php echo esc_url( remove_query_arg( array( 'category', '_pjax' ) ) ); ?>">
								<?php _ex( 'All Categories', 'event calendar', 'resurrect' ); ?>
							</a>
						</li>

						<?php foreach ($categories as $dropdown_category) : ?>

			  				<li<?php

			  					$classes = array();

			  					// Category is currently selected
				  				if (isset( $category['slug'] ) && $category['slug'] == $dropdown_category->slug) {
				  					$classes[] = 'resurrect-dropdown-selected';
				  				}

				  				if ($classes) {
				  					echo ' class="' . implode( ' ', $classes ) . '"';
				  				}

			  				?>>

								<a href="<?php echo esc_url( remove_query_arg( '_pjax', add_query_arg( 'category', $dropdown_category->slug ) ) ); ?>">
									<?php echo esc_html( $dropdown_category->name ); ?>
								</a>

							</li>

						<?php endforeach; ?>

					</ul>

				</div>

			<?php endif; ?>

		</section>

		<section id="resurrect-calendar-list" class="resurrect-clearfix">

			<?php
			// List events to show in hover or mobile view
			foreach ($calendar['events'] as $event) :
			?>

				<?php

				// Setup post data
				$post = $event['post'];
				setup_postdata( $post );

				// Extract friendly meta data
				extract( $event['data'] );

				?>

				<article data-event-id="<?php echo the_ID(); ?>" <?php post_class( 'resurrect-calendar-list-entry' ); ?>>

					<div class="resurrect-calendar-list-entry-content resurrect-clearfix">

						<?php if (has_post_thumbnail()) : ?>
							<div class="resurrect-calendar-list-entry-image">
								<?php resurrect_post_image(); ?>
							</div>
						<?php endif; ?>

						<div class="resurrect-calendar-list-entry-right">

							<?php if (ctfw_has_title()) : ?>
								<h1 class="resurrect-calendar-list-entry-title<?php if (is_singular( get_post_type() )) : ?> resurrect-main-title<?php endif; ?>">
									<?php resurrect_post_title(); // will be linked on short ?>
								</h1>
							<?php endif; ?>

							<?php if ($date || $time || $venue || $address) : ?>

								<ul class="resurrect-calendar-list-entry-meta">

									<?php if ($date) : ?>
										<li class="resurrect-calendar-list-entry-date">
											<?php
											// Empty because this is filled in with localized date from the day cells data-date-formatted attr
											// Otherwise it will only show current instance of recurrence
											//echo esc_html( $date );
											?>
										</li>
									<?php endif; ?>

									<?php if ($time_range_and_description) : ?>
										<li class="resurrect-content-icon resurrect-calendar-list-entry-time">
											<span class="<?php resurrect_icon_class( 'event-time' ); ?>"></span>
											<?php echo nl2br( wptexturize( $time_range_and_description ) ); ?>
										</li>
									<?php endif; ?>

									<?php if ($venue) : ?>
										<li class="resurrect-content-icon resurrect-calendar-list-entry-venue">
											<span class="<?php resurrect_icon_class( 'event-venue' ); ?>"></span>
											<?php echo esc_html( $venue ); ?>
										</li>
									<?php endif; ?>

									<?php if ($address) : ?>
										<li class="resurrect-content-icon resurrect-calendar-list-entry-address">
											<span class="<?php resurrect_icon_class( 'event-address' ); ?>"></span>
											<?php echo nl2br( wptexturize( $address ) ); ?>
										</li>
									<?php endif; ?>

								</ul>

							<?php endif; ?>

							<ul class="resurrect-calendar-list-entry-buttons resurrect-list-buttons">

								<li><a href="<?php the_permalink(); ?>"><?php _ex( 'Details', 'event calendar', 'resurrect' ); ?></a></li><?php

								// Make sure there is no whitespace between items since they are inline-block

								if ($directions_url) :
									?><li><a href="<?php echo esc_url( $directions_url ); ?>" target="_blank" rel="noopener noreferrer"><?php _e( 'Directions', 'resurrect' ); ?></a></li><?php
								endif;

								?>

							</ul>

						</div>

					</div>

				</article>

			<?php endforeach; ?>

			<?php wp_reset_postdata(); ?>

		</section>

	</div>

	<?php

}

// Insert content after the_content() in content.php
add_action( 'resurrect_after_content', 'resurrect_calendar_after_content' );

// Load main template to show the page
locate_template( 'index.php', true );
