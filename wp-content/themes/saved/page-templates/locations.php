<?php
/**
 * Template Name: Locations
 *
 * This shows a page with custom loop after the content.
 *
 * partials/content-full.php outputs the page content.
 * partials/content-location-short.php outputs content for each post in the loop.
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Query events that ended before today
function saved_locations_loop_after_content() {

	return new WP_Query( array(
		'post_type'			=> 'ctc_location',
		'paged'				=> ctfw_page_num(), // returns/corrects $paged so pagination works on static front page
		'orderby'			=> 'menu_order',
		'order'				=> 'ASC'
	) );

}

// Make query available via filter
add_filter( 'saved_loop_after_content_query', 'saved_locations_loop_after_content' );

// Load main template to show the page
locate_template( 'index.php', true );