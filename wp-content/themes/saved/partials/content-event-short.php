<?php
/**
 * Short Event Content (Archive)
 *
 * This is also used in calendar when hovering or viewing on mobile as list.
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Get data
// $date (localized range), $start_date, $end_date, $start_time, $end_time, $start_time_formatted, $end_time_formatted, $hide_time_range, $time (description), $time_range, $time_range_and_description, $time_range_or_description, $venue, $address, $show_directions_link, $directions_url, $map_lat, $map_lng, $map_has_coordinates, $map_type, $map_zoom, $registration_url
// Recurrence fields, $recurrence_note and $recurrence_note_short are also provided as well as $excluded_dates_note (Pro).
extract( ctfw_event_data( array(
	'abbreviate_month' => true, // abbreviate month (use Dec instead of December by replacing F with M in date_format setting)
) ) );

// Less meta if using widget on homepage
if ( ctfw_is_sidebar( 'ctcom-home' ) ) {
	$recurrence_note_short = '';
}

// Meta
$show_meta = $time_range_or_description || $recurrence_note_short ? true : false;

?>

<article data-event-id="<?php echo the_ID(); ?>" id="post-<?php the_ID(); ?>" <?php saved_short_post_classes( 'saved-event-short' ); ?>>

	<?php if ( $date && ! has_post_thumbnail() ) : ?>

		<div class="saved-entry-short-date saved-entry-short-label">
			<?php echo esc_html( $date ); ?>
		</div>

	<?php endif; ?>

	<?php if ( has_post_thumbnail() ) : ?>

		<div class="saved-entry-short-image saved-hover-image">

			<?php if ( $date ) : ?>

				<div class="saved-entry-short-date saved-entry-short-label">
					<?php echo esc_html( $date ); ?>
				</div>

			<?php endif; ?>

			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail(); ?>
			</a>

		</div>

	<?php endif; ?>

	<div class="saved-entry-short-inner">

		<header class="saved-entry-short-header">

			<?php if ( ctfw_has_title() ) : ?>

				<h2 class="saved-entry-short-title">
					<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute( array( 'echo' => false ) ); ?>"><?php the_title(); ?></a>
				</h2>

			<?php endif; ?>

			<?php if ( $show_meta ) : ?>

				<ul class="saved-entry-meta saved-entry-short-meta">

					<?php if ( $time_range_or_description ) : ?>

						<li class="saved-event-short-time">
							<?php echo wptexturize( $time_range_or_description ); ?>
						</li>

					<?php endif; ?>

					<?php if ( $recurrence_note_short ) : ?>

						<li class="saved-entry-short-recurrence">
							<?php echo esc_html( wptexturize( $recurrence_note_short ) ); ?>
						</li>

					<?php endif; ?>

				</ul>

			<?php endif; ?>

		</header>

		<?php get_template_part( CTFW_THEME_PARTIAL_DIR . '/content-excerpt' ); // show excerpt if no image ?>

	</div>

</article>
