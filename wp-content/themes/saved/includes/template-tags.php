<?php
/**
 * Template Tags
 *
 * These output common elements for different post types. Use in content-*.php templates.
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

/********************************
 * TITLE
 ********************************/

/**
 * Output page title with "(Page #)" as needed
 *
 * @since 1.0
 * @param string $title Title of page
 * @param bool $return Return or echo title with page number
 * @return string Page title woth number if not echoing
 */
function saved_title_paged( $title = '', $return = false ) {

	// Default title if none passed in
	if ( empty( $title ) ) {

		// Sermon wording.
		$sermon_word_singular = ctfw_sermon_word_singular();
		$sermon_word_plural = ctfw_sermon_word_plural();

		// Single Post (post, page, sermon, event, attachment, etc.)
		if ( is_singular() ) {
			$title = get_the_title();
		}

		// Blog Archive
		elseif ( ctfw_is_posts_page() ) {
			$title = get_post_field( 'post_title', get_queried_object_id() );
		}

		// Blog Category
		elseif ( is_category() ) {
			$title = single_cat_title( '', false );
		}

		// Blog Tag
		elseif ( is_tag() ) {
			$title = sprintf( __( "'%s' Tagged Posts", 'saved' ), single_tag_title( '', false ) );
		}

		// Custom Taxonomy
		elseif ( is_tax() ) {

			// Title format depends on taxonomy; default shows taxonomy alone
			$taxonomy = get_query_var( 'taxonomy' );
			$taxonomy_titles = array(
				/* translators: %1$s is "Sermons" (plural, translated or changed by settings), %2$s represents sermon topic */
				'ctc_sermon_topic' 		=> _x( '%1$s on %2$s', 'sermon topic', 'saved' ),
				/* translators: %1$s is "Sermons" (plural, translated or changed by settings), %2$s represents Bible book */
				'ctc_sermon_book' 		=> _x( '%1$s on %2$s', 'sermon book', 'saved' ),
				/* translators: %1$s is "Sermons" (plural, translated or changed by settings), %2$s represents sermon speaker name */
				'ctc_sermon_speaker' 	=> _x( '%1$s by %2$s', 'sermon speaker', 'saved' ),
				/* translators: %1$s is "Sermons" (plural, translated or changed by settings), %2$s represents sermon tag term */
				'ctc_sermon_tag' 		=> _x( '"%2$s" Tagged %1$s', 'sermon tag', 'saved' ),
			);
			$taxonomy_title = isset( $taxonomy_titles[$taxonomy] ) ? $taxonomy_titles[$taxonomy] : '%2$s';

			// Title with replacements.
			$title = sprintf(
				$taxonomy_title,
				$sermon_word_plural,
				single_term_title( '', false )
			);

		}

		// Author Archive
		elseif ( is_author() ) {
			$title = sprintf( __( "Posts by %s", 'saved' ), get_the_author() );
		}

		// Search results
		elseif ( is_search() ) {
			$title = sprintf( __( "Search for '%s'", 'saved' ), get_search_query() );
		}

		// Date Archive
		elseif ( is_day() || is_month() || is_year() ) {

			// Date format
			if ( is_day() ) {
				$date = get_the_date();
			} else if ( is_month() ) {
				$date = get_the_date( _x( 'F Y', 'monthly archives date format', 'saved' ) );
			} else if ( is_year() ) {
				$date = get_the_date( _x( 'Y', 'yearly archives date format', 'saved' ) );
			}

			// Title format depends on post type
			$post_type = get_post_type();
			$archive_titles = array(
				/* translators: %1$s represents date */
				'post'			=> __( 'Posts from %1$s', 'saved' ),
				/* translators: %2$s is "Sermons" (plural, translated or changed by settings), %1$s represents date. Example "Sermons from 2017" */
				'ctc_sermon'	=> _x( '%2$s from %1$s', 'sermon archive', 'saved' ),
 			);
			$archive_title = isset( $archive_titles[$post_type] ) ? $archive_titles[$post_type] : '%1$s';

			// Title with replacements.
			$title = sprintf(
				$archive_title,
				esc_html( $date ),
				esc_html( $sermon_word_plural )
			);

		}

		// Post Type Archive
		// When page template not used to output post type items
		elseif ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		}

		// Generic Archive
		elseif ( is_archive() ) {
			$title =  __( 'Archives', 'saved' );
		}

		// Blog as Homepage
		// "Front page shows" is set to "Your latest posts"
		elseif ( is_home() && is_front_page() ) {

			$title = '';

			$blog_page_id = ctfw_get_page_id_by_template( 'blog.php' );

			if ( $blog_page_id ) {
				$title = get_the_title( $blog_page_id );
			}

		}

		// Not Found
		elseif ( is_404() ) {
			$title = __( 'Not Found', 'saved' );
		}

		// Other, just in case
		else {
			$title = get_the_title(); // use singular title
		}

	}

	// Get page number
	$show_number = ctfw_page_num();

	// Title format if on page 2 or greater
	/* translators: %s is page title, %d is page number */
	if ( $show_number > 1 ) {
		$title_paged = sprintf( __( '%s <span>(Page %d)</span>', 'saved' ), $title, $show_number );
	}

	// Default title for Page 1 (or no number found)
	else {
		$title_paged = $title;
	}

	// Make filterable
	$output = apply_filters( 'saved_title_paged', $title_paged, $title );

	// Echo or return
	if ( $return ) {
		return $output;
	} else {
		echo $output;
	}

}

