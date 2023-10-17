<?php
/**
 * <head> Functions
 *
 * Also see enqueue-styles.php and enqueue-scripts.php.
 *
 * @package    Resurrect
 * @subpackage Functions
 * @copyright  Copyright (c) 2013 - 2020, ChurchThemes.com
 * @link       https://churchthemes.com/themes/resurrect
 * @license    GPLv2 or later
 * @since      1.0
 */

// No direct access.
if (! defined( 'ABSPATH' )) {
	exit;
}

/*******************************************
 * CUSTOM STYLES
 *******************************************/

/**
 * Insert custom styles (colors, background, fonts) from Customizer
 *
 * @since 1.0
 */
function resurrect_head_styles() {

	// Fonts
	$logo_font_stack = ctfw_font_stack( ctfw_customization( 'logo_font' ), ctfw_google_fonts( 'logo_font' ) );
	$heading_font_stack = ctfw_font_stack( ctfw_customization( 'heading_font' ), ctfw_google_fonts( 'heading_font' ) );
	$menu_font_stack = ctfw_font_stack( ctfw_customization( 'menu_font' ), ctfw_google_fonts( 'menu_font' ) );
	$body_font_stack = ctfw_font_stack( ctfw_customization( 'body_font' ), ctfw_google_fonts( 'body_font' ) );

	// Logo/Tagline Offsets
	$logo_offset_x = (int) ctfw_customization( 'logo_offset_x' );
	$tagline_offset_x = (int)  ctfw_customization( 'tagline_offset_x' );

?>
<style type="text/css">
<?php echo resurrect_style_selectors( 'logo_font' ); ?> {
	font-family: <?php echo $logo_font_stack; ?>;
}

<?php echo resurrect_style_selectors( 'body_font' ); ?> {
	font-family: <?php echo $body_font_stack; ?>;
}

<?php echo resurrect_style_selectors( 'menu_font' ); ?> {
	font-family: <?php echo $menu_font_stack; ?>;
}

<?php echo resurrect_style_selectors( 'heading_font' ); ?> {
	font-family: <?php echo $heading_font_stack; ?>;
}

<?php if ($logo_offset_x) : ?>
#resurrect-logo-image {
	left: <?php echo $logo_offset_x; ?>px;
}
<?php endif; ?>

<?php if ($tagline_offset_x) : ?>
#resurrect-logo-tagline {
	left: <?php echo $tagline_offset_x; ?>px;
}
<?php endif; ?>
</style>
<?php

}

add_action( 'wp_head', 'resurrect_head_styles' ); // add style to <head>

/**
 * Produce list of selectors for fonts, colors, etc.
 *
 * @since 1.0
 * @param string $group Group of selectors to return
 * @return string CSS selector list
 */
function resurrect_style_selectors( $group ) {

	$selectors = '';

	// Build elements array
	$groups = array(

		// Heading Font
		'logo_font' => array(
			'#resurrect-logo-text'
		),

		// Menu Font
		'menu_font' => array(
			'#resurrect-header-menu-links > li > a .ctfw-header-menu-link-title',
			'#resurrect-footer-menu-links'
		),

		// Heading Font
		'heading_font' => array(
			'#resurrect-intro-heading',
			'.resurrect-main-title',
			'.resurrect-entry-content h1:not(.resurrect-calendar-list-entry-title)',
			'.resurrect-entry-content h2',
			'.resurrect-entry-content h3',
			'.resurrect-entry-content h4',
			'.resurrect-entry-content h5',
			'.resurrect-entry-content h6',
			'.mce-content-body h1',
			'.mce-content-body h2',
			'.mce-content-body h3',
			'.mce-content-body h4',
			'.mce-content-body h5',
			'.mce-content-body h6',
			'.resurrect-author-box h1',
			'.resurrect-person header h1',
			'.resurrect-location header h1',
			'.resurrect-entry-short h1',
			'#reply-title',
			'#resurrect-comments-title',
			'.flex-title',
			'.resurrect-caption-image-title',
			'#resurrect-banner h1',
			'h1.resurrect-widget-title',
			'.resurrect-header-right-item-date',
			'.resurrect-calendar-table-header-row',
			'.has-drop-cap:not(:focus):first-letter',
		),

		// Body Font
		'body_font' => array(

			'body',
			'input',
			'textarea',
			'select',
			'.sf-menu li li a', /* dropdowns */
			'.flex-description',
			'#cancel-comment-reply-link',
			'.resurrect-accordion-section-title',

			// buttons
			'a.resurrect-button',
			'a.comment-reply-link',
			'a.comment-edit-link',
			'a.post-edit-link',
			'.resurrect-nav-left-right a',
			'input[type=submit]',
			'.wp-block-file .wp-block-file__button',

			'pre.wp-block-verse',

		)

	);

	// Allow filtering
	$groups = apply_filters( 'resurrect_style_selectors', $groups );

	// Build list
	if (! empty( $groups[$group] )) {
		$selectors = implode( ', ', $groups[$group] );
	}

	return $selectors;

}

/*******************************************
 * BLOCK EDITOR CUSTOM STYLES
 *******************************************/

/**
 * Block Editor <head> Styles
 *
 * Output a version of resurrect_head_styles() tailored to Gutenberg.
 *
 * This is called by ctfw_editor_styles() when specified in add_theme_support( 'ctfw-editor-styles' ) css_block_function.
 *
 * @since 2.4
 */
