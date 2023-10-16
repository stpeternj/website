/**
 * Main JavaScript
 */

/*---------------------------------------------
 * Variables
 *--------------------------------------------*/

// Max width for mobile
var saved_mobile_width = 700; // match value in _media-queries.scss

/*---------------------------------------------
 * ScrollReveal
 *--------------------------------------------*/

// Enabled...
if (saved_main.scroll_animations) {

	// ScrollReveal Defaults
	// Default is fade up and in
	window.sr = ScrollReveal({
		duration: 700, // 500 default
		distance: '25px', // 20 default
		scale: 1, // no "small to large", just fade/move
	});

}

/*---------------------------------------------
 * <head>
 *--------------------------------------------*/

// Stop Edge browser from linking phone numbers.
// Later, when possible, style the links instead of removing.
if (/Edge/.test(navigator.userAgent)) {
	jQuery('head').append('<meta name="format-detection" content="telephone=no">');
}

/*---------------------------------------------
 * DOM Loaded
 *--------------------------------------------*/

// DOM is fully loaded
jQuery(document).ready(function ($) {

	/**********************************************
	 * LAYOUT
	 **********************************************/

	/*---------------------------------------------
	 * Match Height
	 *--------------------------------------------*/

	// Set certain elements' height equal per row (short entries, gallery items)
	saved_match_height();

	/*---------------------------------------------
	 * Header Menu
	 *--------------------------------------------*/

	setTimeout(function () { // helps with mobile menu icon position old iOS
		saved_activate_menu();
	}, 50);

	// If header menu wraps to two lines, add body class
	// for special handling of dropdowns
	saved_check_menu_height();
	$(window).on('resize', saved_check_menu_height); // again on resize

	// Prevent items having .saved-menu-button from turning light on hover
	$('.saved-menu-button a').each(function () {
		$(this).addClass('saved-button-not-light');
	});

	/*---------------------------------------------
	 * Header Search
	 *--------------------------------------------*/

	// Open Search
	$('#saved-header-search-open').on('click', function (e) {

		// Stop regular click action
		e.preventDefault();

		// Add body class for "search is open"
		// See media queries for hiding logo on mobile
		$('body').addClass('saved-search-is-open');

		// Focus on search input
		$('#saved-header-search input').focus();

	});

	// Close Search
	$('#saved-header-search-close').on('click', function (e) {

		// Stop regular click action
		e.preventDefault();

		// Remove body class for "search is open"
		jQuery('body').removeClass('saved-search-is-open');

		// Snap mobile menu icon into proper position
		$(window).trigger('resize');

	});

	/*---------------------------------------------
	 * Header Banner
	 *--------------------------------------------*/

	if ($('#saved-banner').length) {

		// Fade banner in after image loads (prevent flash of Main Color in BG)
		$('#saved-banner').waitForImages(function () {

			if (!saved_is_mobile()) { // not on mobile (poor performance)
				$(this).hide().css('visibility', 'visible').fadeIn(300);
			} else {
				$(this).css('visibility', 'visible');
			}

		});

	}

	/*---------------------------------------------
	 * Header Archives (Dropdowns)
	 *--------------------------------------------*/

	if ($('#saved-header-archives').length) {

		// Enable dropdowns
		$('a.saved-header-archive-top-name').each(function () {

			var $link, $dropdown, dropdown_id;

			$link = $(this);
			$dropdown = $link.next('.saved-header-archive-dropdown');
			dropdown_id = $dropdown.attr('id');

			// Move it to before </body> where jQuery Dropdown works best
			$('<div id="saved-dropdow-container" style="position: static"></div>').appendTo('body');
			$dropdown.appendTo('#saved-dropdow-container');

			// Attach dropdown to control
			$link.jqDropdown('attach', '#' + dropdown_id);

		});

		// Align archive nav left when run out of space (if have breadcrumb too)
		if ($('.ctfw-breadcrumbs').length) {
			saved_break_archive_links(); // first load
			$(window).on('resize', saved_break_archive_links);
		}

	}

	/*---------------------------------------------
	 * Footer
	 *--------------------------------------------*/

	// Move icons/notice after menu on mobile (when centered)
	// Using jQuery rather than flexbox for full browser support
	saved_rearrange_footer();
	$(window).on('resize', saved_rearrange_footer);

	// Footer sticky show/hide
	// Show latest events, comments, etc.
	// Hide sticky when scroll to/from footer to prevent covering copyright, etc.
	// Also hide on homepage when not scrolled beneath the first section
	saved_show_footer_sticky();
	$(window).on('scroll', saved_show_footer_sticky);

	// Footer sticky dismiss
	$('#saved-sticky-dismiss a').on('click', function () {

		event.preventDefault();

		// Set cookie
		// Use JS Cookie - enqueued already
		Cookies.set('saved_sticky_dismissed', '1', {
			expires: 1, // hide for today
			path: saved_main.site_path, // work on any page
			secure: saved_main.is_ssl
		});

		// Hide manually
		$('#saved-sticky').fadeOut();

	});

	/*---------------------------------------------
	 * Search Forms (Header, Widget, etc.)
	 *--------------------------------------------*/

	// Trim search query and stop if empty
	// Note: This presently has no effect on mobile menu (see notes above; same cause)
	$('.saved-search-form form').submit(function (event) {

		var s;

		s = $('input[name=s]', this).val().trim();

		if (s.length) { // submit trimmed value
			$('input[name=s]', this).val(s);
		} else { // empty, stop
			event.preventDefault();
		}

	});

	/*---------------------------------------------
	 * Scrolling
	 *--------------------------------------------*/

	// Single.
	if ($('body.single, body.page').length) {

		// Scroll to comments or any other anchor
		var hash = window.location.hash;
		if (hash) {

			// Scroll down
			$.smoothScroll({
				scrollTarget: hash,
				offset: -130, // consider sticky bar
				easing: 'swing',
				speed: 1200,
			});

		}

	}

	// Homepage sections.
	if ($('body.home').length) {

		// Scroll to sections when URL has hash.
		var hash = window.location.hash;
		if (hash) {

			// Scroll down
			$.smoothScroll({
				scrollTarget: hash,
				offset: -90, // consider sticky bar
				easing: 'swing',
				speed: 1200,
			});

		}

		// Scroll to section when link with hash clicked.
		// Example: <a href="#saved-home-section-4">.
		$('a[href*=saved-home-section-]').on('click', function () {

			var href = $(this).attr('href');
			var hash = href.substr(href.indexOf('#'));

			$.smoothScroll({
				scrollTarget: hash,
				offset: -90, // consider sticky bar
				easing: 'swing',
				speed: 1200,
			});

			return false;

		});

	}

	/*---------------------------------------------
	 * Homepage
	 *--------------------------------------------*/

	if ($('.page-template-homepage').length) {

		// Fade in first section, if it is first widget on homepage
		if (!saved_is_mobile()) { // not on mobile (better performance)
			$('.saved-bg-section.saved-first-home-widget').hide().css('visibility', 'visible').fadeIn(400);
		} else {
			$('.saved-bg-section.saved-first-home-widget').hide().css('visibility', 'visible').show();
		}

		// Show video background on non-mobile and image on mobile
		// iOS and most Android don't support video so don't cause MP4 to download
		// Also keeps Vide poster image from flickering in before video plays
		// Note: 1024 is iPad landscape; virtually all laptops are larger: http://ux.stackexchange.com/a/41474
		var show_video = true;
		if (saved_is_mobile() || (typeof window.matchMedia !== 'undefined' && window.matchMedia('only screen and (max-device-width: 1024px)').matches)) { // by resolution just in case (IE9 doesn't support matchMedia)
			show_video = false;
		}

		// Get video file
		var video_url = $('#saved-bg-section-video-vide').data('video-url');

		// Regular Display
		if (show_video && video_url) {

			// Image background is already hidden since video is in use

			// Show Vide video background
			$('#saved-bg-section-video-vide').vide({
				mp4: video_url
			}, {
				posterType: 'none',
				position: 'center center'
			});

			// Fade video in
			$('#saved-bg-section-video-vide').data('vide').getVideoObject().onloadeddata = function () {

				// Make auto-play work in Safari 11
				// https://github.com/vodkabears/Vide/issues/206#issuecomment-332625880
				$('#saved-bg-section-video-vide').data('vide').getVideoObject().play();

				// Fade in
				$(this).parent().hide().fadeIn(600);

			}

		}

		// Mobile Device (or no video file)
		// No video, iOS and most Android don't support in background
		// Show image in background as usual
		else {

			// Hide video color overlay
			$('#saved-bg-section-video-color').hide();

			// Show regular bg img element
			// By default it's hidden when video exists and not on mobile
			$('#saved-bg-section-video-vide').parent().siblings('.saved-bg-section-image').show();

		}

		// Hide single entry in last row to avoid awkward presentation
		// This is particularly handy when going from 3 to 2 columns on mobile
		if ($('.saved-image-section').length) {
			saved_trim_image_section_entries(); // first load
			$(window).on('resize', saved_trim_image_section_entries); // browser resize
		}

	}

	/*---------------------------------------------
	 * Scroll Effects
	 *--------------------------------------------*/

	// NOTE: These elements are hidden in style.css before ScrollReveal kicks in

	if (saved_main.scroll_animations) {

		// Homepage Effects
		if ($('.page-template-homepage').length) {

			// First section

			var next_delay = 100;

			// Title - fade down
			if ($('.saved-bg-section.saved-first-home-widget .saved-bg-section-content h1').length) {

				sr.reveal('.saved-bg-section.saved-first-home-widget .saved-bg-section-content h1', {
					origin: 'top',
					duration: 1200,
					distance: '70px',
					delay: next_delay,
				});

				next_delay = 1000;

			}

			// Text - fade from left
			if ($('.saved-bg-section.saved-first-home-widget .saved-bg-section-text').length) {

				sr.reveal('.saved-bg-section.saved-first-home-widget .saved-bg-section-text', {
					origin: 'left',
					delay: next_delay,
				});

				next_delay = 1500;

			}

			// Fade buttons in place
			sr.reveal('.saved-bg-section.saved-first-home-widget .saved-section-bg-buttons', {
				distance: '0',
				delay: next_delay,
			});

			// Sections with image (not first widget)
			sr.reveal('.saved-bg-section:not(.saved-first-home-widget).saved-section-has-image .saved-bg-section-content');

			// Highlights; Fade up and in
			//sr.reveal( '.saved-home-highlights-section .saved-caption-image-caption', {
			sr.reveal('.saved-home-highlights-section .saved-caption-image');

			// Image Section (New Sermons, Latest Posts, etc.)

			// Fade image up and in
			sr.reveal('.saved-image-section.saved-image-section-has-image .saved-image-section-image');

			// Contents

			// Image on left; slide contents in from right
			sr.reveal('.saved-image-section.saved-image-section-image-left .saved-image-section-content', {
				origin: 'right',
			});

			// Image on right; slide contents in from left
			sr.reveal('.saved-image-section.saved-image-section-image-right .saved-image-section-content', {
				origin: 'left',
			});

			// No image; fade contents up and in
			sr.reveal('.saved-image-section.saved-image-section-no-image .saved-image-section-content');

			// Gallery Section

			sr.reveal('.saved-gallery-section .gallery-item:nth-child(1)', {
				duration: 500,
			});

			sr.reveal('.saved-gallery-section .gallery-item:nth-child(2)', {
			});

			sr.reveal('.saved-gallery-section .gallery-item:nth-child(3)', {
				duration: 1000,
			});

			sr.reveal('.saved-gallery-section .gallery-item:nth-child(4)', {
				duration: 1250,
			});

			sr.reveal('.saved-gallery-section .gallery-item:nth-child(5)', {
				duration: 1500,
			});

		}

		// Subpage Header - fade title down
		sr.reveal('#saved-banner-title', {
			origin: 'top',
			duration: 1200,
			delay: 100,
		});

		// Large Image
		sr.reveal('.saved-entry-full-content img.alignnone, .saved-entry-full-content img.aligncenter');

		// Blockquote
		sr.reveal('.saved-entry-full-content blockquote');

		// Block editor elements.
		var $block_reveal_elements = $('.saved-entry-full-content .wp-block-image:not(.alignleft):not(.alignright), .saved-entry-full-content .wp-block-cover, .wp-block-pullquote');
		if (! /MSIE|Trident/.test(window.navigator.userAgent)) { // IE struggles with this so show normally.
			sr.reveal($block_reveal_elements);
		} else {
			$block_reveal_elements.css('visibility', 'visible');
		}

		// Block Gallery fade in instead of animate, because it has issues oon long galleries.
		$('.saved-entry-full-content .wp-block-gallery').hide().css('visibility', 'visible').fadeIn();

	}

	/*---------------------------------------------
	 * Post Navigation
	 *--------------------------------------------*/

	// Make nav blocks on single posts click anywhere
	$('.saved-nav-block').on('click', function () {

		var url;

		url = $('.saved-nav-block-title', this).prop('href');

		if (url) {
			window.location = url;
		}

	});

	/*---------------------------------------------
	 * Entries
	 *--------------------------------------------*/

	// Regarul narrow template only.
	if ($('.saved-content-width-700').length) {

		// Add class to images in full content big enough to make exceed content width.
		$('img.alignnone, img.aligncenter', $('.saved-entry-full-content > p')).each(function () {

			var img_width;

			img_width = parseFloat($(this).attr('width'));

			if (img_width >= 980) {
				$(this).parents('p').addClass('saved-image-exceed-700-980');
			}

		});

		// Add class to wide Gutenberg elements that are NOT a container (and put them in container).
		$('.wp-block-cover.alignwide, .wp-block-cover.alignfull, .wp-block-gallery.alignwide, .wp-block-gallery.alignfull, .wp-block-columns.alignwide, .wp-block-columns.alignfull, .wp-block-table.alignwide, .wp-block-table.alignfull, .wp-block-tag-cloud.alignwide, .wp-block-tag-cloud.alignfull', $('.saved-entry-full-content')).each(function () {

			// Add container before element.
			var $container = $('<div class="saved-image-exceed-700-980 saved-block-wide-container"></div>');
			$(this).after($container);

			// Move element into container.
			$(this).appendTo($container);

		});

		// Add class to wide Gutenberg elements that ARE in a container.
		$('.wp-block-image.alignwide, .wp-block-image.alignfull, .wp-block-embed.alignwide, .wp-block-embed.alignfull, .wp-block-video.alignwide, .wp-block-video.alignfull, .wp-block-audio.alignwide, .wp-block-audio.alignfull, .wp-block-pullquote.alignwide, .wp-block-pullquote.alignfull, .wp-block-media-text.alignwide, .wp-block-media-text.alignfull', $('.saved-entry-full-content')).each(function () {
			$(this).addClass('saved-image-exceed-700-980');
		});

	}

	/*---------------------------------------------
	 * Sermons
	 *--------------------------------------------*/

	if ($('.single-ctc_sermon').length) {

		// Scroll down to article when "Read" is clicked
		$('#saved-sermon-read-button a').on('click', function (e) {

			e.preventDefault();

			var content_top = $('#saved-sermon-content').position().top;

			$.smoothScroll({
				offset: content_top - 110, // consider sticky bar
				easing: 'swing',
				speed: 1200,
			});

		});

		// Dropdown for download links on Save button
		$('#saved-sermon-download-button a')
			.jqDropdown('attach', '#saved-sermon-download-dropdown');

	}

	/*---------------------------------------------
	 * Single Event
	 *--------------------------------------------*/

	// Single event only
	if ($('.saved-event-full').length) {

		// Recurrence / Excluded Dates tooltip
		$('.saved-map-section-item-note a, .saved-event-recurrence a, .saved-event-excluded-dates a').tooltipster({
			theme: 'saved-tooltipster',
			arrow: false,
			animation: 'fade',
			speed: 250, // fade speed
			trigger: 'custom', // below works on mobile...
			triggerOpen: {
				mouseenter: true,
				touchstart: true
			},
			triggerClose: {
				scroll: true,
				tap: true,
				mouseleave: true,
			}
		}).on('click', function (e) {
			e.preventDefault(); // stop clicks
		});

	}

	/*---------------------------------------------
	 * Events Calendar
	 *--------------------------------------------*/

	// Calendar template only
	if ($('#saved-calendar').length) {

		// Attach dropdowns to controls
		saved_attach_calendar_dropdowns();

		// AJAX-load event calendar when use controls
		// This keeps page from reloading and scrolling to top
		// PJAX updates URL, <title> and browser/back history
		$(document).pjax('.saved-calendar-control, .saved-calendar-dropdown a', '#saved-calendar', {
			fragment: '#saved-calendar', // replace only the calendar
			scrollTo: false, // don't scroll to top after loading
			timeout: 5000, // page reloads after timeout (default 650)
		});

		// Loading indicator
		$(document).on('pjax:send', function () {
			$('.saved-calendar-dropdown-control').jqDropdown('hide'); // hide controls
			$('#saved-calendar-loading').show();
		})
		$(document).on('pjax:complete', function () {
			$('#saved-calendar-loading').hide();
		})

		// After contents replaced
		$(document).on('pjax:success', function () {

			// Re-attach dropdowns to controls
			saved_attach_calendar_dropdowns();

			// Re-activate tooltip hovering
			saved_activate_calendar_hover();

		});

		// Hide dropdowns on back/forward
		$(document).on('pjax:popstate', function (e) {
			if (e.direction) {
				$('.saved-calendar-dropdown-control').jqDropdown('hide');
			}
		});

		// Use Tooltipster to show event hover for each link
		saved_activate_calendar_hover();

		// Handle mobile clicks on linked days
		$(document).on('click', 'a.saved-calendar-table-day-number', function (e) {

			var $day, $events, date_formatted, scroll_offset;

			e.preventDefault();

			// Get day cell
			$day = $(this).parents('td');

			// Show heading for date
			date_formatted = $day.attr('data-date-formatted');
			$('#saved-calendar-list h3:first-of-type').remove();
			$('#saved-calendar-list').prepend('<h3 id="saved-calendar-list-heading">' + date_formatted + '</h3>');
			$('#saved-calendar-list-heading').show();

			// Hide all events in list and show list container
			$('#saved-calendar-list .saved-event-short').hide();
			$('#saved-calendar-list').show();

			// Show all events for this day
			$events = $('.saved-calendar-table-day-events li', $day);
			$events.each(function () {

				var event_id;

				// Get event ID
				event_id = $(this).attr('data-event-id');

				// Show that event in list
				$('#saved-calendar-list .saved-event-short[data-event-id="' + event_id + '"]').show();

			});

			// Scroll down if events are out of view
			// Otherwise user sees no change
			if (!$('#saved-calendar-list-heading').visible()) {

				// Scroll events into bottom of screen
				scroll_offset = 0 - $(window).height() + 150; // negative

				$.smoothScroll({
					scrollTarget: '#saved-calendar-list-heading',
					offset: scroll_offset,
					easing: 'swing',
					speed: 800
				});

			}

		});

	}

	/*---------------------------------------------
	 * Galleries
	 *--------------------------------------------*/

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

	/*---------------------------------------------
	 * Comments
	 *--------------------------------------------*/

	// Scroll to comments on click Comments sticky or comment permalink
	if ($('a.saved-scroll-to-comments').length) {
		$('a.saved-scroll-to-comments, a[href*=comment]').smoothScroll({
			offset: -130, // consider sticky bar
			easing: 'swing',
			speed: 1200,
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
					required: saved_main.comment_name_required !== '' ? true : false // if WP configured to require
				},
				email: {
					required: saved_main.comment_email_required !== '' ? true : false, // if WP configured to require
					email: true // check validity
				},
				url: 'url' // optional but check validity
			},
			messages: { // localized error strings
				author: saved_main.comment_name_error_required,
				email: {
					required: saved_main.comment_email_error_required,
					email: saved_main.comment_email_error_invalid
				},
				url: saved_main.comment_url_error_invalid
			}
		};

		// Comment textarea
		// Use ID instead of name to work with Antispam Bee plugin which duplicates/hides original textarea
		$validate_comment_field = $('#comment').attr('name');
		$validate_params['rules'][$validate_comment_field] = 'required';
		$validate_params['messages'][$validate_comment_field] = saved_main.comment_message_error_required;

		// Validate the form
		$('#commentform').validate($validate_params);

	}

	/*---------------------------------------------
	 * Widgets
	 *--------------------------------------------*/

	// Categories dropdown redirect
	$('.saved-dropdown-taxonomy-redirect').on('change', function () {

		var taxonomy, term_id;

		taxonomy = $(this).prev('input[name=taxonomy]').val();
		term_id = $('option:selected', this).val();

		if (taxonomy && term_id && -1 != term_id) {
			location.href = saved_main.home_url + '/?redirect_taxonomy=' + taxonomy + '&redirect_term_id=' + term_id;
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
			.addClass('saved-button')
			.addClass('saved-button-block')
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
		$(this)
			.addClass('saved-button')
			.removeClass('wp-block-search__button');
	});

	/*---------------------------------------------
	 * List Item Counts
	 *--------------------------------------------*/

	// Modify list item counts
	// This includes widgets and sermon topics, etc. indexes using wp_list_categories()
	// Change (#) into <span class="saved-list-item-count">#</span> so it can be styled
	var $list_items = $('.saved-list li, .saved-sermon-index-list li, .widget_categories li, .widget_ctfw-categories li, .widget_ctfw-archives li, .widget_ctfw-galleries li, .widget_recent_comments li, .widget_archive li, .widget_pages li, .widget_links li, .widget_nav_menu li, .widget_meta li');
	for (var i = 0; i < $list_items.length; i++) {

		$list_items.each(function () {

			var modified_count;

			// Manipulate it
			modified_count = $(this).html().replace(/(<\/a>.*)\(([0-9]+)\)/, '$1 <span class="saved-list-item-count">$2</span>');

			// Replace it
			$(this).html(modified_count);

		});

	}
	$list_items.parent('ul').css('visibility', 'visible');

	/*---------------------------------------------
	 * CSS Classes
	 *--------------------------------------------*/

	// <body> classes for client detection (mobile, browser, etc.) should be done here with JS
	// instead of in body.php so that they work when caching plugins are used.

	// Scrolled down or not

	// On load
	if ($(document).scrollTop() > 0) {

		$('body')
			.removeClass('saved-not-scrolled')
			.addClass('saved-scrolled')
			.addClass('saved-loaded-scrolled');

	} else {

		$('body')
			.addClass('saved-not-scrolled');

	}

	// User scrolled
	$(window).on('scroll', function () {

		if ($(document).scrollTop() > 0) {

			$('body')
				.removeClass('saved-loaded-scrolled')
				.removeClass('saved-not-scrolled')
				.addClass('saved-scrolled');

		} else {

			$('body')
				.removeClass('saved-scrolled')
				.addClass('saved-not-scrolled');

		}

	});

	// Mobile Detection
	// Useful for :hover issue with slider video play icon (some browsers handle it better than others)
	if (saved_is_mobile()) {
		$('body').addClass('saved-is-mobile');
	} else {
		$('body').addClass('saved-not-mobile');
	}

	// iOS Detection
	// Especially useful for re-styling form submit buttons, which iOS takes too much liberty with
	if (navigator.userAgent.match(/iPad|iPod|iPhone|iWatch/)) {
		$('body').addClass('saved-is-ios');
	} else {
		$('body').addClass('saved-not-ios');
	}

	// Showing singe post nav
	if ($('.saved-nav-blocks').length) {
		$('body').addClass('saved-has-nav-blocks');
	} else {
		$('body').addClass('saved-no-nav-blocks');
	}

	// Showing comments section
	if ($('#comments').length) {
		$('body').addClass('saved-has-comments-section');
	} else {
		$('body').addClass('saved-no-comments-section');
	}

	// Showing full entry map
	if ($('.saved-entry-full-map').length) {
		$('body').addClass('saved-has-entry-map');
	} else {
		$('body').addClass('saved-no-entry-map');
	}

	// Add .saved-button to .saved-buttons-list a tags
	// This helps use :not(.saved-button) on content a bottom borders
	$('.saved-buttons-list li a').each(function (index) {
		$(this).addClass('saved-button');
	});

	// Links containing images, so can remove underlined styling
	$('a img').each(function () {
		$(this).parents('a').addClass('saved-link-has-image');
	});

});

