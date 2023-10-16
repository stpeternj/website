<?php
/**
 * Enqueue Stylesheets
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

/**
 * Enqueue stylesheets
 *
 * @since 1.0
 */
function saved_enqueue_styles() {

	// Google Fonts
	$fonts = array(
		ctfw_customization( 'logo_font' ),
		ctfw_customization( 'heading_font' ),
		ctfw_customization( 'nav_font' ),
		ctfw_customization( 'body_font' )
	);
	$google_fonts_url = ctfw_google_fonts_style_url( $fonts, ctfw_customization( 'font_subsets' ) );
	if ( $google_fonts_url ) {
		wp_enqueue_style( 'saved-google-fonts', $google_fonts_url, false, null ); // null - don't mess with Google Fonts URL by adding version
	}

	// Material Design Icons - before main so can override styles when necessary
	// Note on SIL font license and why it can be included with 100% GPL Theme: https://make.wordpress.org/plugins/2013/05/01/font-awesome/#comment-38477
	wp_enqueue_style( 'materialdesignicons', get_theme_file_uri( CTFW_THEME_CSS_DIR . '/materialdesignicons.min.css' ), false, CTFW_THEME_VERSION );  // bust cache on theme update

	// Main Stylesheet
	wp_enqueue_style( 'saved-style', get_stylesheet_uri(), false, CTFW_THEME_VERSION );  // bust cache on theme update

	// Tooltipster base styles
	// style.css and color stylesheets contain the .saved-tooltipster theme
	// Event calendar template and single event (recurrence tooltip)
	if (
		ctfw_is_page_template( 'events-calendar' )
		|| is_singular( 'ctc_event' )
	) {
		wp_enqueue_style( 'tooltipster-bundle', get_theme_file_uri( CTFW_THEME_CSS_DIR . '/tooltipster.bundle.css' ), false, CTFW_THEME_VERSION );  // bust cache on theme update
	}

}

add_action( 'wp_enqueue_scripts', 'saved_enqueue_styles' ); // front-end only (and yes, wp_enqueue_scripts is correct for styles)
