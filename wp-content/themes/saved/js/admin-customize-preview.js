/**
 * Theme Customizer Live Preview
 */

jQuery( document ).ready( function( $ ) {

	/***************************************
	 * COLORS
	 ***************************************/

	// Main Color
	wp.customize( saved_customize_preview.option_id + '[main_color]', function( value ) {

		value.bind( function( to ) {

			var background_selectors, border_selectors, text_selectors, background_rgba_selectors, border_rgba_selectors, rgb, rgba;

			// Hex
			background_selectors = saved_customize_preview[ 'main_color_selectors' ];
			border_selectors = saved_customize_preview[ 'main_color_border_selectors' ];
			text_selectors = saved_customize_preview[ 'main_color_text_selectors' ];

				// Appending <style> to head with !important produces better results than $element.css()
				$( 'head' ).append( '<style type="text/css">' + background_selectors + ' { background-color: ' + to + ' !important; }</style>' );
				$( 'head' ).append( '<style type="text/css">' + border_selectors + ' { border-color: ' + to + ' !important; }</style>' );
				$( 'head' ).append( '<style type="text/css">' + text_selectors + ' { color: ' + to + ' !important; }</style>' );

			// RGB
			background_rgba_selectors = saved_customize_preview[ 'main_color_rgba_selectors' ];
			border_rgba_selectors = saved_customize_preview[ 'main_color_rgba_border_selectors' ];

				// Convert hex color to RGB
				rgb = colorconv.HEX2RGB( to );

				// Have RGB
				if ( rgb.length ) {

					// Form rgba()
					rgba = 'rgba(' + rgb.join(', ') + ', ' + saved_customize_preview.main_color_rgb_opacity + ')';

					// Appending <style> to head with !important produces better results than $element.css()
					$( 'head' ).append( '<style type="text/css">' + background_rgba_selectors + ' { background-color: ' + rgba + ' !important; }</style>' );
					$( 'head' ).append( '<style type="text/css">' + border_rgba_selectors + ' { border-color: ' + rgba + ' !important; }</style>' );

				}

		} );

	} );

	// Accent Color
	wp.customize( saved_customize_preview.option_id + '[accent_color]', function( value ) {

		value.bind( function( to ) {

			var text_selectors, border_selectors, border_left_selectors, bg_selectors;

			text_selectors = saved_customize_preview[ 'accent_color_selectors' ];
			text_important_selectors = saved_customize_preview[ 'accent_color_important_selectors' ];
			border_selectors = saved_customize_preview[ 'accent_color_border_selectors' ];
			border_left_selectors = saved_customize_preview[ 'accent_color_border_left_selectors' ];
			bg_selectors = saved_customize_preview[ 'accent_color_bg_selectors' ];

			// Using second method to prevent all link elements from being color (menu items, logo, etc.)
			$( 'head' ).append( '<style type="text/css">' + text_selectors + ' { color: ' + to + '; }</style>' );
			$( 'head' ).append( '<style type="text/css">' + text_important_selectors + ' { color: ' + to + ' !important; }</style>' );
			$( 'head' ).append( '<style type="text/css">' + border_selectors + ' { border-color: ' + to + '; }</style>' );
			$( 'head' ).append( '<style type="text/css">' + border_left_selectors + ' { border-left-color: ' + to + '; }</style>' );
			$( 'head' ).append( '<style type="text/css">' + bg_selectors + ' { background-color: ' + to + '; }</style>' );

		} );

	} );

	/***************************************
	 * FONTS (GOOGLE FONTS)
	 ***************************************/

	// Change Fonts ( Menu, Heading, Body )
	$.each( [ 'logo_font', 'nav_font', 'heading_font', 'body_font' ], function( index, setting ) {

		wp.customize( saved_customize_preview.option_id + '[' + setting + ']', function( value ) {

			value.bind( function( to ) {

				var selectors, font;

				font = to;

				// Change font
				selectors = saved_customize_preview[setting + '_selectors'];
				saved_customize_preview_font( selectors, font );

				// Change <body> class helper (tells which font used for which set of elements)
				saved_update_body_font_class( setting, font ); // main.js

			} );

		} );

	} );

	/***************************************
	 * LOGO
	 ***************************************/

	// Logo Text Size
	wp.customize( saved_customize_preview.option_id + '[logo_text_size]', function( value ) {

		value.bind( function( to ) {

			$( '#saved-logo-text' )
				.removeClass() // remove all classes
				.addClass( 'saved-logo-text-' + to );

		} );

	} );

	/***************************************
	 * MENU
	 ***************************************/

	// Re-activate dropdowns after Menu Customizer does "partial refresh" / "fast refresh"
	// https://make.wordpress.org/core/tag/menu-customizer/
	$( document ).on( 'customize-preview-menu-refreshed', function( e, params ) {

		if ( 'header' === params.wpNavMenuArgs.theme_location ) {
			saved_activate_menu();
		}

	} );

} );

/***************************************
 * FUNCTIONS
 ***************************************/

/**
 * Apply Font Change
 */
function saved_customize_preview_font( selectors, font ) {

	var family, styles, subsets, families;

	if ( selectors && font ) {

		// Prepare data
		family = font.replace( /\s/g, '+' ); // spaces to +
		styles = saved_customize_preview.fonts[font].sizes;
		subsets = window.parent.jQuery( 'input[data-customize-setting-link="' + saved_customize_preview.option_id + '[font_subsets]"]' ).val().replace( /\s/g, '' ); // remove spaces
		families = [family + ':' + styles + ':' + subsets];

		// Load font
		WebFont.load( {
			google: {
				families: families
			},
			active: function() {

				// Apply font
				//jQuery( selectors ).css( 'font-family', "'" + font + "'" );

				// Appending <style> to head with !important produces better results than $element.css()
				jQuery( 'head' ).append( '<style type="text/css">' + selectors + ' { font-family: ' + font + ' !important; }</style>' );

				// Reactivate menu ( sizing )
				saved_activate_menu();

				// Re-adjust MatchHeight since font can change it (short entries, gallery items)
				saved_match_height();

			}
		} );

	}

}
