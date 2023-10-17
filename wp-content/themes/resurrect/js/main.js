/**
 * Main JavaScript
 */

jQuery(document).ready(function ($) {

	/******************************************
	 * LAYOUT
	 ******************************************/

	// Retina Logo
	// Set dimensions from normal image on retina logo element for proper sizing
	// CSS handles switching between two images with media queries
	// This method works best for Opera Mobile
	if ($('#resurrect-logo-hidpi').length) { // Retina version provided
		$('<img>').attr('src', $('#resurrect-logo-regular').attr('src')).on('load', function () {
			$('#resurrect-logo-hidpi').attr('width', this.width).attr('height', this.height);
		});
	}

	// Header Menu
	if ($('#resurrect-header-menu-links').children().length > 0) { // menu is not empty

		var menu_items;

		// Superfish Dropdowns ( for regular screens )
		resurrect_activate_menu();

	}

	/******************************************
	 * FORCE "FULL SITE"
	 ******************************************/

	// These things are done client-side so that it works with caching plugins

	// See more immediately executed code in <head> (better speed with caching and mobile)

	// "View Full Site" / "View Mobile Site" footer link clicked
	$('#resurrect-footer-responsive-toggle a').on('click', function (e) {

		e.preventDefault();

		// Switch to full site
		if (!$.cookie('resurrect_responsive_off')) {
			$.cookie('resurrect_responsive_off', 1, {
				path: resurrect_main.site_path, // work on any page
				secure: resurrect_main.is_ssl
			});
		}

		// Switch to mobile site
		else {
			$.removeCookie('resurrect_responsive_off', {
				path: resurrect_main.site_path, // work on any page
				secure: resurrect_main.is_ssl
			});
		}

		// Reload the current page without re-posting
		window.location = window.location.href;

	});


	/******************************************
	 * SEARCH
	 ******************************************/

	// Submit on link button click
	$('.resurrect-search-button').on('click', function (event) {
		event.preventDefault();
		$(this).parent('form').trigger('submit');
	});

	// Trim search query and stop of empty
	$('.resurrect-search-form form').on('submit', function (event) {

		var s;

		s = $('input[name=s]', this).val().trim();

		if (s.length) { // submit trimmed value
			$('input[name=s]', this).val(s);
		} else { // empty, stop
			event.preventDefault();
		}

	});

	/******************************************
	 * HOMEPAGE
	 ******************************************/

	// Homepage Slider
	if ($('.flexslider').length) {

		// Load Flexslider
		// Note: waiting for all images to load takes too long on mobile
		//$( window ).load( function() { // after images loaded

		var enable_slideshow, single_slide;

		// Enable or disable automatic slideshow based on theme options
		enable_slideshow = resurrect_main.slider_slideshow;

		// If only one slide, add a second slide; otherwise slider will not initialize and video will not work properly (controls will be hidden after initialization)
		single_slide = false;
		if ($('.flexslider ul li').length == 1) {
			single_slide = true;
			enable_slideshow = false; // disable because only one slide (don't show hidden slide)
			$('.flexslider ul').append('<li></li>');
		}

		// Initialize slider
		$('#resurrect-slider .flexslider').flexslider({
			animationSpeed: 450,
			slideshow: enable_slideshow,					// Boolean: Animate slider slideshow
			slideshowSpeed: resurrect_main.slider_speed,	// Integer: Set the speed of the slideshow cycling, in milliseconds
			directionNav: false,							// Boolean: Create navigation for previous/next navigation? ( true/false )
			start: function (slider) { // when first slide loads

				var fade_speed, opacity;

				// Hide controls if only one slide ( see "if only only slide" above )
				if (single_slide) {
					$('.flex-control-nav').hide();
				}

				// Hover to lower opacity and fade in play button
				fade_speed = 200;
				fade_opacity = 0.5;
				if (!Modernizr.touch) { // not for mobile devices that cannot hover
					$('.resurrect-slide-video')
						.hover(function () { // hover in

							// Fade image and caption out, play button in
							if ($('.flex-image-container', this).is(':visible')) { // don't fade if it was hidden during video playback
								$('.flex-image-container img, .flex-title, .flex-description', this).stop().fadeTo(fade_speed, fade_opacity); /* title and desc, not parent caption container, so can fade title in alone */
								$('.flex-play-overlay', this).stop().fadeIn(fade_speed);
							}

							// Fade caption in on hover and return to faded out on mouse out
							$('a.flex-title', this) // only if it's linked somewhere other than video source
								.hover(function () { // hover in
									$(this).stop().fadeTo(fade_speed, 1);
								}, function () { // hover out
									$(this).stop().fadeTo(fade_speed, fade_opacity);
								});

						}, function () { // hover out

							// Fade image and caption back in, play button out
							if ($('.flex-image-container', this).is(':visible')) { // don't fade if it was hidden during video playback
								$('.flex-image-container img, .flex-title, .flex-description', this).stop().fadeTo(fade_speed, 1);
								$('.flex-play-overlay', this).stop().fadeOut(fade_speed);
							}

						});
				} else { // for mobile / touch devices always show "Play" overlay since cannot hover
					$('.flex-play-overlay').stop().fadeTo(0, fade_opacity);
				}

				// Click on title (if linked) goes to URL, does not play video
				$('a.flex-title').on('click', function (event) {
					event.stopPropagation(); // stop click on video overlay from happening, so title link will work
				});

				// Click on description goes to URL if this is not video slide
				$('.flex-description').on('click', function (event) {

					var click_url;

					// Make sure this is not video slide
					if (!$(this).parents('li').hasClass('resurrect-slide-video')) {

						event.preventDefault();

						// Is this slide linked?
						click_url = $('a', $(this).parents('li')).attr('href');

						// Go to URL
						if (click_url) {
							if ($(this).parents('.resurrect-slide-click-new').length > 0) {
								window.open(click_url, '_blank');
							} else {
								window.location.href = click_url;
							}
						}

					}

				});

				// Play video slide on click
				$('.flex-play-overlay, .flex-caption').on('click', function (event) { // clicked image of video slide ( or non linked title of caption ) in order to play video

					var slide_element, slide_id, video_url, video_html, match, vimeo_id, youtube_id;

					event.preventDefault();

					// Make sure this is video slide
					if (!$(this).parents('li').hasClass('resurrect-slide-video')) {
						return false;
					}

					// Get data
					slide_element = $(this).parents('.resurrect-slide-video');
					slide_id = slide_element.attr('id');
					video_url = $('a', slide_element).attr('href');
					video_html = '';

					// Vimeo
					if (video_url.indexOf('vimeo') > -1) {

						// Extract video ID from Vimeo URL and build HTML for player
						match = video_url.match(/\d+/);
						if (match && match[0].length) {
							vimeo_id = match[0];
							video_html = '<iframe src="' + resurrect_main.current_protocol + '://player.vimeo.com/video/' + vimeo_id + '?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff&amp;autoplay=1" width="960" height="350" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
						}

					}

					// YouTube
					else if (video_url.indexOf('youtu') > -1) { // match youtube.com or youtu.be

						// Get video ID from YouTube URL and build HTML for player
						// Helpful regex information here: http://bit.ly/13H4NKw
						match = video_url.match(/.*(?:youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=)([^#\&\?]*).*/);
						if (match && match[1].length == 11) {
							youtube_id = match[1];
							video_html = '<iframe src="' + resurrect_main.current_protocol + '://www.youtube.com/embed/' + youtube_id + '?wmode=transparent&amp;autoplay=1&amp;rel=0&amp;showinfo=0&amp;color=white&amp;modestbranding=1" width="960" height="350" frameborder="0" allowfullscreen></iframe>';
						}

					}

					// Show the video
					if (video_html) {

						// Pause slideshow
						slider.pause();

						// Hide slide image ( contains "play" overlay ) and caption
						$('.flex-image-container, .flex-title, .flex-description', slide_element).hide();

						// Destroy previous video frame if still there
						$('.resurrect-slide-video iframe').remove();

						// Inject the video iframe
						$(slide_element).append(video_html);

					}

				});

			},
			before: function () { // Before slide changes

				// Destroy all video iframes
				$('.resurrect-slide-video iframe').remove();

				// Show image and caption again, make sure faded to 100% as well
				$('.flex-image-container, .flex-image-container img, .flex-title, .flex-description').show().fadeTo(0, 1); // may be partially faded out from hover on video slide

				// Hide play button overlay
				if (!Modernizr.touch) { // except if we're using movile touch - no hover so want "play" overlay to show for clicking
					$('.flex-play-overlay').hide();
				}

			}

		});

		//} );

	}

	// Homepage Widgets
	if ($('#resurrect-home-bottom-widgets').length) {

		// Set jQuery Masonry on load and resize
		// (after images load and after resize in case need to adjust columns)
		$.event.special.debouncedresize.threshold = 50; // default is 250
		$(window).on('load debouncedresize', function () {

			var window_width, masonry_columns, $container;

			// Determine columns based on screen width
			window_width = jQuery(window).width();
			masonry_columns = 3;
			if (!$.cookie('resurrect_responsive_off')) { // if not forcing full site
				if (window_width <= 640) { // 640: Reduce to 1 columns as in CSS media query
					masonry_columns = 1;
				} else if (window_width <= 1024) { // 1024: Reduce to 2 columns as in CSS media query
					masonry_columns = 2;
				}
			}

			// Set masonry
			$container = $('#resurrect-home-bottom-widgets');
			$container.masonry({
				itemSelector: '.resurrect-home-widget',
				isAnimated: true,
				animationOptions: {
					duration: 350,
					easing: 'swing',
					queue: false
				},
				isResizable: false, // disable normal resizing
				columnWidth: ($container.width() / masonry_columns) // set column number based on screen size
			});

		});

		// Trigger resize to avoid issue HS 23523 in FF
		$(window).trigger('resize');

	}

	/******************************************
	 * SINGLE EVENT
	 ******************************************/

	// Single event only
	if ($('.resurrect-event-full').length) {

		// Recurrence / Excluded Dates tooltip
		$('.resurrect-event-meta-recurrence a, .resurrect-event-meta-excluded-dates a').tooltipster({
			theme: 'resurrect-tooltipster',
			arrow: false,
			animation: 'fade',
			speed: 250, // fade speed
		}).on('click', function (e) {
			e.preventDefault(); // stop clicks
		});

	}

	/******************************************
	 * EVENT CALENDAR
	 ******************************************/

	// Calendar template only
	if ($('#resurrect-calendar').length) {

		// Attach dropdowns to controls
		resurrect_attach_calendar_dropdowns();

		// AJAX-load event calendar when use controls
		// This keeps page from reloading and scrolling to top
		// PJAX updates URL, <title> and browser/back history
		$(document).pjax('.resurrect-calendar-control, .resurrect-calendar-dropdown a', '#resurrect-calendar', {
			fragment: '#resurrect-calendar', // replace only the calendar
			scrollTo: false, // don't scroll to top after loading
			timeout: 5000, // page reloads after timeout (default 650)
		});

		// Loading indicator
		$(document).on('pjax:send', function () {
			$('.resurrect-calendar-dropdown-control').dropdown('hide'); // hide controls
			$('#resurrect-calendar').fadeTo(250, 0.3);
		})
		$(document).on('pjax:complete', function () {
			$('#resurrect-calendar').fadeTo(50, 1); // show more suddenly
		})

		// After contents replaced
		$(document).on('pjax:success', function () {

			// Re-attach dropdowns to controls
			resurrect_attach_calendar_dropdowns();

			// Re-activate tooltip hovering
			resurrect_activate_calendar_hover();

		});

		// Hide dropdowns on back/forward
		$(document).on('pjax:popstate', function (e) {
			if (e.direction) {
				$('.resurrect-calendar-dropdown-control').dropdown('hide');
			}
		});

		// Use Tipster to show event hover for each link
		resurrect_activate_calendar_hover();

		// Handle mobile clicks on linked days
		$(document).on('click', 'a.resurrect-calendar-table-day-number', function (e) {

			var $day, $events, date_formatted, scroll_offset;

			e.preventDefault();

			// Get day cell
			$day = $(this).parents('td');

			// Show heading for date
			date_formatted = $day.attr('data-date-formatted');
			$('#resurrect-calendar-list h3:first-of-type').remove();
			$('#resurrect-calendar-list').prepend('<h3 id="resurrect-calendar-list-heading">' + date_formatted + '</h3>');
			$('#resurrect-calendar-list-heading').fadeIn(250);

			// Hide all events in list and show list container
			$('#resurrect-calendar-list .resurrect-calendar-list-entry').hide();
			$('#resurrect-calendar-list').show();

			// Show all events for this day
			$events = $('.resurrect-calendar-table-day-events li', $day);
			$events.each(function () {

				var event_id;

				// Get event ID
				event_id = $(this).attr('data-event-id');

				// Show that event in list
				$('#resurrect-calendar-list .resurrect-calendar-list-entry[data-event-id="' + event_id + '"]').fadeIn(250);

			});

			// Scroll down if events are out of view
			// Otherwise user sees no change
			if (!$('#resurrect-calendar-list-heading').visible()) {

				// Scroll events into bottom of screen
				scroll_offset = 0 - $(window).height() + 150; // negative

				$.smoothScroll({
					scrollTarget: '#resurrect-calendar-list-heading',
					offset: scroll_offset,
					easing: 'swing',
					speed: 800
				});

			}

		});

	}

	/******************************************
	 * GALLERIES
	 ******************************************/

	// Make clicks on caption also go to URL
	$('.gallery-caption').on('click', function () {

		var $parent, url;

		$parent = $(this).parent();
		url = $('a', $parent).prop('href');

		// Go to URL if no data- attributes, which indicate Jetpack Carousel or possbily other lightbox
		if (url && $.isEmptyObject($('.gallery-icon img', $parent).data())) {
			window.location = url;
		}

	});

	// When Carousel lightbox image linked to directly via #jp-carousel-# and there are other galleries
	// on page (widgets), causes GET /galleries/three-column-gallery/undefined 404 (Not Found)
	// and prev/next do not work properly, so remove gallery widgets then re-add after lightbox loads
	$(window).on('load hashchange', function () {

		var carousel_hash_match, attachment_id, $sidebar_contents;

		// Match ID in Carousel hash
		carousel_hash_match = window.location.hash.match(/jp-carousel-([0-9]+)/);

		// Lightbox invoked if Carousel hash found
		if (carousel_hash_match) {

			// Get ID from hash
			attachment_id = carousel_hash_match[1];

			// Page has gallery widgets and image invoked is in page content (could be in widget)
			if ($('.widget_ctfw-gallery').length && $('.resurrect-entry-content img[data-attachment-id=' + attachment_id + ']').length) {

				// Get sidebar contents (with galleries)
				$sidebar_contents = $('#resurrect-sidebar-right').children();

				// Remove sidebar contents
				$('.widget_ctfw-gallery').remove();

				// Re-add sidebar contents (galleries) after lightbox has time to open
				setTimeout(function () {
					$('#resurrect-sidebar-right').append($sidebar_contents);
					resurrect_apply_widget_classes(); // re-add helper classes
				}, 250);

			}

		}

	});

	/*---------------------------------------------
	 * Buttons
	 *--------------------------------------------*/

	// Use theme styles for Gutenberg buttons.
	$('.wp-block-button').each(function () {

		var align_class = '';
		if ($(this).hasClass('alignleft')) {
			align_class = 'alignleft';
		} else if ($(this).hasClass('alignright')) {
			align_class = 'alignright';
		} else if ($(this).hasClass('aligncenter')) {
			align_class = 'aligncenter';
		}

		// Get button link.
		if ($('a', this).length) {
			var $button_link = $('a', this);
		} else if ($('button', this).length) {
			var $button_link = $('button', this);
		}

		// Remove class and style from button.
		$button_link
			.removeClass()
			.removeAttr('style', '') // color.
			.addClass('resurrect-button')
			.addClass('resurrect-button-block')
			.addClass(align_class);

		// Move button outside of container then remove container.
		$(this)
			.after($button_link)
			.remove();

		// Show button (hidden in style.css).
		$button_link.css('visibility', 'visible')

	});

	// Use theme styled button for search.
	$('.wp-block-search__button').each(function () {
		$(this).addClass('resurrect-button');
	});

	/******************************************
	 * COMMENTS
	 ******************************************/

	// Scroll to comments when comments link at top of single page/post clicked
	if ($('a.resurrect-scroll-to-comments').length) {
		$('a.resurrect-scroll-to-comments').smoothScroll({
			offset: -60,
			easing: 'swing',
			speed: 1200
		});
	}

	// Scroll to comments when link from another page is clicked
	if ('#comments' == window.location.hash || '#respond' == window.location.hash) {

		// Scroll down
		$.smoothScroll({
			scrollTarget: '#comments',
			easing: 'swing',
			speed: 1200
		});

	}

	// Comment Validation using jQuery Validation Plugin by Jörn Zaefferer
	// http://bassistance.de/jquery-plugins/jquery-plugin-validation/
	if (jQuery().validate) { // if plugin loaded

		var $validate_params, $validate_comment_field;

		// Parameters
		$validate_params = {
			rules: {
				author: {
					required: resurrect_main.comment_name_required !== '' ? true : false // if WP configured to require
				},
				email: {
					required: resurrect_main.comment_email_required !== '' ? true : false, // if WP configured to require
					email: true // check validity
				},
				url: 'url' // optional but check validity
			},
			messages: { // localized error strings
				author: resurrect_main.comment_name_error_required,
				email: {
					required: resurrect_main.comment_email_error_required,
					email: resurrect_main.comment_email_error_invalid
				},
				url: resurrect_main.comment_url_error_invalid
			}
		};

		// Comment textarea
		// Use ID instead of name to work with Antispam Bee plugin which duplicates/hides original textarea
		$validate_comment_field = $('#comment').attr('name');
		$validate_params['rules'][$validate_comment_field] = 'required';
		$validate_params['messages'][$validate_comment_field] = resurrect_main.comment_message_error_required;

		// Validate the form
		$('#commentform').validate($validate_params);

	}

	/******************************************
	 * WIDGETS
	 ******************************************/

	// Helper classes for better rendering
	// Reused in Carousel code
	resurrect_apply_widget_classes();

	// Categories dropdown redirect
	$('.resurrect-dropdown-taxonomy-redirect').on('change', function () {

		var taxonomy, term_id;

		taxonomy = $(this).prev('input[name=taxonomy]').val();
		term_id = $('option:selected', this).val();

		if (taxonomy && term_id && -1 != term_id) {
			location.href = resurrect_main.home_url + '/?redirect_taxonomy=' + taxonomy + '&redirect_term_id=' + term_id;
		}

	});

	/************** BODY CLASSES **************/

	// iOS Detection
	// Useful for changing background-attachment to scroll, because iOS doesn't support fixed
	if (navigator.userAgent.match(/iPad|iPod|iPhone|iWatch/)) {
		jQuery('body').addClass('resurrect-is-ios');
	} else {
		jQuery('body').addClass('resurrect-not-ios');
	}

});

/******************************************
 * FUNCTIONS
 ******************************************/

/************ MENU ACTIVATION *************/

var $resurrect_header_menu_raw; // make accessible to resurrect_activate_menu() later

// Activate Menu Function
// Also used in Customizer admin preview JS
function resurrect_activate_menu() {

	var $header_menu_raw_list, $header_menu_raw_items;

	// Continue if menu not empty
	if (!jQuery('#resurrect-header-menu-links').children().length) {
		return;
	}

	// Make copy of menu contents before Superfish modified
	// Original markup works better with MeanMenu (less Supersubs and styling issues)
	if (!jQuery($resurrect_header_menu_raw).length) { // not done already
		$resurrect_header_menu_raw = jQuery('<div></div>'); // Create empty div
		$header_menu_raw_list = jQuery('<ul></ul>'); // Create empty list
		$header_menu_raw_items = jQuery('#resurrect-header-menu-links').html(); // Get menu items
		$header_menu_raw_list = $header_menu_raw_list.html($header_menu_raw_items); // Copy items to empty list
		$resurrect_header_menu_raw = $resurrect_header_menu_raw.html($header_menu_raw_list); // Copy list to div
	}

	// Regular Menu (Superfish)
	jQuery('#resurrect-header-menu-links').supersubs({ // Superfish dropdowns
		minWidth: 12,	// minimum width of sub-menus in em units
		maxWidth: 15,	// maximum width of sub-menus in em units
		extraWidth: 1	// extra width can ensure lines don't sometimes turn over due to slight rounding differences and font-family
	}).superfish({
		delay: 0,
		disableHI: false,
		speed: 250, // animation
		animation: {
			opacity: 'show',
			//height:'show'
		},
		onInit: function () {

			// Responsive Menu (MeanMenu) for small screens
			// Replaces regular menu with responsive controls
			// Init after Superfish done because Supersubs needs menu visible for calculations
			jQuery($resurrect_header_menu_raw).meanmenu({
				meanMenuContainer: '#resurrect-header-menu',
				meanScreenWidth: 640, // use responsive.css to hide #resurrect-header-menu-links at same size
				meanRevealPosition: 'center',
				meanRemoveAttrs: true, // remove any Superfish classes, duplicate item ID's, etc.
				removeElements: '#resurrect-header-menu-inner' // toggle visibility of regular
			});

		},
		onBeforeShow: function () {

			// Make dropdowns on right open to the left if will go off screen
			// This considers that the links may have wrapped and dropdowns may be mobile-size

			var $link, $dropdown, $dropdown_width, $offset;

			// Detect if is first-level dropdown and if not return
			if (jQuery(this, '#resurrect-header-menu-links').parents('li.menu-item').length != 1) {
				return;
			}

			// Top-level link hovered on
			$link = jQuery(this).parents('#resurrect-header-menu-links > li.menu-item');

			// First-level dropdown
			$dropdown = jQuery('> ul', $link);

			// First-level dropdown width
			$dropdown_width = $dropdown.outerWidth();
			$dropdown_width_adjusted = $dropdown_width - 14; // compensate for left alignment

			// Remove classes first in case don't need anymore
			$link.removeClass('resurrect-dropdown-align-right resurrect-dropdown-open-left');

			// Get offset between left side of link and right side of window
			$offset = jQuery(window).width() - $link.offset().left;

			// Is it within one dropdown length of window's right edge?
			// Add .resurrect-dropdown-align-right to make first-level dropdown not go off screen
			if ($offset < $dropdown_width_adjusted) {
				$link.addClass('resurrect-dropdown-align-right');
			}

			// Is it within two dropdown lengths of window's right edge?
			// Add .resurrect-dropdown-open-left to open second-level dropdowns left: https://github.com/joeldbirch/superfish/issues/98
			if ($offset < ($dropdown_width_adjusted * 2)) {
				$link.addClass('resurrect-dropdown-open-left');
			}

		},
	});

}

/************ HELPER CLASSES **************/

// Helper classes for better rendering
// Reused in Carousel code
function resurrect_apply_widget_classes() {

	// Add class to widgets that use a title, to make styling even nicer
	jQuery('.resurrect-widget').each(function () {
		if (jQuery('.resurrect-widget-title', this).length) {
			jQuery(this).addClass('resurrect-widget-has-title');
		}
	});

	// Apply classes that will assist IE8 which does not support certain selectors
	// Note: this is only for selectors that selectivizr.js does not provide for
	jQuery('.resurrect-widget').find('> :not( .resurrect-widget-title ):first').addClass('resurrect-widget-first-element'); // same as .resurrect-widget > :not( .resurrect-widget-title ):first-of-type

}

/***************** FONTS ******************/

// Change <body> helper font/setting class
// Used by Theme Customizer (and front-end demo customizer)
function resurrect_update_body_font_class(setting, font) {

	var setting_slug, font_slug, body_class;

	// Prepare strings
	setting_slug = setting.replace(/_/g, '-');
	font_slug = font.toLowerCase().replace(/\s/g, '-'); // spaces to -
	body_class = 'resurrect-' + setting_slug + '-' + font_slug;

	// Remove old class
	jQuery('body').removeClass(function (i, css_class) { // helpful information: http://bit.ly/1f7KH3f
		return (css_class.match(new RegExp('\\b\\S+-' + setting_slug + '-\\S+', 'g')) || []).join(' ');
	})

	// Add new class
	jQuery('body').addClass(body_class);

}

/************* EVENT CALENDAR *************/

// Attach calendar dropdowns to controls
// Used on load and after PJAX replaces content
function resurrect_attach_calendar_dropdowns() {

	// Remove it from before </body> if already exists (old before PJAX)
	jQuery('body > #resurrect-calendar-month-dropdown').remove();
	jQuery('body > #resurrect-calendar-category-dropdown').remove();

	// Move it from calendar container to before </body>
	// jQuery Dropdown work sbest with it there
	// But need it in main calendar container for PJAX to get new contents of dropdowns
	jQuery('#resurrect-calendar-month-dropdown').appendTo('body');
	jQuery('#resurrect-calendar-category-dropdown').appendTo('body');

	// Re-attach dropdown to control
	jQuery('#resurrect-calendar-month-control').dropdown('attach', '#resurrect-calendar-month-dropdown');
	jQuery('#resurrect-calendar-category-control').dropdown('attach', '#resurrect-calendar-category-dropdown');

}

// Use Tipster to show calendar's event hover for each link
function resurrect_activate_calendar_hover() {

	// Use Tipster to show event hover for each link
	jQuery('.resurrect-calendar-list-entry').each(function () {

		var event_id;

		// Get ID
		event_id = jQuery(this).attr('data-event-id');

		// Activate tooltips on links having that ID
		if (event_id) {
			jQuery('.resurrect-calendar-table-day-events a[data-event-id="' + event_id + '"]').tooltipster({
				theme: 'resurrect-tooltipster-calendar',
				content: jQuery(this),
				contentCloning: true,
				functionInit: function (origin, content) {

					var date_formatted;

					// Get localized date from calendar
					date_formatted = jQuery(origin).parents('td').attr('data-date-formatted');

					// Add date to the tooltip
					jQuery('.resurrect-calendar-list-entry-date', content).html(date_formatted);

					return content;

				},
				minWidth: 400,
				maxWidth: 600,
				touchDevices: false, // no hovers on touch, unless also has mouse
				interactive: true, // let them click on tooltip
				arrow: false,
				animation: 'fade',
				speed: 250, // fade speed
				onlyOne: true, // immediately close other tooltips when opening
			});
		}

	});

}

/******************************************
 * <HEAD>
 ******************************************/

// Stop Edge browser from linking phone numbers.
// Later, when possible, style the links instead of removing.
if (/Edge/.test(navigator.userAgent)) {
	jQuery('head').append('<meta name="format-detection" content="telephone=no">');
}

/******************************************
 * GOOGLE MAPS
 ******************************************/

// Global marker image
var ctfw_map_marker_image = resurrect_main.color_url + '/images/map-icon.png';
//var ctfw_map_marker_image_hidpi = resurrect_main.color_url + '/images/map-icon@2x.png';
//var ctfw_map_marker_image_width = 26; // only necessary when providing HiDPI image
//var ctfw_map_marker_image_height = 26;
