<?php
/**
 * WordPress Feature Support
 *
 * @package    Saved
 * @subpackage Functions
 * @copyright  Copyright (c) 2017 - 2018, ChurchThemes.com
 * @link       https://churchthemes.com/themes/saved
 * @license    GPLv2 or later
 * @since      1.0
 */

// No direct access
if (! defined( 'ABSPATH' )) {
	exit;
}

/**
 * Add theme support for WordPress features
 *
 * @since 1.0
 */
function saved_add_theme_support_wp() {

	global $_wp_additional_image_sizes;

	// Output HTML5 markup.
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

	// Title Tag.
	add_theme_support( 'title-tag' );

	// RSS feeds in <head>.
	add_theme_support( 'automatic-feed-links' );

	// Featured images.
	add_theme_support( 'post-thumbnails' );

	// Custom Header.
	add_theme_support( 'custom-header', array(
		'width'                  => $_wp_additional_image_sizes['saved-banner']['width'], // see includes/images.php
		'height'                 => $_wp_additional_image_sizes['saved-banner']['height'],
		'flex-width'             => false, // false fixes aspect ratio
		'flex-height'            => false, // false fixes aspect ratio
		'header-text'            => false,
	) );

	// Gutenberg wide image option.
	add_theme_support( 'align-wide' ); // let user choose wide image option in block editor.

	// Gutenberg color palette.
	// See variables.scss for neutral colors. Default text color not necessary.
	add_theme_support( 'editor-color-palette', array(
		array(
			'name'  => __( 'Main', 'saved' ),
			'slug'  => 'main',
			'color' => ctfw_customization( 'main_color' ),
		),
		array(
			'slug'  => __( 'Accent', 'saved' ),
			'slug'  => 'accent',
			'color' => ctfw_customization( 'accent_color' ),
		),
		array(
			'slug'  => __( 'Dark', 'saved' ),
			'slug'  => 'dark',
			'color' => '#000',      // dark text color, in case wants to make text stand out.
		),
		array(
			'slug'  => __( 'Light', 'saved' ),
			'slug'  => 'light',
			'color' => '#777',      // light text color in case wants to de-emphasize text.
		),
		array(
			'slug'  => __( 'Light Background', 'saved' ),
			'slug'  => 'light-bg',
			'color' => '#f5f5f5',   // light gray background color to contrast with white background (e.g. paragraph background).
		),
		array(
			'slug'  => __( 'White', 'saved' ),
			'slug'  => 'white',
			'color' => '#fff',       // white text (intended for user over Main Color, such as on a button).
		)
	) );

	// Gutenberg disable custom font size.
	// User must choose one of the specific sizes (small, normal, large, huge).
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

add_action( 'after_setup_theme', 'saved_add_theme_support_wp' );
