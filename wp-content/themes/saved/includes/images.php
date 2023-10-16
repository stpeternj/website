<?php
/**
 * Image Functions
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

/***********************************************
 * IMAGE SIZES
 ***********************************************/

/**
 * Add image sizes
 *
 * @since 1.0
 */
function saved_image_sizes() {

	/*********************************
	 * THUMBNAILS
	 *********************************/

	// Default Thumbnail (post-thumbnail)
	// Shown on short entries and gallery 1 - 2 columns, gallery widget large)
	// Just wide enough to be @2x for short entry image at one per row (360px)
	set_post_thumbnail_size( 720, 480, true ); // crop for exact size

	/*********************************
	 * HOMEPAGE IMAGES
	 *********************************/

	// Section Image (Homepage Widget)
	// This size is excluded from upscaling in support-framework.php so not every image uploaded is upscaled to this size
	add_image_size( 'saved-section', 1680, 1050, true ); // crop for exact size

	/*********************************
	 * HEADER IMAGES
	 *********************************/

	// Banner Image
	// Featured image to appear at the top of pages
	// This size is excluded from upscaling in support-framework.php so not every image uploaded is upscaled to this size
	add_image_size( 'saved-banner', 1600, 400, true ); // crop for exact size

	/*********************************
	 * SQUARE IMAGES
	 *********************************/

	// Square Image
	// Used for CT Highlight widget which is displayed at max width of 360px, so @2x for Retina
	add_image_size( 'saved-square', 720, 720, true ); // crop for exact size

	// Square Image Large
	// Used for image at side of CT Posts/Sermons/People or CT Giving on homepage
	add_image_size( 'saved-square-large', 1024, 1024, true ); // crop for exact size

	// Square Image
	// Used for single Person in header
	add_image_size( 'saved-square-small', 160, 160, true ); // crop for exact size

	/*********************************
	 * RECTANGULAR IMAGES
	 *********************************/

	// Large Thumbnail uses default size: post-thumbnail (see above)
	// It is effectively 'saved-rect-large'

	// Medium Thumbnail (Gallery 3 - 5 Columns, Gallery Widget Medium)
	add_image_size( 'saved-rect-medium', 480, 320, true ); // crop for exact size

	// Small Thumbnail (Gallery 6 - 9 Columns, Gallery Widget Small)
	// Widget featured image is 100 wide so this is @2x
	add_image_size( 'saved-rect-small', 200, 133, true ); // crop for exact size

}

add_action( 'after_setup_theme', 'saved_image_sizes', 9 ); // before saved_add_theme_support_framework() so it can use ctfw_image_size_dimensions()

/**
 * Set content width
 *
 * This affect maximum embed and image sizes.
 * On front end CSS handles most of this but content editor also uses.
 *
 * Keep an eye on this for possible future add_theme_support() implementation:
 * http://core.trac.wordpress.org/ticket/21256
 *
 * @since 1.0
 * @global int $content_width
 */
function saved_set_content_width() {

	global $content_width;

	if ( ! isset( $content_width ) ) {

		// Width depends on page template, archive, singular, etc.
		$content_width = saved_content_width();

		// No sidebar in Saved

	}

}

add_action( 'wp', 'saved_set_content_width' );

/**
 * Logo image size
 *
 * This data is used in Customizer to make a recommendation to the user
 * and is used in header-logo.php for outputting logo markup.
 *
 * These values are duplicated in _variables.scss (update both files if change).
 *
 * @since 1.0
 * @param string $key If key provided, that value is returned; otherwise whole array
 * @return string|array Value for one key or whole array if none
 */
function saved_logo_size( $key = false ) {

	$logo_size_data = array();

	$logo_size_data['max_width'] = 250; // update in _variables.css too
	$logo_size_data['max_height'] = 30; // update in _variables.css too
	$logo_size_data['max_dimensions'] = $logo_size_data['max_width'] . 'x' . $logo_size_data['max_height'];

	$logo_size_data = apply_filters( 'saved_logo_size_data', $logo_size_data, $key );

	if ( $key && isset( $logo_size_data[$key] ) ) {
		$value = $logo_size_data[$key];
	} else {
		$value = $logo_size_data;
	}

	$value = apply_filters( 'saved_logo_size', $value, $logo_size_data, $key );

	return $value;

}