/**********************************************
 * FUNCTIONS
 **********************************************/

/*---------------------------------------------
 * Menu Functions
 *--------------------------------------------*/

var $saved_header_menu_raw; // make accessible to saved_activate_menu() later

// Activate Menu Function
// Also used in Customizer admin preview JS
function saved_activate_menu() {

	var $header_menu_raw_list, $header_menu_raw_items;

	// Continue if menu not empty
	if (!jQuery('#saved-header-menu-content').children().length) {
		return;
	}

	// Make copy of menu contents before Superfish modified
	// Original markup works better with MeanMenu (less Supersubs and styling issues)
	if (!jQuery($saved_header_menu_raw).length) { // not done already
		$saved_header_menu_raw = jQuery('<div></div>'); // Create empty div
		$header_menu_raw_list = jQuery('<ul></ul>'); // Create empty list
		$header_menu_raw_items = jQuery('#saved-header-menu-content').html(); // Get menu items
		$header_menu_raw_list = $header_menu_raw_list.html($header_menu_raw_items); // Copy items to empty list
		$saved_header_menu_raw = $saved_header_menu_raw.html($header_menu_raw_list); // Copy list to div
	}

	// Regular Menu (Superfish)
	jQuery('#saved-header-menu-content').supersubs({ // Superfish dropdowns
		minWidth: 13.5,	// minimum width of sub-menus in em units
		maxWidth: 13.5,	// maximum width of sub-menus in em units
		extraWidth: 1	// extra width can ensure lines don't sometimes turn over due to slight rounding differences and font-family
	}).superfish({
		disableHI: true,
		delay: 0,
		animation: {
			opacity: 'show',
			height: 'show',
		},
		animationOut: {
			opacity: 'hide',
			height: 'hide',
		},
		speed: 250,
		speedOut: 0,
		onInit: function () {

			// Responsive Menu (MeanMenu) for small screens
			// Replaces regular menu with responsive controls
			// Init after Superfish done because Supersubs needs menu visible for calculations
			jQuery($saved_header_menu_raw).meanmenu({
				meanMenuContainer: '#saved-header-mobile-menu',
				meanScreenWidth: saved_mobile_width, // use CSS media query to hide #saved-header-menu-content at same size
				meanRevealPosition: 'right',
				meanRemoveAttrs: true, // remove any Superfish classes, duplicate item ID's, etc.
				meanMenuClose: '<i class="' + saved_main.mobile_menu_close + '"></i>',
				meanExpand: '+',
				meanContract: '-',
				//removeElements: '#saved-header-menu-inner' // toggle visibility of regular
			});

			// Insert search into mobile menu
			saved_activate_mobile_menu();

			// Insert arrow icons for second level
			jQuery('ul .sf-with-ul', this).each(function () {
				jQuery(this).after('<span class="saved-menu-arrow mdi mdi-chevron-right"></span>');
			});

		},
		onBeforeShow: function () {

			var $link, $dropdown, $dropdown_width, $offset;

			// Make dropdowns on right open to the left if will go off screen
			// This considers that the links may have wrapped and dropdowns may be mobile-size

			// Detect if is first-level dropdown and if not return
			if (jQuery(this, '#saved-header-menu-content').parents('li.menu-item').length != 1) {
				return;
			}

			// Top-level link hovered on
			$link = jQuery(this).parents('#saved-header-menu-content > li.menu-item');

			// First-level dropdown
			$dropdown = jQuery('> ul', $link);

			// First-level dropdown width
			$dropdown_width = $dropdown.outerWidth();
			$dropdown_width_adjusted = $dropdown_width - 20; // compensate for left alignment

			// Remove classes first in case don't need anymore
			$link.removeClass('jq-dropdown-align-right jq-dropdown-open-left');

			// Get offset between left side of link and right side of window
			$offset = jQuery(window).width() - $link.offset().left;

			// Is it within one dropdown length of window's right edge?
			// Add .jq-dropdown-align-right to make first-level dropdown not go off screen
			if ($offset < $dropdown_width_adjusted) {
				$link.addClass('jq-dropdown-align-right');
			}

			// Is it within two dropdown lengths of window's right edge?
			// Add .jq-dropdown-open-left to open second-level dropdowns left: https://github.com/joeldbirch/superfish/issues/98
			if ($offset < ($dropdown_width_adjusted * 2)) {
				$link.addClass('jq-dropdown-open-left');
			}

		},

	});

}

