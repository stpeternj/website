<?php
/**
 * Theme Admin Styles
 *
 * Also see framework/includes/admin/enqueue-admin-styles.php
 *
 * @package    Saved
 * @subpackage Admin
 * @copyright  Copyright (c) 2017- 2018, ChurchThemes.com
 * @link       https://churchthemes.com/themes/saved
 * @license    GPLv2 or later
 * @since      1.0
 */

// No direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*******************************************
 * ENQUEUE STYLESHEETS
 *******************************************/

/**
 * Enqueue admin stylesheets.
 *
 * @since 1.0
 */
function saved_admin_enqueue_styles() {

	$screen = get_current_screen();

	// Admin widgets.
	if ( 'widgets' === $screen->base ) {

		// CSS for admin widgets.
		// Theme also enqueues this for Customizer in includes/customize.php.
		wp_enqueue_style( 'saved-admin-widgets', get_theme_file_uri( CTFW_THEME_CSS_DIR . '/admin/admin-widgets.css' ), false, CTFW_THEME_VERSION ); // bust cache on update

	}


}

add_action( 'admin_enqueue_scripts', 'saved_admin_enqueue_styles' );

