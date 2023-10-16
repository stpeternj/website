<?php
/**
 * Icon Functions
 *
 * @package    Saved
 * @subpackage Functions
 * @copyright  Copyright (c) 2017 - 2019, ChurchThemes.com
 * @link       https://churchthemes.com/themes/saved
 * @license    GPLv2 or later
 * @since      1.0
 */

// No direct access
if (! defined( 'ABSPATH' )) exit;

/***********************************
 * ICON FONT
 ***********************************

/**
 * Get icon class
 *
 * Return icon class for specific element, for easy filtering to replace icons in specific areas.
 * This can also make switching to another icon font easier.
 *
 * For social icons to filter, see saved_social_icon_map() below.
 *
 * Note on SIL font license and why it can be included with 100% GPL Theme:
 * https://make.wordpress.org/plugins/2013/05/01/font-awesome/#comment-38477
 *
 * @since 1.0
 * @param string $element Element icon used with
 * @return string Icon class
 */
function saved_get_icon_class( $element ) {

	// Elements and their classes
	$classes = array(
		'search-button'			=> 'mdi mdi-magnify', 					// header and widget
		'search-cancel'			=> 'mdi mdi-close',
		'mobile-menu-close'		=> 'mdi mdi-close',
		'nav-block-left'		=> 'mdi mdi-chevron-left', 				// prev/next on single post
		'nav-block-right'		=> 'mdi mdi-chevron-right',
		'nav-links-left'		=> 'mdi mdi-chevron-left',				// pagination < 1 2 3 > on archives
		'nav-links-right'		=> 'mdi mdi-chevron-right',
		'nav-button-left'		=> 'mdi mdi-chevron-left', 				// prev/next in button (comments, multi-page posts, attachment)
		'nav-button-right'		=> 'mdi mdi-chevron-right',
		'archive-dropdown'		=> 'mdi mdi-chevron-down', 				// header archive dropdowns
		'breadcrumb-separator'	=> 'mdi mdi-chevron-right',
		'comment-reply'			=> 'mdi mdi-comment', 					// "Reply" button on comment
		'comment-edit'			=> 'mdi mdi-pencil', 					// "Edit" button on comment
		'download'				=> 'mdi mdi-download', 					// generic download
		'video-watch'			=> 'mdi mdi-video',						// sermon
		'video-download'		=> 'mdi mdi-video', 					// sermon
		'audio-listen'			=> 'mdi mdi-headphones', 				// sermon
		'audio-download'		=> 'mdi mdi-headphones', 				// sermon
		'pdf-download'			=> 'mdi mdi-file-pdf', 					// sermon
		'sermon-read'			=> 'mdi mdi-file-document-box',
		'sermon-topic'			=> 'mdi mdi-folder',					// widget and archive
		'sermon-book'			=> 'mdi mdi-book-open-page-variant', 	// widget and archive
		'sermon-series'			=> 'mdi mdi-fast-forward',				// widget and archive
		'sermon-speaker'		=> 'mdi mdi-account',					// widget and archive
		'sermon-date'			=> 'mdi mdi-calendar-blank',			// widget and archive
		'calendar-remove'		=> 'mdi mdi-close',						// remove category filter
		'calendar-prev'			=> 'mdi mdi-chevron-left',
		'calendar-next'			=> 'mdi mdi-chevron-right',
		'calendar-month'		=> 'mdi mdi-calendar-blank',
		'calendar-category'		=> 'mdi mdi-folder',
		'map-marker'			=> 'mdi mdi-map-marker',				// marker on map
		'sticky-dismiss'		=> 'mdi mdi-close', 					// bottom sticky bar
	);

	// Make array filterable
	$classes = apply_filters( 'saved_icon_classes', $classes, $element );

	// Get class for element
	$class = '';
	if (! empty( $classes[$element] )) {
		$class = $classes[$element];
	}

	// Add helper classes
	// Helpful to use .saved-icon in place of .mdi in case switch icon fonts
	// Also helpful to use .saved-icon-$element key for the same reason
	$class = 'saved-icon saved-icon-' . $element . ' ' . $class;

	// Return filterable
	return apply_filters( 'saved_get_icon_class', $class, $element );

}

