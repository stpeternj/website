<?php
/**
 * Sidebar / Widget Area Functions
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

/**********************************
 * REGISTER SIDEBARS
 **********************************/

/**
 * Register sidebars
 *
 * Also see saved_sidebar_restrictions() below to restrict which widgets a sidebar allows.
 * Using ctcom- prefix common to all churchthemes.com themes to assist with theme switching.
 *
 * @since 1.0
 */
function saved_register_sidebars() {

	// Homepage
	// Note: Primary widgets on homepage will not output before_* and after_*. Secondary widgets will.
	// See saved_home_secondary_widgets_section() for what is considered primary and secondary.
	register_sidebar( array(
		'id'			=> 'ctcom-home', // use this ID for themes that take any widget on homepage
		'name'			=> _x( 'Homepage', 'widget area', 'saved' ),
		'description' 	=> __( 'Add widgets to show on the homepage.', 'saved' ),
		'before_widget'	=> '<aside id="%1$s" class="saved-widget %2$s">',
		'after_widget'	=> '</aside>',
		'before_title' 	=> '<h2 class="saved-widget-title">',
		'after_title' 	=> '</h2>',
	) );

	// Footer
	register_sidebar( array(
		'id'			=> 'ctcom-footer', // use this ID for all themes with footer widgets
		'name'			=> _x( 'Footer', 'sidebar', 'saved' ),
		'description' 	=> __( 'Show three widgets in the footer.', 'saved' ),
		'before_widget'	=> '<aside id="%1$s" class="saved-widget %2$s">',
		'after_widget'	=> '</aside>',
		'before_title' 	=> '<h2 class="saved-widget-title">',
		'after_title' 	=> '</h2>',
	) );

}

add_action( 'widgets_init', 'saved_register_sidebars' );

/**********************************
 * RESTRICT SIDEBARS/WIDGETS
 **********************************/

/**
 * Sidebar widget restrictions
 *
 * Restrictions based on which widgets a sidebar allows or disallows.
 * A limit can be set for the number of widgets a sidebar will show.
 * The framework receives this data via the saved_sidebar_widget_restrictions filter.
 *
 * Also see the converse (Widget sidebar restrictions) - both are necessary in consideration
 * of widgets and sidebars added by plugins or child theming
 *
 * Must use add_theme_support( 'ctfw_sidebar_widget_restrictions' ).
 *
 * @since 1.0
 * @param array $restrictions
 * @return array Restrictions configuration
 */
function saved_sidebar_widget_restrictions( $restrictions ) {

	$restrictions = array(

		// Footer
		'ctcom-footer' => array(
			'include_widgets' 	=> array(), // allow only these widgets (empty to allow all)
			'exclude_widgets' 	=> array( 'ctfw-section' ), // never allow these widgets
			'limit' 			=> 3, // do not show more than this on front-end
		),

	);

	return $restrictions;

}

add_filter( 'ctfw_sidebar_widget_restrictions', 'saved_sidebar_widget_restrictions' );

/**
 * Widget sidebar restrictions
 *
 * Restrictions based on which sidebars a widget allows or disallows itself to be used in.
 * The framework receives this data via the saved_widget_sidebar_restrictions filter.
 *
 * Also see the converse (Sidebar widget restrictions) - both are necessary in consideration
 * of widgets and sidebars added by plugins or child theming.
 *
 * @since 1.0
 * @param array $restrictions
 * @return array Restrictions configuration
 */
function saved_widget_sidebar_restrictions( $restrictions ) {

	$restrictions = array(

		// Section Widget
		'ctfw-section' => array(
			'include_sidebars' => array( 'ctcom-home' ), // allow in only these sidebars (empty to allow in all)
			'exclude_sidebars' => array(), // never allow in these sidebars
		),

	);

	return $restrictions;

}

add_filter( 'ctfw_widget_sidebar_restrictions', 'saved_widget_sidebar_restrictions' );