// Insert search into mobile menu
function saved_activate_mobile_menu() {

	var $logo, move_up;

	if (jQuery('.mean-container .mean-bar').length) {

		// Move mobile search container into bottom of mobile menu
		if (jQuery('#saved-header-search').length && !jQuery('#saved-header-search-mobile').length) {
			jQuery('.mean-nav > ul').append('<li id="saved-header-search-mobile" role="search">' + jQuery('#saved-header-search .saved-search-form').html() + '</li>');
		}

	}

}

// If header menu wraps to two lines, add body class
// for special handling of dropdowns
function saved_check_menu_height() {

	var header_menu_height = jQuery('#saved-header-menu-content').height();

	if (header_menu_height > 40) {
		jQuery('body').addClass('saved-header-menu-wrapped');
	} else {
		jQuery('body').removeClass('saved-header-menu-wrapped');
	}

}

// If breadcrumbs and archive links touch, move archive links to new line - left-aligned
function saved_break_archive_links() {

	// Container width
	var $container = jQuery('#saved-header-bottom-inner');
	var container_width = $container.width();

	// Breadcrumb width
	var $breadcrumbs = jQuery('.ctfw-breadcrumbs');
	var breadcrumbs_width = $breadcrumbs.width();

	// Archive links width
	var $archives = jQuery('#saved-header-archives');
	var archives_width = $archives.width();

	// Breadcrumb and archive links touching?
	// ie. Their combined width equal to or greater than container
	$container.removeClass('saved-header-bottom-break');
	if ((breadcrumbs_width + archives_width + 25) >= container_width) { // plus 25 padding
		$container.addClass('saved-header-bottom-break');
	}

}