/**
 * Output icon class
 *
 * Output contents of saved_get_icon_class()
 *
 * @since 1.0
 * @param string $element Element icon used with
 * @param bool $return Whether or not to return (false echos)
 * @return string If echoing class
 */
function saved_icon_class( $element, $return = false ) {

	$class = apply_filters( 'saved_icon_class', saved_get_icon_class( $element ) );

	if ($return) {
		return $class;
	} else {
		echo $class;
	}

}

/***********************************
 * SOCIAL ICONS (Header/Footer)
 ***********************************

/**
 * Icons available
 *
 * This is used in displaying icons with saved_social_icons() and
 * to tell which social networks are supported with saved_social_icon_sites().
 *
 * Note on SIL font license and why it can be included with 100% GPL Theme:
 * https://make.wordpress.org/plugins/2013/05/01/font-awesome/#comment-38477
 *
 * @since 1.0
 * @return array Icon map
 */
function saved_social_icon_map() {

	 // Social media sites with icons
	$icon_map = array(

		// CSS Class 								// Match in URL 	// Site Name 								// Hide in list (set true)
		'mdi mdi-facebook-box'			=> array(	'facebook',			esc_html__( 'Facebook', 'saved' ) ),
		'mdi mdi-twitter'				=> array(	'twitter',			esc_html__( 'Twitter', 'saved' ) ),
		'mdi mdi-google-plus'			=> array(	'plus.google',		esc_html__( 'Google+', 'saved' ) ),
		'mdi mdi-youtube-play'			=> array( 	'youtube',			esc_html__( 'YouTube', 'saved' ) ),
		'mdi mdi-vimeo'					=> array( 	'vimeo', 			esc_html__( 'Vimeo', 'saved' ) ),
		'mdi mdi-instagram'				=> array( 	'instagram',		esc_html__( 'Instagram', 'saved' ) ),
		'mdi mdi-pinterest'				=> array( 	'pinterest',		esc_html__( 'Pinterest', 'saved' ) ),
		'mdi mdi-soundcloud'			=> array( 	'soundcloud', 		esc_html__( 'SoundCloud', 'saved' ) ),
		'mdi mdi-linkedin'				=> array( 	'linkedin', 		esc_html__( 'LinkedIn', 'saved' ) ), // used by People profiles
		'mdi mdi-wordpress'				=> array( 	'wordpress', 		esc_html__( 'WordPress', 'saved' ) ), // used by People profiles
		'mdi mdi-tumblr'				=> array( 	'tumblr', 			esc_html__( 'Tumblr', 'saved' ) ), // used by People profiles
		'mdi mdi-email'					=> array( 	array(
														'mailto',
														'newsletter'
													),					esc_html__( 'Email', 'saved' ) ),
		'mdi mdi-google-play'			=> array( 	array(
														'play.google',
														'playmusic.app.goo.gl',
														'podcasts.google',
													), 					esc_html__( 'Google Play', 'saved' ) ),
		'mdi mdi-microphone'			=> array( 	array(
														'itunes',
														'podcasts.apple',
														'podcast',
														'sermonaudio.com',
														'castbox',
														'libsyn',
													), 					esc_html__( 'Podcast', 'saved' ) ), 	// general podcast icon will be better than this or iTunes icon
		'mdi mdi-spotify'				=> array( 	'spotify', 			esc_html__( 'Spotify', 'saved' ) ),
		'mdi mdi-apple'					=> array( 	'apple.com', 		esc_html__( 'App Store', 'saved' ) ), 	// for apps
		'mdi mdi-rss'					=> array( 	array(
														'rss',
														'feed',
														'atom'
													),					esc_html__( 'RSS', 'saved' ) ),
		'mdi mdi-whatsapp'				=> array( 	'whatsapp', 		esc_html__( 'WhatsApp', 'saved' ),			true ),
		'mdi mdi-vine'					=> array( 	'vine.co', 			esc_html__( 'Vine', 'saved' ),				true ),
		'mdi mdi-skype'					=> array( 	'skype', 			esc_html__( 'Skype', 'saved' ),				true ),
		'mdi mdi-web'					=> array( 	'http', 			esc_html__( 'Website', 'saved' ) ),		 // anything not matching the above will show a generic website icon

	);

	// Return filtered
	return apply_filters( 'saved_social_icon_map', $icon_map );

}