/********************************
 * CONTENT
 ********************************/

/**
 * Output excerpt
 *
 * @since 1.0
 */
function saved_short_content() {

	$excerpt = get_the_excerpt();

	$new_excerpt = strip_tags( $excerpt );
	$new_excerpt = str_replace( ' [&hellip;]', '&hellip;', $new_excerpt );
	$new_excerpt = wptexturize( $new_excerpt );

	$new_excerpt = apply_filters( 'saved_short_content', $new_excerpt, $excerpt );

	return $new_excerpt;

}

/**
 * Output entry widget excerpt
 *
 * @since 1.0
 * @return string Excerpt for post
 */
function saved_entry_widget_excerpt() {

	global $post;

	$excerpt = get_the_excerpt();

	$excerpt = strip_tags( $excerpt );
	$excerpt = ctfw_shorten( $excerpt, 180 );
	$excerpt = str_replace( ' [&hellip;]', '&hellip;', $excerpt );
	$excerpt = wptexturize( $excerpt );

	echo apply_filters( 'saved_entry_widget_excerpt', $excerpt );

}

/**
 * Add classes to short entry
 *
 * A wrapper for post_class() that adds other useful classes.
 *
 * @since 1.0
 * @param string $classes Classes to add in addition to the automatic classes.
 * @return string Classes for the entry container
 */
function saved_short_post_classes( $classes = false ) {

	if ( ! $classes ) {
		$classes = '';
	}

	$classes .= ' saved-entry-short';

	// Has image
	if ( has_post_thumbnail() ) {
		$classes .= ' saved-entry-has-image';
	} else {
		$classes .= ' saved-entry-no-image';
	}

	// Has excerpt
	if ( saved_short_content() ) {
		$classes .= ' saved-entry-has-excerpt';
	} else {
		$classes .= ' saved-entry-no-excerpt';
	}

	$classes = trim( $classes );

	// Make filterable
	$classes = apply_filters( 'saved_short_post_classes', $classes );

	// Output it with WordPress classes
	post_class( $classes );

}

/**
 * Add classes to compact entry
 *
 * A wrapper for post_class() that adds other useful classes.
 *
 * @since 1.0
 * @param array $args of classes and widget_intance
 * @return string Classes for the entry container
 */
function saved_compact_post_classes( $args = array() ) {

	// Default arguments

	$args = wp_parse_args( $args, array(
		'classes'			=> '',
		'widget_instance'	=> null, // not set
	) );

	// Extract arguments
	extract( $args );

	// Append standard class
	$classes .= ' saved-entry-compact';

	// Has image
	// If widget_instance given, make sure show_image is set; otherwise just check for image
	if ( ( ( ! empty( $widget_instance ) && $widget_instance['show_image'] ) || empty( $widget_instance ) ) && has_post_thumbnail() ) {
		$classes .= ' saved-entry-has-image';
	} else {
		$classes .= ' saved-entry-no-image';
	}

	// Trim
	$classes = trim( $classes );

	// Make filterable
	$classes = apply_filters( 'saved_compact_post_classes', $classes );

	// Output it with WordPress classes
	post_class( $classes );

}