/*---------------------------------------------
 * Footer
 *--------------------------------------------*/

// Move icons/notice after menu on mobile (when centered)
// Using jQuery rather than flexbox for full browser support
function saved_rearrange_footer() {

	var viewport_width, $icons_notice, $menu, icons_notice_index;

	$icons_notice = jQuery('#saved-footer-icons-notice');
	$menu = jQuery('#saved-footer-menu');

	// Have both elements
	if ($icons_notice.length && $menu.length) {

		viewport_width = jQuery(window).width();
		icons_notice_position = jQuery($icons_notice).index() + 1;

		if (viewport_width <= 980) { // change width threshold in media-queries.scss too

			if (1 == icons_notice_position) {
				$menu.after($icons_notice);
			}

		} else {

			if (2 == icons_notice_position) {
				$icons_notice.after($menu);
			}

		}

	}

}

// Show latest events, comments, etc.
// Hide sticky when scroll to/from footer to prevent covering copyright, etc.
function saved_show_footer_sticky() {

	var scroll_bottom, top_of_footer, show;

	// Don't show if dismissed already
	if (Cookies.get('saved_sticky_dismissed')) {
		return;
	}

	// Default is show
	show = true;

	// Hide on homepage when not scrolled
	if (jQuery('.page-template-homepage').length && 0 == jQuery(document).scrollTop()) {
		show = false;
	}

	// Hide when below top of last footer element (widgets, map or bottom bar)
	scroll_bottom = jQuery(window).scrollTop() + jQuery(window).height();
	top_of_footer = jQuery(document).height() - jQuery('#saved-footer > *:last-child').height();
	if (scroll_bottom > top_of_footer) {
		show = false;
	}

	// Do show/hide
	if (show) {
		jQuery('#saved-sticky').show();
	} else {
		jQuery('#saved-sticky').hide();
	}

}

