<?php/** * Events Widget Template * * Produces output for appropriate widget class in framework. * $this, $instance (sanitized field values) and $args are available. * * $this->ctfw_get_posts() can be used to produce a query according to widget field values. */// No direct accessif ( ! defined( 'ABSPATH' ) ) exit;// HTML Beforeecho $args['before_widget'];// Title$title = apply_filters( 'widget_title', $instance['title'] );if ( ! empty( $title ) ) {	echo $args['before_title'] . $title . $args['after_title'];}// Get posts$posts = ctfw_get_events( $instance ); // get events based on options - upcoming/past, limit, etc.// Loop posts$i = 0;foreach ( $posts as $post ) : setup_postdata( $post ); $i++;	// Get event meta data	// $date (localized range), $start_date, $end_date, $start_time, $end_time, $start_time_formatted, $end_time_formatted, $hide_time_range, $time (description), $time_range, $time_range_and_description, $time_range_or_description, $venue, $address, $show_directions_link, $directions_url, $map_lat, $map_lng, $map_type, $map_zoom	// Recurrence fields, $recurrence_note and $recurrence_note_short are also provided as well as $excluded_dates_note (Pro).	extract( ctfw_event_data() );?><article <?php post_class( 'resurrect-widget-entry resurrect-event-widget-entry resurrect-clearfix' . ( 1 == $i ? ' resurrect-widget-entry-first' : '' ) ); ?>>	<header class="resurrect-clearfix">		<?php if ( $instance['show_image'] && has_post_thumbnail() ) : ?>			<div class="resurrect-widget-entry-thumb">				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'resurrect-thumb-small', array( 'class' => 'resurrect-image' ) ); ?></a>			</div>		<?php endif; ?>		<h1 class="resurrect-widget-entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>		<ul class="resurrect-widget-entry-meta resurrect-clearfix">			<?php if ( $instance['show_date'] && $date ) : ?>				<li class="resurrect-widget-entry-date resurrect-locations-widget-entry-date">					<?php echo esc_html( $date ); ?>				</li>			<?php endif; ?>			<?php if ( $instance['show_time'] && $time_range_or_description ) : ?>				<li class="resurrect-events-widget-entry-time">					<?php echo esc_html( $time_range_or_description ); ?>				</li>			<?php endif; ?>			<?php if ( $instance['show_category'] && $categories = get_the_term_list( $post->ID, 'ctc_event_category', '', __( ', ', 'resurrect' ) ) ) : ?>				<li class="resurrect-events-widget-entry-categories">					<?php echo $categories; ?>				</li>			<?php endif; ?>		</ul>	</header>	<?php if ( get_the_excerpt() && ! empty( $instance['show_excerpt'] )): ?>		<div class="resurrect-widget-entry-content">			<?php the_excerpt(); ?>		</div>	<?php endif; ?></article><?php// End Loopendforeach;// No items foundif ( empty( $posts ) ) {	?>	<div>		<?php _ex( 'There are no events to show.', 'events widget', 'resurrect' ); ?>	</div>	<?php}// HTML Afterecho $args['after_widget'];