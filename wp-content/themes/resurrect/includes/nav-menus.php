<?php
/**
 * Navigation Menu Functions
 *
 * @package    Resurrect
 * @subpackage Functions
 * @copyright  Copyright (c) 2013, ChurchThemes.com
 * @link       https://churchthemes.com/themes/resurrect
 * @license    GPLv2 or later
 * @since      1.0
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/**********************************
 * CUSTOM MENUS
 **********************************/

/**
 * Register header and footer menu locations
 *
 * @since 1.0
 */
function resurrect_register_menus() {

	// Register top menu location (top-most bar)
	register_nav_menu( 'top', _x( 'Top', 'menu location', 'resurrect' ) );

	// Register header menu location (main menu with dropdowns)
	register_nav_menu( 'header', _x( 'Header', 'menu location', 'resurrect' ) );

	// Register footer menu location
	register_nav_menu( 'footer', _x( 'Footer', 'menu location', 'resurrect' ) );

}

add_action( 'init', 'resurrect_register_menus' );
