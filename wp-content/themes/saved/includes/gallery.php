<?php
/**
 * WordPress Gallery Functions
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

/***********************************************
 * GALLERY
 ***********************************************/

/**
 * Exclude specific gallery posts
 *
 * The framework's ctfw_gallery_posts() function returns all posts/pages having the gallery shortcode.
 * This uses the theme's _ctcom_gallery_exclude meta value to exclude certain pages/posts.
 *
 * @since 1.0
 * @param array $args Default WP_Query arguments
 * @param array $options Default options
 * @return array Modified arguments
 */
function saved_exclude_gallery_posts( $args, $options ) {

	// Add meta query to WP_Query arguments to exclude posts having this field true (checkbox)
	$args['meta_query'] = array(
		'relation'		=> 'OR',
		array(
        	'key' 		=> '_ctcom_gallery_exclude',
        	'value'		=> '',
        	'compare' 	=> '=',
		),
		array(
        	'key' 		=> '_ctcom_gallery_exclude',
        	'value' 	=> '', // required until bug fixed: http://core.trac.wordpress.org/ticket/23268
        	'compare' 	=> 'NOT EXISTS',
		)
	);

	return $args;

}

add_filter( 'ctfw_gallery_posts_args', 'saved_exclude_gallery_posts', 10, 2 );