/*---------------------------------------------
 * Fonts
 *--------------------------------------------*/

// Change <body> helper font/setting class
// Used by Theme Customizer (and front-end demo customizer)
function saved_update_body_font_class(setting, font) {

	var setting_slug, font_slug, body_class;

	// Prepare strings
	setting_slug = setting.replace(/_/g, '-');
	font_slug = font.toLowerCase().replace(/\s/g, '-'); // spaces to -
	body_class = 'saved-' + setting_slug + '-' + font_slug;

	// Remove old class
	jQuery('body').removeClass(function (i, css_class) { // helpful info: http://bit.ly/1f7KH3f
		return (css_class.match(new RegExp('\\b\\S+-' + setting_slug + '-\\S+', 'g')) || []).join(' ');
	});

	// Add new class
	jQuery('body').addClass(body_class);

}

/*---------------------------------------------
 * Map Section
 *--------------------------------------------*/

// Position Google Map on homepage and footer
// This moves the marker to be roughly centered in right 50%
// Also run on resize to keep things in proper place
function saved_position_map_section() {

	// Delay improves resize accuracy
	setTimeout(function () {

		// Elements and data always needed
		var $map_element = jQuery('#saved-map-section-canvas');
		var $gmap = $map_element.data('ctfw-map');
		var $marker = jQuery('#saved-map-section-marker span');
		var latlng = $map_element.data('ctfw-map-latlng');

		// Reset location to center
		$gmap.setCenter(latlng);

		// Move marker only if viewport is larger than content container
		// This keeps it centered fine on mobile
		if (jQuery(window).width() > 1170) {

			// Elements and data for moving leftward
			var $content_container = jQuery('#saved-map-section-content-container');
			var $map_container = jQuery('#saved-map-section-map');
			var content_container_width = $content_container.width();

			// Calculations
			var half_container_width = content_container_width / 2; // centered large 1170-ish
			var map_width = $map_container.width(); // map canvas
			var current_map_center = map_width / 2;
			var new_map_center = half_container_width / 2; // half of content container is for map (other for content)
			var pan_x = current_map_center - new_map_center; // distance to plan map/marker leftward, to new center

			// Move map and marker leftward
			$gmap.panBy(pan_x, 0);
			jQuery($marker).css('left', '-' + pan_x + 'px');

		}

		// Undo the marker offset in case resizing down to mobile
		else {
			jQuery($marker).css('left', '0');
		}

	}, 10);

}

