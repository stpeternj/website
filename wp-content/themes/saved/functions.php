<?php
/**
 * Theme functions file
 *
 * This loads Church Theme Framework and includes files having functions, classes and other code used by the theme.
 *
 * If you want to edit code, it is best to use a child theme so changes are not lost after an update (see guides).
 *
 * @package   Saved
 * @copyright Copyright (c) 2017 - 2018, ChurchThemes.com
 * @link      https://churchthemes.com/themes/saved
 * @license   GPLv2 or later
 */

// No direct access
if (! defined( 'ABSPATH' )) exit;

/**
 * Load framework
 */
require_once get_template_directory() . '/framework/framework.php'; // do this before anything

/**
 * Includes to load
 */
$saved_includes = array(

	// Frontend or Admin
	'always' => array(

		// Functions
		CTFW_THEME_INC_DIR . '/banner.php',
		CTFW_THEME_INC_DIR . '/body.php', // admin editor needs it
		CTFW_THEME_INC_DIR . '/colors.php',
		CTFW_THEME_INC_DIR . '/content.php',
		CTFW_THEME_INC_DIR . '/customize.php',
		CTFW_THEME_INC_DIR . '/customize-defaults.php',
		CTFW_THEME_INC_DIR . '/content-types.php',
		CTFW_THEME_INC_DIR . '/events.php',
		CTFW_THEME_INC_DIR . '/fonts.php',
		CTFW_THEME_INC_DIR . '/gallery.php',
		CTFW_THEME_INC_DIR . '/head.php', // Customizer needs it
		CTFW_THEME_INC_DIR . '/icons.php',
		CTFW_THEME_INC_DIR . '/images.php',
		CTFW_THEME_INC_DIR . '/loop-after-content.php',
		CTFW_THEME_INC_DIR . '/navigation.php',
		CTFW_THEME_INC_DIR . '/sidebars.php',
		CTFW_THEME_INC_DIR . '/support-ctc.php',
		CTFW_THEME_INC_DIR . '/support-framework.php',
		CTFW_THEME_INC_DIR . '/support-wp.php',
		CTFW_THEME_INC_DIR . '/template-tags.php',
		CTFW_THEME_INC_DIR . '/widgets.php',

	),

	// Frontend Only
	'frontend' => array (

		// Functions
		CTFW_THEME_INC_DIR . '/enqueue-styles.php',
		CTFW_THEME_INC_DIR . '/enqueue-scripts.php',

	),

	// Admin Only
	'admin' => array(

		// Functions
		CTFW_THEME_ADMIN_DIR . '/meta-boxes.php',
		CTFW_THEME_ADMIN_DIR . '/admin-enqueue-styles.php',
		CTFW_THEME_ADMIN_DIR . '/admin-widgets.php',

	),

);

/**
 * Filter includes
 */
$saved_includes = apply_filters( 'saved_includes', $saved_includes ); // make filterable

/**
 * Load includes
 */
ctfw_load_includes( $saved_includes );
