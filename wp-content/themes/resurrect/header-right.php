<?php
/**
 * Header Right Content
 *
 * This is loaded by header.php.
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

global $post;

// Which content to show
$header_right = ctfw_customization( 'header_right' );

// Sermons, events or posts
if ( in_array( $header_right, array( 'sermons', 'events', 'posts' ) ) ) :

?>

	<?php

	// Get and sanitize limit
	$max_limit = 2;
	$limit = absint( ctfw_customization( 'header_right_items_limit' ) );
	if ( $limit > $max_limit ) {
		$limit = $max_limit;
	}

	// Get date format
	$date_format = get_option( 'date_format' );

	// Today, tomorrow and yetserday in local time
	$today = date_i18n( 'Y-m-d' );
	$today_ts = strtotime( $today );
	$tomorrow =  date_i18n( 'Y-m-d', $today_ts + DAY_IN_SECONDS ); // add one day in seconds to today
	$yesterday =  date_i18n( 'Y-m-d', $today_ts - DAY_IN_SECONDS ); // subtract one day in seconds from today

	// Get sermons, events or posts
	if ( 'sermons' == $header_right ) {
		$items = get_posts( array(
			'post_type'       	=> 'ctc_sermon',
			'orderby'         	=> 'publish_date',
			'order'           	=> 'desc',
			'numberposts'     	=> $limit,
			'suppress_filters'	=> false // keep WPML from showing posts from all languages: http://bit.ly/I1JIlV + http://bit.ly/1f9GZ7D
		) );
	} elseif ( 'events' == $header_right ) {
		$items = ctfw_get_events( array(
			'timeframe'	=> 'upcoming',
			'limit'	=> $limit,
		) );
	} elseif ( 'posts' == $header_right ) {
		$items = get_posts( array(
			'post_type'       	=> 'post',
			'orderby'         	=> 'publish_date',
			'order'           	=> 'desc',
			'numberposts'     	=> $limit,
			'suppress_filters'	=> false // keep WPML from showing posts from all languages: http://bit.ly/I1JIlV + http://bit.ly/1f9GZ7D
		) );
	}

	?>

	<div id="resurrect-header-right-items" class="resurrect-header-right-items-count-<?php esc_attr( $limit ); ?> resurrect-clearfix">

		<?php

		// Loop posts
		$old_post = $post;
		foreach ( $items as $post ) :

			// Make the_title() , the_permalink() and so on work
			setup_postdata( $post );

			// Prepare date
			$show_date = '';
			$publish_date = date_i18n( 'Y-m-d', strtotime( $post->post_date ) );
			if ( in_array( $header_right, array( 'sermons', 'posts' ) ) ) { // sermon or post

				// Today, yesterday or date
				if ( $today == $publish_date ) {
					$show_date = _x( 'Today', 'header right items', 'resurrect' );
				} elseif ( $yesterday == $publish_date ) {
					$show_date = _x( 'Yesterday', 'header right items', 'resurrect' );
				} else {
					$show_date = get_the_date( 'F j' );
				}

			} elseif ( 'events' == $header_right ) { // event

				// Get date range
				$start_date = get_post_meta( $post->ID , '_ctc_event_start_date' , true );
				$end_date = get_post_meta( $post->ID , '_ctc_event_end_date' , true );

				// Have a start date
				if ( $start_date ) {

					// Start and end dates as local timestamps
					$start_date_ts = strtotime( date_i18n( 'Y-m-d', strtotime( $start_date ) ) );
					$end_date_ts = strtotime( date_i18n( 'Y-m-d', strtotime( $end_date ) ) );

					// Today, tomorrow or date
					if ( $today_ts >= $start_date_ts && $today_ts <= $end_date_ts ) { // start date or any date in range is today
						$show_date = _x( 'Today', 'header right items', 'resurrect' );
					} elseif ( $start_date == $tomorrow ) {
						$show_date = _x( 'Tomorrow', 'header right items', 'resurrect' );
					} else {
						/* translators: see date formatting documentation: http://codex.wordpress.org/Formatting_Date_and_Time */
						$show_date = date_i18n( _x( 'F j', 'header right items', 'resurrect' ), strtotime( $start_date ) );
					}

				}

			}

		?>

		<article class="resurrect-header-right-item">

			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">

				<span class="resurrect-header-right-item-title"><?php echo ctfw_shorten( get_the_title(), 32 ); // shorten title without truncating words ?></span>

				<?php if ( $show_date ) : ?>
					<span class="resurrect-header-right-item-date">
						<?php echo esc_html( $show_date ); ?>
					</span>
				<?php endif; ?>

			</a>

		</article>

		<?php

		// End Loop
		endforeach;

		// Restore $post global
		wp_reset_postdata();
		$post = $old_post; // wp_reset_postdata() is not enough with this code

		?>

	</div>

<?php

// Tagline on right
elseif ( 'tagline' == $header_right ) :

?>

	<div id="resurrect-header-right-tagline" class="resurrect-tagline">
		<?php bloginfo( 'description' ); ?>
	</div>

<?php

// Custom Content
elseif ( 'content' == $header_right ) :

?>

	<div id="resurrect-header-custom-content">
		<?php echo wpautop( wptexturize( do_shortcode( ctfw_customization( 'header_right_content' ) ) ) ); ?>
	</div>

<?php endif; ?>