/*---------------------------------------------
 * Match Height
 *--------------------------------------------*/

// Match height wherever needed
// Also used by Customizer after font change since that can change height
function saved_match_height() {

	// Make short entry boxes have equal height per row
	if (jQuery('.saved-loop-entries').length) {
		jQuery('.saved-loop-entries .saved-entry-short').matchHeight();
	}

	// Give each gallery item same height to avoid gaps / awkward wrapping
	if (jQuery('.gallery-icon img').length) {
		jQuery('.gallery-icon img').matchHeight();
	}

	// Same for gallery index (caption images)
	if (jQuery('.saved-galleries-list .saved-caption-image').length) {
		jQuery('.saved-galleries-list .saved-caption-image').matchHeight();
	}

}

/*---------------------------------------------
 * Homepage
 *--------------------------------------------*/

// Hide single entry in last row to avoid awkward presentation
// This is particularly handy when going from 3 to 2 columns on mobile
// Helpful info: http://bit.ly/1dmuqFm
function saved_trim_image_section_entries() {

	jQuery('.saved-image-section .saved-loop-entries').each(function (index, entries_container) {

		var $last_stored, $entries, entries_per_row, entries_last_row;

		// First re-show last element in case sizing back up
		// Note: Note, using detatch/append instead of hide() so styling for margin
		last_stored_key = 'saved-last-' + index;
		$last_stored = jQuery(entries_container).data(last_stored_key);
		if ($last_stored) {
			$last_stored.appendTo(entries_container);
		}

		// Entry elements
		$entries = jQuery('.saved-entry-short', entries_container);

		// Trim only if have more than 1 item, so don't cut if off and show nothing
		if ($entries.length < 2) {
			return false;
		}

		// Determine entries per row
		entries_per_row = 0;
		$entries.each(function () {

			var $entry = jQuery(this);

			if (!$entry.prev().length || !($entry.position().top != $entry.prev().position().top)) {
				entries_per_row++;
			} else {
				return false;
			}

		});

		// Determine entries in last row
		entries_last_row = $entries.length % entries_per_row;
		entries_last_row = !entries_last_row ? entries_per_row : entries_last_row;

		// Hide last item if last row only has one
		if (1 == entries_last_row) {

			// Store last element before hiding
			jQuery(entries_container).data(last_stored_key, $entries.last());

			// Remove last element (not hiding to preserve bottom margin)
			$entries.last().detach();

		}

	});

}

