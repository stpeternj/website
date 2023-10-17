<?php
/**
 * <body> Functions
 *
 * @package    Resurrect
 * @subpackage Functions
 * @copyright  Copyright (c) 2013 - 2017, ChurchThemes.com
 * @link       https://churchthemes.com/themes/resurrect
 * @license    GPLv2 or later
 * @since      1.0
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/*******************************************
 * BODY CLASSES
 *******************************************/

/**
 * Add helper classes to <body>
 *
 * @since 1.0
 * @param array $classes Classes currently being added to body tag
 * @return array Modified classes
 */
function resurrect_add_body_classes( $classes ) {

	// Fonts
	$fonts_areas = array( 'logo_font', 'heading_font', 'menu_font', 'body_font' );
	foreach ( $fonts_areas as $font_area ) {

		$font_name = ctfw_customization( $font_area );
		$font_name = sanitize_title( $font_name );

		$font_area = str_replace( '_', '-', $font_area );

		$classes[] = 'resurrect-' . $font_area . '-' . $font_name;

	}

	// No logo
	if ( ! ctfw_customization( 'logo_image' ) ) {
		$classes[] = 'resurrect-no-logo';
	}

	// Background image name
	// Handy for setting specific background color to match
	$background_image = get_background_image();
	if ( $background_image ) {
		$background_image_info = pathinfo( basename( $background_image ) );
		$classes[] = 'resurrect-background-image-file-' . sanitize_title( $background_image_info['filename'] ); // extension removed
	}

	// Showing Banner
	$banner = resurrect_banner_data();
	if ( $banner['page'] ) { // banner page found
		$classes[] = 'resurrect-has-banner';
	} else {
		$classes[] = 'resurrect-no-banner';
	}

	// WordPress 4.8 or earlier (used for MediaElement.js back-compat styling)
	if ( version_compare( $GLOBALS['wp_version'], '4.8', '<=' ) ) {
		$classes[] = 'resurrect-wp-4-8-or-less';
	}

	// "View Full Site" cookie set is set in main.js -- client-side to avoid issues w/caching plugins

	return $classes;

}

add_filter( 'body_class', 'resurrect_add_body_classes' );
