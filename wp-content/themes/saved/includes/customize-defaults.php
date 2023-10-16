<?php
/**
 * Theme Customizer Defaults
 *
 * Define defaults for Customizer and make available to framework for use with framework functions.
 *
 * @package    Saved
 * @subpackage Functions
 * @copyright  Copyright (c) 2017, ChurchThemes.com
 * @link       https://churchthemes.com/themes/saved
 * @license    GPLv2 or later
 * @since      1.0
 */

// No direct access
if (! defined( 'ABSPATH' )) exit;

/**
 * Default Values
 *
 * Make defaults available to framework for use anywhere with ctfw_customize_defaults().
 *
 * Assists in setting defaults when adding settings and with getting defaults for output.
 * These apply only to options array, not theme_mod or anything else.
 *
 * @since 1.0
 * @return array Default values
 */
function saved_customize_defaults() {

	// Default values
	$defaults = array(

		/**
		 * Colors
		 */

		'main_color' => array(
			'value'		=> '#c42d2d',
			'no_empty'	=> true
		),

		'accent_color' => array(
			'value'		=> '#c42d2d',
			'no_empty'	=> true
		),

		/**
		 * Fonts (Google Fonts)
		 */

		'logo_font' => array(
			'value'		=> 'Source Sans Pro',
			'no_empty'	=> true
		),

		'nav_font' => array(
			'value'		=> 'Source Sans Pro',
			'no_empty'	=> true
		),

		'heading_font' => array(
			'value'		=> 'Source Sans Pro',
			'no_empty'	=> true
		),

		'body_font' => array(
			'value'		=> 'Noto Serif',
			'no_empty'	=> true
		),

		'uppercase' => array(
			'value'		=> true,
			'no_empty'	=> false
		),

		'heading_accents' => array(
			'value'		=> true,
			'no_empty'	=> false
		),

		'font_subsets' => array(
			'value'		=> '',
			'no_empty'	=> false
		),

		/**
		 * Logo
		 */

		'logo_type' => array(
			'value'		=> 'text',
			'no_empty'	=> true
		),

		'logo_image' => array(
			'value'		=> '',
			'no_empty'	=> false
		),

		'logo_hidpi' => array(
			'value'		=> '',
			'no_empty'	=> false
		),

		'logo_text' => array(
			/* translators: Default value for Logo Text */
			'value'		=> __( 'Church <span>Name</span>', 'saved' ),
			'no_empty'	=> true
		),

		'logo_text_size' => array(
			'value'		=> 'large',
			'no_empty'	=> true
		),

		/**
		 * Header Bar
		 */

		'header_line' => array(
			'value'		=> true,
			'no_empty'	=> false
		),

		'header_search' => array(
			'value'		=> true,
			'no_empty'	=> false
		),

		'header_icon_urls' => array(
			/* translators: This is a default option value for footer icons */
			'value'		=> __( "https://twitter.com\nhttps://facebook.com", 'saved' ),
			'no_empty'	=> false
		),

		/**
		 * Header Image
		 */

		'header_image_brightness' => array(
			'value'		=> '90', // percent
			'no_empty'	=> true
		),

		'header_image_opacity' => array(
			'value'		=> '95', // percent
			'no_empty'	=> true
		),

		/**
		 * Footer Content
		 */

		'show_footer_location' => array(
			'value'		=> true,
			'no_empty'	=> false
		),

		'footer_icon_urls' => array(
			/* translators: This is a default option value for footer icons */
			'value'		=> __( "https://facebook.com\nhttps://twitter.com\nhttps://youtube.com\nhttps://instagram.com\nhttps://itunes.com", 'saved' ),
			'no_empty'	=> false
		),

		'footer_notice' => array(
			/* translators: This is a default option value for footer copyright/notice */
			'value'		=> sprintf(
								__( '&copy; [ctcom_current_year] [ctcom_site_name]. Powered by <a href="%s" target="_blank" rel="nofollow noopener noreferrer">ChurchThemes.com</a>', 'saved' ),
								'https://churchthemes.com'
							),
			'no_empty'	=> false
		),

		'bottom_sticky' => array(
			'value'		=> 'events',
			'no_empty'	=> true
		),

		'bottom_sticky_items_limit' => array(
			'value'		=> '2',
			'no_empty'	=> true
		),

		'bottom_sticky_content' => array(
			'value'		=> '',
			'no_empty'	=> false
		),

		/**
		 * Effects
		 */

		'scroll_animations' => array(
			'value'		=> true,
			'no_empty'	=> false
		),

	);

	return $defaults;

}

add_filter( 'ctfw_customize_defaults', 'saved_customize_defaults' );
