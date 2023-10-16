<?php
/**
 * Events Widget Template
 *
 * Produces output for appropriate widget class in framework.
 * $this, $instance (sanitized field values) and $args are available.
 *
 * $this->ctfw_get_posts() can be used to produce a query according to widget field values.
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// HTML Before
echo $args['before_widget'];

// Title
$title = apply_filters( 'widget_title', $instance['title'] );
if ( ! empty( $title ) ) {
	echo $args['before_title'] . $title . $args['after_title'];
}

// Today and tomorrow in local time
$today = date_i18n( 'Y-m-d' );
$today_ts = strtotime( $today );
$tomorrow =  date_i18n( 'Y-m-d', $today_ts + DAY_IN_SECONDS ); // add one day in seconds to today

// Abbreviate date format (from settings)
// Withour args, abbreviates month and removes year from format in settings
$date_format = ctfw_abbreviate_date_format();

// Get posts
$posts = ctfw_get_events( $instance ); // get events based on options - upcoming/past, limit, etc.

// Loop posts
foreach ( $posts as $post ) : setup_postdata( $post );

	// Get data
	// $date (localized range), $start_date, $end_date, $start_time, $end_time, $start_time_formatted, $end_time_formatted, $hide_time_range, $time (description), $time_range, $time_range_and_description, $time_range_or_description, $venue, $address, $show_directions_link, $directions_url, $map_lat, $map_lng, $map_has_coordinates, $map_type, $map_zoom
	// Recurrence fields, $recurrence_note and $recurrence_note_short are also provided as well as $excluded_dates_note (Pro).
	extract( ctfw_event_data( $args ) );

	// Categories
	$categories = get_the_term_list( $post->ID, 'ctc_event_category', '', __( ', ', 'saved' ) );

	// Show image?
	$show_image = $instance['show_image'] && has_post_thumbnail() ? true : false;

	// Image Date
	// To Do: Consider adding to framework. Events widget on homepage and footer ($image_date) use it - repeating code (only date format is different)
	$image_date = '';
	$image_date_ts = '';
	if ( $show_image ) {

		// Have a start date
		if ( $start_date ) {

			// Start and end dates as local timestamps
			$start_date_ts = strtotime( date_i18n( 'Y-m-d', strtotime( $start_date ) ) );
			$end_date_ts = strtotime( date_i18n( 'Y-m-d', strtotime( $end_date ) ) );

			// Today, tomorrow or date
			if ( $today_ts >= $start_date_ts && $today_ts <= $end_date_ts ) { // start date or any date in range is today
				$image_date = _x( 'Today', 'widget date relative', 'saved' );
				$image_date_ts = $today_ts;
			} elseif ( $start_date == $tomorrow ) {
				$image_date = _x( 'Tomorrow', 'widget date relative', 'saved' );
				$image_date_ts = $start_date_ts;
			} else {
				$image_date = date_i18n( $date_format, $start_date_ts );
				$image_date_ts = $start_date_ts;
			}

		}

	}

	// Show content
	$show_title = ctfw_has_title();
	$show_image_date = $instance['show_date'] && $date && $show_image ? true : false;
	$show_meta_date = $instance['show_date']&& $date && ! $show_image ? true : false;
	$show_time = $instance['show_time'] && $time_range_or_description ? true : false;
	$show_category = $instance['show_category'] && $categories ? true : false;
	$show_meta = $show_meta_date || $show_time || $show_category ? true : false;
	$show_excerpt = get_the_excerpt() && $instance['show_excerpt'] ? true : false;

	// Classes
	$classes = 'saved-event-compact';
	if ( $show_excerpt ) {
		$classes .= ' saved-entry-has-excerpt';
	}

?>

	<article <?php saved_compact_post_classes( array(
		'classes'			=> $classes,
		'widget_instance'	=> $instance,
	) ); ?>>

		<div class="saved-entry-compact-header">

			<?php if ( $show_image ) : ?>

				<div class="saved-entry-compact-image saved-hover-image">

					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<?php the_post_thumbnail( 'saved-rect-small' ); ?>
					</a>

					<?php if ( $show_image_date ) : ?>
						<time datetime="<?php echo esc_attr( date_i18n( 'c', $image_date_ts ) ); ?>"><?php echo esc_html( $image_date ); ?></time>
					<?php endif; ?>

				</div>

			<?php endif; ?>

			<?php if ( $show_title || $show_meta ) : ?>

				<div class="saved-entry-compact-right">

					<?php if ( ctfw_has_title() ) : ?>

						<h3>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						</h3>

					<?php endif; ?>

					<?php if ( $show_meta ) : ?>

						<ul class="saved-entry-meta saved-entry-compact-meta">

							<?php if ( $show_meta_date ) : ?>
								<li class="saved-event-compact-date">
									<?php echo esc_html( $date ); ?>
								</li>
							<?php endif; ?>

							<?php if ( $show_time ) : ?>
								<li class="saved-event-compact-time">
									<?php echo wptexturize( $time_range_or_description ); // show Time Range if given; otherwise Description (not both) ?>
								</li>
							<?php endif; ?>

							<?php if ( $show_category ) : ?>
								<li class="saved-event-compact-category">
									<?php echo $categories; ?>
								</li>
							<?php endif; ?>

						</ul>

					<?php endif; ?>

				</div>

			<?php endif; ?>

		</div>

		<?php if ( $show_excerpt ) : ?>

			<div class="saved-entry-content saved-entry-content-compact">
				<?php saved_entry_widget_excerpt(); ?>
			</div>

		<?php endif; ?>

	</article>

<?php

// End Loop
endforeach;

// Reset post data
wp_reset_postdata();

// No items found
if ( empty( $posts ) ) {

	?>
	<div>
		<?php echo esc_html( _x( 'There are no events to show.', 'events widget', 'saved' ) ); ?>
	</div>
	<?php

}

// HTML After
echo $args['after_widget'];