/*---------------------------------------------
 * Event Calendar
 *--------------------------------------------*/

// Attach calendar dropdowns to controls
// Used on load and after PJAX replaces content
function saved_attach_calendar_dropdowns() {

	// Remove it from before </body> if already exists (old before PJAX)
	jQuery('body > #saved-calendar-month-dropdown').remove();
	jQuery('body > #saved-calendar-category-dropdown').remove();

	// Move it from calendar container to before </body>
	// jQuery Dropdown works best with it there
	// But need it in main calendar container for PJAX to get new contents of dropdowns
	jQuery('#saved-calendar-month-dropdown').appendTo('body');
	jQuery('#saved-calendar-category-dropdown').appendTo('body');

	// Re-attach dropdown to control
	jQuery('#saved-calendar-month-control').jqDropdown('attach', '#saved-calendar-month-dropdown');
	jQuery('#saved-calendar-category-control').jqDropdown('attach', '#saved-calendar-category-dropdown');

}

// Use Tooltipster to show calendar's event hover for each link
function saved_activate_calendar_hover() {

	// Use Tooltipster to show event hover for each link
	jQuery('#saved-calendar .saved-event-short').each(function () {

		var event_id;

		// Get ID
		event_id = jQuery(this).attr('data-event-id');

		// Activate tooltips on links having that ID
		if (event_id) {

			jQuery('.saved-calendar-table-day-events a[data-event-id="' + event_id + '"]').tooltipster({
				theme: 'saved-tooltipster-calendar',
				content: jQuery(this),
				contentCloning: true,
				functionInit: function (origin, content) {

					var date_formatted_abbreviated;

					// Get localized date from calendar
					date_formatted_abbreviated = jQuery(origin).parents('td').attr('data-date-formatted-abbreviated');

					// Add date to the tooltip
					jQuery('.saved-entry-short-date', content).html(date_formatted_abbreviated);

					return content;

				},
				minWidth: 260,
				maxWidth: 360,
				touchDevices: false, // no hovers on touch (including w/mouse; otherwise pure touch opens + goes)
				interactive: true, // let them click on tooltip
				arrow: false,
				delay: 50,
				animation: 'fade',
				speed: 250, // fade speed
				onlyOne: true, // immediately close other tooltips when opening
				zIndex: 99997, // under sticky menu (99998) and admin bar (99999)
			});

		}

	});

}

/*---------------------------------------------
 * Detection
 *--------------------------------------------*/

// Is device mobile?
// The regex below is based on wp_is_mobile() -- good enough for most
// "Mobile" will handle iOS devices and many others
function saved_is_mobile() {
	return navigator.userAgent.match(/Mobile|Android|Silk\/|Kindle|BlackBerry|Opera Mini|Opera Mobi/)
}
