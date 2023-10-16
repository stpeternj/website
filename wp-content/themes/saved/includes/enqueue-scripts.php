<?php
/**
 * Enqueue JavaScript
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
 * Enqueue JavaScript
 *
 * @since 1.0
 */
function saved_enqueue_scripts() {

	global $post;

	// jQuery (included with WordPress)
	wp_enqueue_script( 'jquery' );

	// Superfish Menu
	//wp_enqueue_script( 'hoverIntent' ); // packaged with WordPress
	wp_enqueue_script( 'superfish', get_theme_file_uri( CTFW_THEME_JS_DIR . '/lib/superfish.modified.js' ), array( 'jquery' ), CTFW_THEME_VERSION ); // bust cache on theme update
	wp_enqueue_script( 'supersubs', get_theme_file_uri( CTFW_THEME_JS_DIR . '/lib/supersubs.js' ), array( 'jquery', 'superfish' ), CTFW_THEME_VERSION ); // bust cache on theme update

	// MeanMenu (responsive)
	wp_enqueue_script( 'jquery-meanmenu', get_theme_file_uri( CTFW_THEME_JS_DIR . '/lib/jquery.meanmenu.modified.js' ), array( 'jquery' ), CTFW_THEME_VERSION ); // bust cache on theme update

	// jQuery Cookie
	// Used for dismissing footer sticky
	wp_enqueue_script( 'js-cookie', get_theme_file_uri( CTFW_THEME_JS_DIR . '/lib/js.cookie.min.js' ), false, CTFW_THEME_VERSION ); // bust cache on theme update

	// Vide enqueued only when Homepage Section widget has video
	// See widget-templates/widget-section.php

	// waitForImages - header banner
	if (! ctfw_is_page_template( 'homepage' )) { // subpages only
		wp_enqueue_script( 'jquery-waitforimages', get_theme_file_uri( CTFW_THEME_JS_DIR . '/lib/jquery.waitforimages.min.js' ), array( 'jquery' ), CTFW_THEME_VERSION ); // bust cache on theme update
	}

	// Smooth Scroll.
	if (is_singular() || ctfw_is_page_template( 'homepage' )) { // single post or homepage

		// Smooth Scroll - comment and video/audio scroll down
		wp_enqueue_script( 'jquery-smooth-scroll', get_theme_file_uri( CTFW_THEME_JS_DIR . '/lib/jquery.smooth-scroll.min.js' ), array( 'jquery' ), CTFW_THEME_VERSION ); // bust cache on theme update

	}

	// Single Post
	if (is_singular() && ! ctfw_is_page_template( 'homepage' )) { // single post or page

		// comment-reply.js to cause comment form to show below a comment when replying to a comment
		wp_enqueue_script( 'comment-reply' );

		// Comment Validation with jQuery Plugin
		if (comments_open()) { // only if need it for comments form
			wp_enqueue_script( 'jquery-validate', get_theme_file_uri( CTFW_THEME_JS_DIR . '/lib/jquery.validate.min.js' ), array( 'jquery' ), CTFW_THEME_VERSION ); // bust cache on theme update
		}

	}

	// Events Calendar
	if (ctfw_is_page_template( 'events-calendar' )) {

		// jQuery Visible
		// https://github.com/customd/jquery-visible
		wp_enqueue_script( 'jquery-visible', get_theme_file_uri( CTFW_THEME_JS_DIR . '/lib/jquery.visible.min.js' ), array( 'jquery' ), CTFW_THEME_VERSION ); // bust cache on theme update

		// PJAX
		// https://github.com/defunkt/jquery-pjax
		wp_enqueue_script( 'jquery-pjax', get_theme_file_uri( CTFW_THEME_JS_DIR . '/lib/jquery.pjax.min.js' ), array( 'jquery' ), CTFW_THEME_VERSION ); // bust cache on theme update

	}

	// Tooltipster base styles
	// http://iamceege.github.io/tooltipster/
	// Homepage, event calendar template and single event (recurrence tooltip)
	if (
		ctfw_is_page_template( 'homepage' ) // scroll arrow
		|| ctfw_is_page_template( 'events-calendar.php' ) // hover details
		|| is_singular( 'ctc_event' ) // recurrence note
	) {
		wp_enqueue_script( 'tooltipster-bundle', get_theme_file_uri( CTFW_THEME_JS_DIR . '/lib/tooltipster.bundle.min.js' ), array( 'jquery' ), CTFW_THEME_VERSION ); // bust cache on theme update
	}

	// jQuery Dropdown
	// https://github.com/claviska/jquery-dropdown
	// Used for Archive Dropdowns in header and for calendar filters
	if (
        in_array( ctfw_current_content_type(), array(
			'sermon',
			'event',
			'people',
			'blog',
		) )
	) {
		wp_enqueue_script( 'jquery-dropdown', get_theme_file_uri( CTFW_THEME_JS_DIR . '/lib/jquery.dropdown.min.js' ), array( 'jquery' ), CTFW_THEME_VERSION ); // bust cache on theme update
	}

	// jQuery matchHeight
	// Make short entry boxes have equal height per row
	// Also helps with gallery image rows and gaps
	// Note: Load always since gallery widget can be anywhere
	//if ( ctfw_has_loop_multiple() || ctfw_is_page_template( 'homepage' ) || ctfw_is_page_template( 'galleries' ) || ( isset( $post->post_content ) && preg_match( '/\[gallery/', $post->post_content ) ) ) {
	wp_enqueue_script( 'jquery-matchHeight', get_theme_file_uri( CTFW_THEME_JS_DIR . '/lib/jquery.matchHeight-min.js' ), array( 'jquery' ), CTFW_THEME_VERSION ); // bust cache on theme update

	// ScrollReveal
	if (ctfw_customization( 'scroll_animations' )) {
		wp_enqueue_script( 'scrollreveal', get_theme_file_uri( CTFW_THEME_JS_DIR . '/lib/scrollreveal.min.js' ), array( 'jquery' ), CTFW_THEME_VERSION );
	}

	// Main JS
	wp_enqueue_script( 'saved-main', get_theme_file_uri( CTFW_THEME_JS_DIR . '/main.js' ), array( 'jquery' ), CTFW_THEME_VERSION ); // bust cache on theme update

	// Theme data for JavaScript
	wp_localize_script( 'saved-main', 'saved_main', array( // pass WP data into JS from this point on
		'site_path'							=> ctfw_site_path(),
		'home_url'							=> home_url(),
		'theme_url'							=> CTFW_THEME_URL,
		'is_ssl'							=> is_ssl(),
		'mobile_menu_close'					=> saved_icon_class( 'mobile-menu-close', true ),
		'scroll_animations'					=> ctfw_customization( 'scroll_animations' ),
		'comment_name_required'				=> get_option('require_name_email'), // name and email required on comments? (WP Admin: Settings > Discussion)
		'comment_email_required'			=> get_option('require_name_email'),
		'comment_name_error_required'		=> __( 'Required', 'saved' ), // translatable string for comment form validation
		'comment_email_error_required'		=> __( 'Required', 'saved' ),
		'comment_email_error_invalid'		=> __( 'Invalid Email', 'saved' ),
		'comment_url_error_invalid'			=> __( 'Invalid URL', 'saved' ),
		'comment_message_error_required'	=> __( 'Comment Required', 'saved' ),
	));

}

add_action( 'wp_enqueue_scripts', 'saved_enqueue_scripts' ); // front-end only
