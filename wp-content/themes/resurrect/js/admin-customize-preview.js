/**
 * Theme Customizer Live Preview
 */

jQuery( document ).ready( function( $ ) {

	/***************************************
	 * BACKGROUND IMAGE
	 ***************************************/

	 // Initial Load
	resurrect_customize_update_background_image();

	// Background Image Type
	wp.customize( resurrect_customize_preview.option_id + '[background_image_type]', function( value ) {

		value.bind( function( to ) {
			resurrect_customize_update_background_image();
		} );

	} );

	// Background Image (Upload)
	// (this also fires when image removed)
	wp.customize( 'background_image', function( value ) {

		value.bind( function( to ) {
			resurrect_customize_update_background_image();
		} );

	} );

	// Background Image (Preset)
	wp.customize( resurrect_customize_preview.option_id + '[background_image_preset]', function( value ) {

		value.bind( function( to ) {
			resurrect_customize_update_background_image();
		} );

	} );

	// Fonts ( Menu, Heading, Body )
	$.each( ['logo_font', 'menu_font', 'heading_font', 'body_font'], function( index, setting ) {

		wp.customize( resurrect_customize_preview.option_id + '[' + setting + ']', function( value ) {

			value.bind( function( to ) {

				var selectors, font;

				font = to;

				// Change font
				selectors = resurrect_customize_preview[setting + '_selectors'];
				resurrect_customize_preview_font( selectors, font );

				// Change <body> class helper (tells which font used for which set of elements)
				resurrect_update_body_font_class( setting, font ); // main.js

			} );

		} );

	} );

	/***************************************
	 * HEADER
	 ***************************************/

	// Move Logo
	wp.customize( resurrect_customize_preview.option_id + '[logo_offset_x]', function( value ) {

		value.bind( function( to ) {
			$( '#resurrect-logo-image' ).css( 'left', to + 'px' );
		} );

	} );

	// Tagline
	wp.customize( 'blogdescription', function( value ) {

		value.bind( function( to ) {
			$( '.resurrect-tagline' ).html( to ); // below logo and right side
		} );

	} );

	// Move Tagline ( under logo )
	wp.customize( resurrect_customize_preview.option_id + '[tagline_offset_x]', function( value ) {

		value.bind( function( to ) {
			$( '#resurrect-logo-tagline' ).css( 'left', to + 'px' );
		} );

	} );

	/***************************************
	 * MENU
	 ***************************************/

	// Re-activate dropdowns after Menu Customizer does "partial refresh" / "fast refresh"
	// https://make.wordpress.org/core/tag/menu-customizer/
	$( document ).on( 'customize-preview-menu-refreshed', function( e, params ) {
		if ( 'header' === params.wpNavMenuArgs.theme_location ) {
			resurrect_activate_menu();
		}
	} );

} );

/***************************************
 * FUNCTIONS
 ***************************************/

/**
 * Update background image based on settings
 */
function resurrect_customize_update_background_image() {

	var image_type, background_attachment, upload_url, preset_url, url;

	// Data
	image_type = window.parent.jQuery( '[data-customize-setting-link="' + resurrect_customize_preview.option_id + '[background_image_type]"]:radio:checked' ).val();
	background_attachment = window.parent.jQuery( '[data-customize-setting-link=background_attachment]' ).val();
	background_size = window.parent.jQuery( '[data-customize-setting-link=background_size]' ).val();

	// URLs
	upload_url = parent.wp.customize.instance('background_image').get();
	preset_url = window.parent.jQuery( 'input[data-customize-setting-link="resurrect_customizations[background_image_preset]"]' ).val();

	// URL based on Preset or Upload
	if ( 'preset' == image_type ) {
		url = preset_url;
	} else if ( 'upload' == image_type ) {
		url = upload_url;
	}

	// Correct background attachment on first load, before Customizer is saved
	// For some reason default background attachment doesn't apply until save (fine on frontend)
	if ( background_attachment != jQuery( 'body' ).css('background-attachment') ) {
		jQuery( 'head' ).append( '<style>body { background-attachment: ' + background_attachment + '; }</style>' );
	}

	// Size has had issue taking effect too
	if ( background_size != jQuery( 'body' ).css('background-size') ) {
		jQuery( 'head' ).append( '<style>body { background-size: ' + background_size + '; }</style>' );
	}

	// Clear out any old background image in any case
	jQuery( 'body' ).css( 'background-image', 'none' );

	// Change background (upload or preset)
	if ( url ) {

		// Remove forcing of certain BG color for image in body.php
		// Otherwise when remove image in customizer, color change will not show
		jQuery( 'body' ).removeClass ( function ( index, css ) {
	 		return ( css.match ( /\bresurrect-background-image-file-\S+/g ) || [] ).join(' ' );
		});

		// Change CSS background image
		// Unless type is upload but image URL is a preset (otherwise previously saved Preset sticks when choosing Upload)
		if ( ! ( 'upload' == image_type && url.indexOf( resurrect_customize_preview.bg_dir ) !== -1 ) ) {
			jQuery( 'body' ).css( 'background-image', 'url( ' + url + ' )' );
		}

	}

}

/**
 * Apply Font Change
 */
function resurrect_customize_preview_font( selectors, font ) {

	var family, styles, subsets, families;

	if ( selectors && font ) {

		// Prepare data
		family = font.replace( /\s/g, '+' ); // spaces to +
		styles = resurrect_customize_preview.fonts[font].sizes;
		subsets = window.parent.jQuery( 'input[data-customize-setting-link="' + resurrect_customize_preview.option_id + '[font_subsets]"]' ).val().replace( /\s/g, '' ); // remove spaces
		families = [family + ':' + styles + ':' + subsets];

		// Load font
		WebFont.load( {
			google: {
				families: families
			},
			active: function() {

				// Apply font
				jQuery( selectors ).css( 'font-family', "'" + font + "'" );

				// Reactivate menu ( sizing )
				resurrect_activate_menu();

			}
		} );

	}

}
