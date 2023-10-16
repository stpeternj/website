<?php
/**
 * Color Functions
 *
 * @package    Saved
 * @subpackage Functions
 * @copyright  Copyright (c) 2017, ChurchThemes.com
 * @link       https://churchthemes.com/themes/saved
 * @license    GPLv2 or later
 * @since      1.0
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/*******************************************
 * BACKGROUND COLORS
 *******************************************/

/**
 * Alternate background color class
 *
 * This is used on background of sections on homepage, in footer, etc.
 * It automatically returns appropriate white or gray class or optional contrasting version when requested.
 *
 * @since 1.0
 * @global array $saved_previous_alternating_bg Details on last class returned
 * @param bool $contrast Use constrasting version of color to further differentiate (such as when showing white boxed entries)
 * @param string $start_secondary Optionally start at secondary
 * @return string Class name
 */
function saved_alternating_bg_class( $contrast = false, $start_secondary = false ) {

	global $saved_alternating_bg_data; // to retrieve prior widget's image position

	// Get mode
	if ( ! isset( $saved_alternating_bg_data['mode'] ) ) {
		$mode = 'primary'; // first run
	} else {

		$mode = $saved_alternating_bg_data['mode'];

		// Alternate mode from primary to secondary or secondary to primary, based on last use
		$mode = 'primary' == $mode ? 'secondary' : 'primary';

	}

	// Start at secondary?
	if ( $start_secondary ) {
		$mode = 'secondary';
	}

	// Use contrast only for primary (because it is white)
	if ( $contrast && 'secondary' == $mode ) {
		$contrast = false;
	}

	// Base class
	$class = 'saved-bg';

	// Is it secondary?
	if ( 'secondary' == $mode ) {
		$class .= '-secondary';
	}

	// Is it contrasting?
	if ( $contrast ) {
		$class .= '-contrast';
	}

	// Store current data in global for next use
	$saved_alternating_bg_data = array(
		'mode'		=> $mode,
		'contrast'	=> $contrast,
	);

	// Return filtered
	return apply_filters( 'saved_widget_image_side_class', $class );

}
