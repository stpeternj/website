<?php
/**
 * Theme Customizer Defaults
 *
 * Define defaults for Customizer and make available to framework for use with framework functions.
 *
 * @package    Resurrect
 * @subpackage Functions
 * @copyright  Copyright (c) 2013 - 2017, ChurchThemes.com
 * @link       https://churchthemes.com/themes/resurrect
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
 * See support-wp.php for default background color and image.
 *
 * @since 1.0
 * @return array Default values
 */
function resurrect_customize_defaults() {

	// Default values
	$defaults = array(

		'color' => array(
			'value'		=> 'dark',
			'no_empty'	=> true
		),

		'header_text_color' => array(
			'value'		=> 'light',
			'no_empty'	=> true
		),

		'background_image_type' => array(
			'value'		=> 'preset',
			'no_empty'	=> true
		),

		'background_image_preset' => array(
			'value'		=> ctfw_background_image_first_preset_url(),
			'no_empty'	=> false
		),

		'menu_font' => array(
			'value'		=> 'Oswald',
			'no_empty'	=> true
		),

		'heading_font' => array(
			'value'		=> 'Oswald',
			'no_empty'	=> true
		),

		'logo_font' => array(
			'value'		=> 'Oswald',
			'no_empty'	=> true
		),

		'body_font' => array(
			'value'		=> 'Open Sans',
			'no_empty'	=> true
		),

		'font_subsets' => array(
			'value'		=> '',
			'no_empty'	=> false
		),

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

		'logo_offset_x' => array(
			'value'		=> '',
			'no_empty'	=> false
		),

		'logo_text' => array(
			'value'		=> 'Church <span>Name</span>',
			'no_empty'	=> true
		),

		'logo_text_size' => array(
			'value'		=> 'large',
			'no_empty'	=> true
		),

		'tagline_under_logo' => array(
			'value'		=> true,
			'no_empty'	=> false
		),

		'tagline_offset_x' => array(
			'value'		=> '',
			'no_empty'	=> false
		),

		'header_right' => array(
			'value'		=> 'events',
			'no_empty'	=> true
		),

		'header_right_items_limit' => array(
			'value'		=> '2',
			'no_empty'	=> true
		),

		'header_right_content' => array(
			'value'		=> '',
			'no_empty'	=> false
		),

		'header_hide_search' => array(
			'value'		=> false,
			'no_empty'	=> false
		),

		'footer_address' => array(
			/* translators: This is a default option value for footer address */
			'value'		=> __( '1247 Church Ave, Brooklyn, NY 11218', 'resurrect' ),
			'no_empty'	=> false
		),

		'footer_phone' => array(
			/* translators: This is a default option value for footer address */
			'value'		=> __( '(817) 555-3462', 'resurrect' ),
			'no_empty'	=> false
		),

		'footer_notice' => array(
			/* translators: This is a default option value for footer copyright/notice */
			'value'		=> sprintf(
								__( 'Copyright &copy; [ctcom_current_year] [ctcom_site_name]. Powered by <a href="%s" target="_blank" rel="nofollow noopener noreferrer">ChurchThemes.com</a>', 'resurrect' ),
								'https://churchthemes.com'
							),
			'no_empty'	=> false
		),

		'header_icon_urls' => array(
			/* translators: This is a default option value for header icons */
			'value'		=> __( "[ctcom_rss_url]\nhttp://www.apple.com/itunes/\nhttp://facebook.com\nhttp://twitter.com\nhttp://youtube.com", 'resurrect' ),
			'no_empty'	=> false
		),

		'footer_icon_urls' => array(
			/* translators: This is a default option value for footer icons */
			'value'		=> __( "[ctcom_rss_url]\nhttp://www.apple.com/itunes/\nhttp://facebook.com\nhttp://twitter.com\nhttps://plus.google.com\nhttp://pinterest.com\nhttp://youtube.com\nhttp://vimeo.com\nhttp://flickr.com\nhttp://instagram.com\nhttp://foursquare.com", 'resurrect' ),
			'no_empty'	=> false
		),

		'show_breadcrumbs' => array(
			'value'		=> true,
			'no_empty'	=> false
		),

		'slider_slideshow' => array(
			'value'		=> true,
			'no_empty'	=> false
		),

		'slider_speed' => array(
			'value'		=> '6',
			'no_empty'	=> true
		)

	);

	return $defaults;

}

add_filter( 'ctfw_customize_defaults', 'resurrect_customize_defaults' );