/**
 * List of sites with icons
 *
 * Shown to user in Theme Customizer
 *
 * @since 1.0
 * @param bool $or True to use "or"; otherwise "and"
 * @return string List of sites with icons
 */
function saved_social_icon_sites( $or = false ) {

	$icon_map = saved_social_icon_map();

	$sites_with_icons = '';

	$i = 0;

	// Remove hidden entries
	foreach ($icon_map as $class => $site_data) { // make list of sites with icons
		if (! empty( $site_data[2] )) {
			unset( $icon_map[$class] );
		}
	}

	// Count sites
	$sites_with_icons_count = count( $icon_map );

	// Build list
	foreach ($icon_map as $site_data) { // make list of sites with icons

		$match = $site_data[0];
		$name = $site_data[1];

		$i++;

		if ($i > 1) { // not first one
			if ($i < $sites_with_icons_count) { // not last one
				$sites_with_icons .= _x( ', ', 'social icons list', 'saved' );
			} else { // last one
				if (! empty( $or )) {
					$sites_with_icons .= _x( ' or ', 'social icons list', 'saved' );
				} else {
					$sites_with_icons .= _x( ' and ', 'social icons list', 'saved' );
				}
			}
		}

		$sites_with_icons .= $name;

	}

	return apply_filters( 'saved_social_icon_sites', $sites_with_icons );

}

/**
 * Show icons
 *
 * @since 1.0
 * @param array $urls URLs set in Customizer
 * @param bool $return Return or echo
 * @return string Icons HTML if not echoing
 */
function saved_social_icons( $urls, $return = false ) {

	$icon_list = '';

	// Social media URLs defined in Customizer
	if (! empty( $urls )) {

		// Available Icons
		$icon_map = saved_social_icon_map();

		// Loop URLs (in order entered by user) to build icon list
		$icon_items = '';
		$url_array = explode( "\n", $urls );
		foreach ($url_array as $url) {

			$url = trim( $url );

			// URL is valid
			if (! empty( $url ) && ( '[ctcom_rss_url]' == $url || preg_match( '/^(http(s*)):\/\/(.+)\.(.+)|skype:(.+)|mailto:(.+)@(.+)\.(.+)/i', $url ) )) { // basic URL check

				// Find matching icon
				foreach ($icon_map as $icon_class => $site_data) {

					// Data
					$match = $site_data[0];
					$name = $site_data[1];

					// If "Any Website", use domain of website as name
					// Useful because it may not be a website at all being linked to (social profile, feed, etc.)
					// This is just a little more descriptive
					$domain_as_name = false;
					if ('http' == $match || 'Website' == $name) {
						$domain_as_name = true;
					}

					// Prepare to match
					$url_checks = (array) $match;
					$url_matched = false;

					// Loop each string to match
					foreach ($url_checks as $url_match) {

						// Check URL for matching string
						if (preg_match( '/' . preg_quote( $url_match ) . '/i', $url ) && ! $url_matched) {

							// Success
							$url_matched = true;

							// Use domain as name (see above)
							if ($domain_as_name) {
								$parsed_url = parse_url( $url );
								$name = ! empty( $parsed_url['host'] ) ? str_replace( 'www.', '', $parsed_url['host'] ) : $name;
							}

							// Run shortcodes for [ctcom_rss_url]
							$url = do_shortcode( $url );

							// Acceptable protocols.
							// Allow skype.
							$protocols = array_merge( wp_allowed_protocols(), array(
								'skype',
							) );

							// Append icon
							$icon_items .= '	<li><a href="' . esc_url( $url, $protocols ) . '" class="' . esc_attr( $icon_class ) . '" title="' . esc_attr( $name ) . '" target="' . apply_filters( 'saved_social_icons_link_target', '_blank' ) . '" rel="noopener noreferrer"></a></li>' . "\n";

						}

					}

					// Done
					if ($url_matched) {
						break;
					}

				}

			}

		}

		// Wrap with <ul> tags and apply shortcodes
		if (! empty( $icon_items )) {
			$icon_list = '<ul class="saved-list-icons">' . "\n";
			$icon_list .= $icon_items;
			$icon_list .= '</ul>';
		}

	}

	// Echo or return filtered
	$icon_list = apply_filters( 'saved_social_icons', $icon_list, $urls );
	if ($return) {
		return $icon_list;
	} else {
		echo $icon_list;
	}

}