function resurrect_block_editor_head_styles() {

	// Fonts.
	$heading_font_stack = ctfw_font_stack( ctfw_customization( 'heading_font' ), ctfw_google_fonts( 'heading_font' ) );
	$body_font_stack = ctfw_font_stack( ctfw_customization( 'body_font' ), ctfw_google_fonts( 'body_font' ) );

?>
<style type="text/css">

<?php echo resurrect_block_editor_style_selectors( 'heading_font' ); ?> {
	font-family: <?php echo $heading_font_stack; ?> !important;
}

<?php echo resurrect_block_editor_style_selectors( 'body_font' ); ?> {
	font-family: <?php echo $body_font_stack; ?> !important;
}

</style>
<?php

}

/**
 * Produce list of selectors for fonts, colors, etc. for Block Editor.
 *
 * This is used by resurrect_block_editor_head_styles() for Gutenberg only.
 *
 * @since 2.4
 * @param string $group Group of selectors to return
 * @return string CSS selector list
 */
function resurrect_block_editor_style_selectors( $group ) {

	$selectors = '';

	// Build elements array
	$groups = array(

		// Heading Font.
		'heading_font' => array(

			// Post Title.
			'.editor-post-title__input',

			// Headings.
			'.edit-post-visual-editor h1.block-editor-rich-text__editable',
			'.edit-post-visual-editor h2.block-editor-rich-text__editable',
			'.edit-post-visual-editor h3.block-editor-rich-text__editable',
			'.edit-post-visual-editor h4.block-editor-rich-text__editable',
			'.edit-post-visual-editor h5.block-editor-rich-text__editable',
			'.edit-post-visual-editor h6.block-editor-rich-text__editable',

			// Classic Block.
			'.wp-block-freeform.block-library-rich-text__tinymce h1',
			'.wp-block-freeform.block-library-rich-text__tinymce h2',
			'.wp-block-freeform.block-library-rich-text__tinymce h3',
			'.wp-block-freeform.block-library-rich-text__tinymce h4',
			'.wp-block-freeform.block-library-rich-text__tinymce h5',
			'.wp-block-freeform.block-library-rich-text__tinymce h6',

			// Dropcap.
			'.edit-post-visual-editor .has-drop-cap:not(:focus):first-letter',

		),

		// Body Font.
		'body_font' => array(

			'.edit-post-visual-editor',
			'.edit-post-visual-editor p',
			'.edit-post-visual-editor .block-editor-default-block-appender input[type=text].block-editor-default-block-appender__content', // body placeholder.
			'.edit-post-visual-editor .wp-block-verse',
			'.edit-post-visual-editor .wp-block-quote .wp-block-quote__citation.block-editor-rich-text__editable',
			'.edit-post-visual-editor .block-library-list .block-editor-rich-text__editable',
			'.wp-block-freeform.block-library-rich-text__tinymce',
			'.edit-post-visual-editor .wp-block-freeform ol', // Classic Editor
			'.edit-post-visual-editor .wp-block-freeform ul', // Classic Editor
			'.edit-post-visual-editor .editor-block-list__block-edit',
			'.edit-post-visual-editor a.resurrect-button',
			'pre.wp-block-verse',
			'.edit-post-visual-editor figcaption',
			'.edit-post-visual-editor .wp-block-pullquote__citation.block-editor-rich-text__editable',
			'.edit-post-visual-editor .wp-block-pullquote cite',
			'.wp-block-file__button',
			'.wp-block-file__textlink .block-editor-rich-text__editable',
			'.wp-block-file__content-wrapper a.block-editor-rich-text__editable',

			'.wp-block-latest-posts',
			'.wp-block-categories',
			'.wp-block-archives',
			'.wp-block-latest-comments',
			'.wp-block-rss',
			'.wp-block-calendar',
			'.wp-block-tag-cloud',
			'.wp-block-page-list',

		),

	);

	// Allow filtering.
	$groups = apply_filters( 'resurrect_block_editor_style_selectors', $groups );

	// Build list.
	if (! empty( $groups[ $group ] )) {
		$selectors = implode( ', ', $groups[ $group ] );
	}

	return $selectors;

}

/******************************************
 * FORCE "FULL SITE"
 ******************************************/

/**
 * "Full Site" JavaScript
 *
 * Done directly in header for immediately result with caching and mobile.
 * When done with ready or in external JS, there is a delay.
 *
 * This keeps "Full Site" from showing for a second before responsive view loads.
 *
 * Note: All "Full Site" changes are client-side to work with caching plugins.
 *
 * @since 1.0
 */
function resurrect_head_responsive_js() {

?>
<script type="text/javascript">
jQuery( window ).load( function() {
	if ( jQuery.cookie( 'resurrect_responsive_off' ) ) {

		// Add helper class without delay
		jQuery( 'html' ).addClass( 'resurrect-responsive-off' );

		// Disable responsive.css
		jQuery( '#resurrect-responsive-css' ).remove();

	} else {

		// Add helper class without delay
		jQuery( 'html' ).addClass( 'resurrect-responsive-on' );

		// Add viewport meta to head -- IMMEDIATELY, not on ready()
		jQuery( 'head' ).append(' <meta name="viewport" content="width=device-width, initial-scale=1">' );

	}
});
</script>
<?php

}

add_action( 'wp_head', 'resurrect_head_responsive_js' );
