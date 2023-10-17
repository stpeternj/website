<?php
/**
 * WordPress Feature Support
 *
 * @package    Resurrect
 * @subpackage Functions
 * @copyright  Copyright (c) 2013 - 2018, ChurchThemes.com
 * @link       https://churchthemes.com/themes/resurrect
 * @license    GPLv2 or later
 * @since      1.0
 */

// No direct access.
if (! defined( 'ABSPATH' )) {
	exit;
}

/**
 * Add theme support for WordPress features
 *
 * @since 1.0
 */
function resurrect_add_theme_support_wp() {

	// Output HTML5 markup
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

	// Title Tag
	add_theme_support( 'title-tag' );

	// RSS feeds in <head>
	add_theme_support( 'automatic-feed-links' );

	// Featured images
	add_theme_support( 'post-thumbnails' );

	// Custom background with defaults
	add_theme_support( 'custom-background', array(
		'default-image'			=> ctfw_background_image_first_preset_url(), // first image defined
		'default-preset'		=> 'fill',
		'default-position-x'	=> 'center',
		'default-position-y'	=> 'center',
		'default-size'			=> 'cover',
		'default-repeat'		=> 'repeat',
		'default-attachment'	=> 'fixed',
		'default-color'			=> '888888', // default color for Customizer (somewhere between light and dark)
	) );

	// Gutenberg disable custom font size.
	// User must choose one of the specific sizes (small, regular, large, huge).
	add_theme_support( 'disable-custom-font-sizes' );

	// Gutenberg disable gradients: https://make.wordpress.org/core/2020/03/02/new-gradient-theme-apis/
	add_theme_support( 'disable-custom-gradients' );
	add_theme_support( 'editor-gradient-presets', array() );

	// Gutenberg disable block-based widgets
	remove_theme_support( 'widgets-block-editor' );
	add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' ); // Disables the block editor from managing widgets in the Gutenberg plugin.
	add_filter( 'use_widgets_block_editor', '__return_false' ); // Disables the block editor from managing widgets.

	// Responsive embeds (WordPress 5.0).
	add_theme_support( 'responsive-embeds' );

}

add_action( 'after_setup_theme', 'resurrect_add_theme_support_wp' );
