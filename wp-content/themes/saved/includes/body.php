<?php
/**
 * <body> Functions
 *
 * @package    Saved
 * @subpackage Functions
 * @copyright  Copyright (c) 2017 - 2018, ChurchThemes.com
 * @link       https://churchthemes.com/themes/saved
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
 * IMPORTANT: Do not do client detection (mobile, browser, etc.) here.
 * Instead, do in theme's JS so works with caching plugins.
 *
 * Note: Other body classes are added via main.js since their presence
 * is easier to detect in that manner.
 *
 * Note: This can also be used by framework's 'ctfw-editor-styles' feature
 * to add body classes to editor.
 *
 * @since 1.0
 * @param array $classes Classes currently being added to body tag (when used with body_class filter)
 * @return array Modified classes
 */
function saved_body_classes( $classes = array() ) {

	// Fonts
	$fonts_areas = array( 'logo_font', 'heading_font', 'nav_font', 'body_font' );
	foreach ( $fonts_areas as $font_area ) {

		$font_name = ctfw_customization( $font_area );
		$font_name = sanitize_title( $font_name );

		$font_area = str_replace( '_', '-', $font_area );

		$classes[] = 'saved-' . $font_area . '-' . $font_name;

	}

	// Logo
	if ( 'image' == ctfw_customization( 'logo_type' ) && ctfw_customization( 'logo_image' ) ) {
		$classes[] = 'saved-has-logo-image';
	} else {
		$classes[] = 'saved-no-logo-image';
	}

	// Uppercase logo, headings, etc.
	if ( ctfw_customization( 'uppercase' ) ) {
		$classes[] = 'saved-has-uppercase';
	} else {
		$classes[] = 'saved-no-uppercase';
	}

	// Heading accent lines
	if ( ctfw_customization( 'heading_accents' ) ) {
		$classes[] = 'saved-has-heading-accents';
	} else {
		$classes[] = 'saved-no-heading-accents';
	}

	// WordPress 4.8 or earlier (used for MediaElement.js back-compat styling)
	if ( version_compare( $GLOBALS['wp_version'], '4.8', '<=' ) ) {
		$classes[] = 'saved-wp-4-8-or-less';
	}

	// Sanitize - some dynamic
	// To Do: Make this a framework function working with arrays and strings - apply everywhere
	foreach ( $classes as $k => $class ) {
		$classes[$k] = sanitize_html_class( $class );
	}

	// Content width
	$classes[] = 'saved-content-width-' . saved_content_width(); // 700, 980, 1170

	return $classes;

}

add_filter( 'body_class', 'saved_body_classes' );
