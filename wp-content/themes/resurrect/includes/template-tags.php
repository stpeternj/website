<?php
/**
 * Template Tags
 *
 * These output common elements for different post types. Use in content-*.php templates.
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

/********************************
 * TITLE
 ********************************/

/**
 * Post title for full or short
 *
 * If short/multiple view (not singular), title is linked.
 *
 * @since 1.0
 * @return string Post title with page number or linked
 */
function resurrect_post_title() {

	// Full/Single - Not Linked
	if ( is_singular( get_post_type() ) ) {
		$title = resurrect_title_paged( false, 'return' ); // show with (Page #) if multipage
	}

	// Short/Multiple - Linked
	else {
		$title = '<a href="' . esc_url( get_permalink() ) . '" title="' . esc_attr( the_title_attribute( array( 'echo' => false ) ) ) . '">' . get_the_title() . '</a>';
	}

	echo apply_filters( 'resurrect_post_title', $title );

}

/**
 * Output page title with "(Page #)" as needed
 *
 * @since 1.0
 * @param string $title Title of page
 * @param bool $return Return or echo title with page number
 * @return string Page title woth number if not echoing
 */
function resurrect_title_paged( $title = '', $return = false ) {

	// Default title if none passed in
	if ( empty( $title ) ) {
		$title = get_the_title();
	}

	// Get page number
	$show_number = ctfw_page_num();

	// Title format if on page 2 or greater
	/* translators: %s is page title, %d is page number */
	if ( $show_number > 1 ) {
		$title_paged = sprintf( __( '%s <span>(Page %d)</span>', 'resurrect' ), $title, $show_number );
	}

	// Default title for Page 1 (or no number found)
	else {
		$title_paged = $title;
	}

	// Make filterable
	$output = apply_filters( 'resurrect_title_paged', $title_paged, $title );

	// Echo or return
	if ( $return ) {
		return $output;
	} else {
		echo $output;
	}

}

/**
 * Hide page title
 *
 * @since 1.0
 * @return bool True if page title is not to be shown
 */
function resurrect_hide_page_title() {

	$hide_page_title = false;

	// Get banner data
	$banner = resurrect_banner_data();

	// Banner is being shown (banner page found)
	// Banner is from current page or this is "Posts page" (when static front page used) and title is set to show over image
	// Therefore, do not repeat the title above the page content
	if ( $banner['page'] && ! $banner['no_text'] && ( 'page_self' == $banner['relation'] || ctfw_is_posts_page() ) ) {
		$hide_page_title = true;
	}

	return apply_filters( 'resurrect_hide_page_title', $hide_page_title );

}

/********************************
 * BREADCRUMBS
 ********************************/

/**
 * Output breadcrumb path
 *
 * @since 1.0
 * @param string $location $location is either content or banner
 */
function resurrect_breadcrumbs( $location ) {

	$breadcrumbs = '';

	// Breadcrumbs are enabled
	if ( ctfw_customization( 'show_breadcrumbs' ) ) {

		$hide_breadcrumbs = false;

		// Showing above content (not banner)
		if ( 'content' == $location ) {

			// Get banner data to determine if it is shown there
			$banner = resurrect_banner_data();

			// Breadcrumb already shown in banner, so don't show in content
			if ( $banner['page'] && ! $banner['no_text'] ) { // banner available and "no text over image" not set
				$hide_breadcrumbs = true;
			}

		}

		// Get breadcrumbs
		if ( ! $hide_breadcrumbs ) {
			$breadcrumbs = new CTFW_Breadcrumbs();
		}

	}

	// Return filtered
	echo apply_filters( 'resurrect_breadcrumbs', $breadcrumbs, $location );

}

/********************************
 * CONTENT
 ********************************/

/**
 * Post featured image for full or short
 *
 * If short/multiple view (not singular), image is linked.
 *
 * @since 1.0
 * @return string Featured image HTML
 */
function resurrect_post_image() {

	// Featured image
	$image = get_the_post_thumbnail( null, 'post-thumbnail', array(
		'class' => 'resurrect-image' )
	);

	// Link if short / multiple
	if ( ! is_singular( get_post_type() ) ) {
		$image = '<a href="' . esc_url( get_permalink() ) . '" title="' . esc_attr( the_title_attribute( array( 'echo' => false ) ) ) . '">' . $image . '</a>';
	}

	echo apply_filters( 'resurrect_post_image', $image );

}

/**
 * Comments showing?
 *
 * Useful for checking if comments link should be shown.
 *
 * @since 1.0
 * @return bool True if comments are to be shown
 */
function resurrect_show_comments() {

	$show = false;

	// True if comments open or closed but already have comments; hide if password protected
	if ( ( comments_open() || get_comments_number() > 0 ) && ! post_password_required() ) {
		$show = true;
	}

	return apply_filters( 'resurrect_show_comments', $show );

}

if ( ! function_exists( 'resurrect_comments_link' ) ) : // pluggable since not filterable
/**
 * Comments link
 *
 * @since 1.0
 */
function resurrect_comments_link() {

	// Show if comments open or closed but already have comments; hide if password protected
	if ( resurrect_show_comments() ) {

		$scroll_class = is_singular() ? 'resurrect-scroll-to-comments' : ''; // full post only

		comments_popup_link(
			__( '0 Comments', 'resurrect' ),
			__( '1 Comment', 'resurrect' ),
			__( '% Comments', 'resurrect' ),
			$scroll_class,
			'' // show nothing when comments off
		);

	}

}
endif;

if ( ! function_exists( 'resurrect_short_content' ) ) : // pluggable since not filterable
/**
 * Output excerpt or post content up until <!--more--> quicktag
 *
 * @since 1.0
 * @global object Post object
 */
function resurrect_short_content() {

	global $post;

	$post_format = get_post_format();

	// Author used <!--more--> quicktag
	if ( ctfw_has_more_tag() ) {

		// Make it work in pages / "loop after content"
		// See this: http://codex.wordpress.org/Customizing_the_Read_More#How_to_use_Read_More_in_Pages
		global $more;
		$more = 0;

		the_content( '' ); // no automatic "more" link; use footer template's link

	}

	// Show excerpt only
	else {
		the_excerpt();
	}

}
endif;
