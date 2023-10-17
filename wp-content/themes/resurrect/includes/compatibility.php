<?php
/**
 * Compatibility Functions
 *
 * @package    Resurrect
 * @subpackage Functions
 * @copyright  Copyright (c) 2017, ChurchThemes.com
 * @link       https://churchthemes.com/themes/resurrect
 * @license    GPLv2 or later
 * @since      2.2
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/*******************************************
 * BACKGROUND IMAGE
 *******************************************/

// Always run later upgrades after earlier ones

/**
 * Set background image type and preset (WordPress 4.1)
 *
 * Checks if there is no Background Image type and fills in values as needed.
 *
 * WordPress 4.1 changed the Background Image control which caused our class
 * extending it to provide a Presets tab to stop having an effect.
 *
 * To remedy, Background Image Type and Background Image Preset settings were added.
 * Values for these need to be set to ensure the Customizer works correctly.
 *
 * This will run only when Background Image Type is empty (ie. only once)
 *
 * @since 1.4.1
 */
function resurrect_upgrade_background_image_4_1() {

	// Get settings values
	$type = ctfw_customization_raw( 'background_image_type' );
	$url = get_background_image();

	// No type
	if ( ! $type ) {

		// Have a URL
		// Both uploaded and preset images were stored in background_image before
		if ( $url ) {

			// URL is a preset
			if ( in_array( $url, ctfw_background_image_preset_urls() ) ) {

				// Set type to preset
				ctfw_update_customization( 'background_image_type', 'preset' );

				// Set preset URL
				ctfw_update_customization( 'background_image_preset', $url );

			}

			// URL is uploaded
			else {

				// Set type to upload
				ctfw_update_customization( 'background_image_type', 'upload' );

			}

		}

	}

}

add_action( 'customize_register', 'resurrect_upgrade_background_image_4_1', 1 ); // very early, Customizer only

/**
 * Set background size / fullscreen (WordPress 4.7)
 *
 * Resurrect 2.2 supports updated background image control in WordPress 4.7.
 * It now uses core "Size: Fill Screen" (cover) instead of custom Fullscreen checkbox.
 *
 * This checks if old fullscreen setting is set then sets the new core setting.
 * It unsets the old setting so that this upgrade is only run once.
 *
 * This runs on frontend and in Customizer so that fullscreen backgrounds continue to work seamlessly
 * after updating theme.
 *
 * @since 2.2
 */
function resurrect_upgrade_background_image_4_7() {

	global $wp_customize;

	// Not in admin area, unless it's Customizer
	// Never on form submission
	if ( ( is_admin() && ! is_customize_preview() ) || $_POST ) {
		return;
	}

	// Get customization array to can see if fullscreen is set
	$customization_settings = get_option( ctfw_customize_option_id() );

	// Old fullscreen is set, run the upgrade then unset it
	if ( isset( $customization_settings['background_image_fullscreen'] ) ) {

		// Fullscreen was true
		if ( $customization_settings['background_image_fullscreen'] ) {
			$background_size = 'cover'; // "Fill Screen" size
		}

		// Fullscreen was false
		else {
			$background_size = 'auto';  // "Original" size
		}

		// Set core preset to custom so it doesn't auto-apply anything else
		set_theme_mod( 'background_preset', 'custom' );

		// Set background size
		set_theme_mod( 'background_size', $background_size );

		// Remove old setting so this upgrade doesn't run again
		ctfw_unset_customization( 'background_image_fullscreen' );

	}

}

add_action( 'init', 'resurrect_upgrade_background_image_4_7' ); // reach frontend and Customizer
