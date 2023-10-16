<?php
/**
 * <head> Functions
 *
 * Also see enqueue-styles.php and enqueue-scripts.php.
 *
 * @package    Saved
 * @subpackage Functions
 * @copyright  Copyright (c) 2017 - 2020, ChurchThemes.com
 * @link       https://churchthemes.com/themes/saved
 * @license    GPLv2 or later
 * @since      1.0
 */

// No direct access
if (! defined( 'ABSPATH' )) exit;

/*******************************************
 * CUSTOM STYLES
 *******************************************/

/**
 * Opacity to use in rgba() for main_color backgrounds
 * This is used in <head> and in Customizer preview
 *
 * @since 1.0
 */
function saved_main_color_rgb_opacity() {

	$opacity = '0.95';

	return apply_filters( 'saved_main_color_rgb_opacity', $opacity );

}

/**
 * Insert custom styles (colors, fonts, background, etc.) from Customizer for frontend and Classic Editor.
 *
 * @since 1.0
 */
function saved_head_styles() {

	// Colors
	$main_color = ctfw_customization( 'main_color' );
	$main_color_rgb = ctfw_hex_to_rgb( $main_color );
	$main_color_rgba = 'rgba(' . implode( ', ', $main_color_rgb ) . ', ' . saved_main_color_rgb_opacity() . ')'; // CSS
	$accent_color = ctfw_customization( 'accent_color' );

	// Fonts
	$logo_font_stack = ctfw_font_stack( ctfw_customization( 'logo_font' ), ctfw_google_fonts( 'logo_font' ) );
	$heading_font_stack = ctfw_font_stack( ctfw_customization( 'heading_font' ), ctfw_google_fonts( 'heading_font' ) );
	$nav_font_stack = ctfw_font_stack( ctfw_customization( 'nav_font' ), ctfw_google_fonts( 'nav_font' ) );
	$body_font_stack = ctfw_font_stack( ctfw_customization( 'body_font' ), ctfw_google_fonts( 'body_font' ) );

?>
<style type="text/css">
<?php echo saved_style_selectors( 'logo_font' ); ?> {
	font-family: <?php echo $logo_font_stack; ?>;
}

<?php echo saved_style_selectors( 'heading_font' ); ?> {
	font-family: <?php echo $heading_font_stack; ?>;
}

<?php echo saved_style_selectors( 'nav_font' ); ?> {
	font-family: <?php echo $nav_font_stack; ?>;
}

<?php echo saved_style_selectors( 'body_font' ); ?> {
	font-family: <?php echo $body_font_stack; ?>;
}

<?php echo saved_style_selectors( 'main_color' ); ?> {
	background-color: <?php echo $main_color; ?>;
}

<?php echo saved_style_selectors( 'main_color_rgba' ); ?> {
	background-color: <?php echo $main_color_rgba; ?>;
}

<?php echo saved_style_selectors( 'main_color_border' ); ?> {
	border-color: <?php echo $main_color; ?> !important;
}

<?php echo saved_style_selectors( 'main_color_rgba_border' ); ?> {
	border-color: <?php echo $main_color_rgba; ?>;
}

<?php echo saved_style_selectors( 'main_color_text' ); ?> {
	color: <?php echo $main_color; ?> !important;
}

<?php echo saved_style_selectors( 'accent_color' ); ?> {
	color: <?php echo $accent_color; ?>;
}

<?php echo saved_style_selectors( 'accent_color_important' ); ?> {
	color: <?php echo $accent_color; ?> !important;
}

<?php echo saved_style_selectors( 'accent_color_border' ); ?> {
	border-color: <?php echo $accent_color; ?>;
}

<?php echo saved_style_selectors( 'accent_color_border_left' ); ?> {
	border-left-color: <?php echo $accent_color; ?>;
}

<?php echo saved_style_selectors( 'accent_color_bg' ); ?> {
	background-color: <?php echo $accent_color; ?>;
}
</style>
<?php

}

add_action( 'wp_head', 'saved_head_styles' ); // add style to <head>

/**
 * Produce list of selectors for fonts, colors, etc. for frontend and Classic Editor.
 *
 * @since 1.0
 * @param string $group Group of selectors to return
 * @return string CSS selector list
 */
function saved_style_selectors( $group ) {

	$selectors = '';

	// Build elements array.
	$groups = array(

		// Font: Logo Text.
		'logo_font' => array(
			'#saved-logo-text'
		),

		// Font: Navigation (Menus, Links, Buttons, Labels).
		'nav_font' => array(

			'#saved-header-menu-content', // all menu links
			'.mean-container .mean-nav', // mobile menu top-level dropdown links (dropdowns are body font)
			'#saved-header-bottom', // section nav
			'.jq-dropdown', // section nav dropdowns, calendar nav dropdowns, etc.
			'#saved-footer-menu',
			'.saved-pagination', // pagination on loop multiple bottom use menu font
			'.saved-comment-title', // commenter name
			'.wp-block-latest-comments__comment-author',
			'.saved-entry-full-content a:not(.saved-icon)', // full posts, not compact/widget excerpt; not icons
			'.saved-entry-full-meta a:not(.saved-icon)', // full posts, not compact/widget excerpt
			'.saved-entry-full-footer a',
			'.saved-comment-content a',
			'.saved-map-section a',
			'#respond a',
			'.textwidget a',
			'.widget_ctfw-giving a',
			'.widget_mc4wp_form_widget a',
			'.saved-entry-full-meta-second-line a',
			'#saved-map-section-date .saved-map-section-item-note a',
			'.widget_rss li a',
			'.saved-entry-short-title',
			'.saved-entry-short-title a',
			'.saved-colored-section-title', // homepage events
			'.saved-entry-compact-right h3', // compact entry title (footer widgets)
			'.saved-entry-compact-right h3 a', // compact entry title (footer widgets)
			'.saved-sticky-item',
			'.saved-bg-section-text a',
			'.saved-image-section-text a',
			'#saved-sticky-content-custom-content a',
			'.mce-content-body a',
			'.saved-nav-left-right a',
			'select',

			// Buttons use nav font
			'.saved-button',
			'.saved-buttons-list a',
			'.saved-menu-button > a',
			'input[type=submit]',
			'.widget_tag_cloud a',
			'.wp-block-file .wp-block-file__button',

			// Widgets lists, etc.
			'.widget_categories > ul',
			'.widget_ctfw-categories > ul',
			'.widget_ctfw-archives > ul',
			'.widget_ctfw-galleries > ul',
			'.widget_recent_entries > ul',
			'.widget_archive > ul',
			'.widget_meta > ul',
			'.widget_pages > ul',
			'.widget_links > ul',
			'.widget_nav_menu ul.menu',
			'.widget_calendar #wp-calendar nav span',
			'.wp-block-calendar #wp-calendar nav span',

			// Dates/Labels/Tables.
			'.saved-entry-compact-image time',
			'.saved-entry-short-label',
			'.saved-colored-section-label',
			'.saved-sticky-item-date',
			'#saved-map-section-address',
			'.saved-entry-full-date',
			'.saved-entry-full-meta-bold',
			'#saved-map-section-date .saved-map-section-item-text',
			'.widget_calendar #wp-calendar caption',
			'.widget_calendar #wp-calendar th',
			'.saved-calendar-table-header-content',
			'.wp-block-calendar #wp-calendar caption',
			'.wp-block-calendar #wp-calendar th',
			'dt',
			'.saved-entry-content th',
			'.mce-content-body th',
			'blockquote cite',
			'#respond label:not(.error):not([for=wp-comment-cookies-consent])', // comment form field
			'.wp-block-table tr:first-of-type strong',
			'.wp-block-search__label',

		),

		// Font: Headings
		'heading_font' => array(

			// Major Headings (uppercase, line before)
			// Those which use Heading Font below and in base-elements.scss
			// If update this, change those to be similar (also in media-queries.scss)
			'.saved-entry-content h1',
			'.saved-entry-content h2',
			'.saved-entry-content h3',
			'.saved-entry-content h4',
			'.saved-entry-content h5',
			'.saved-entry-content h6',
			'.saved-entry-content .saved-h1',
			'.saved-entry-content .saved-h2',
			'.saved-entry-content .saved-h3',
			'.saved-entry-content .saved-h4',
			'.saved-entry-content .saved-h5',
			'.saved-entry-content .saved-h6',
			'.saved-widget .saved-entry-compact-header h3', // footer widget entry titles
			'.mce-content-body h1',
			'.mce-content-body h2',
			'.mce-content-body h3',
			'.mce-content-body h4',
			'.mce-content-body h5',
			'.mce-content-body h6',
			'.textwidget h1',
			'.textwidget h2',
			'.textwidget h3',
			'.textwidget h4',
			'.textwidget h5',
			'.textwidget h6',
			'.saved-bg-section-content h1',
			'.saved-bg-section-content h2',
			'#saved-banner-title div',
			'.saved-widget-title',
			'.saved-caption-image-title',
			'#saved-comments-title',
			'#reply-title',
			'.saved-nav-block-title',
			'.has-drop-cap:not(:focus):first-letter',

			// Headings with links (use this font, not nav font).
			'.saved-entry-content h1',
			'.saved-entry-content h2',
			'.saved-entry-content h3',
			'.saved-entry-content h4',
			'.saved-entry-content h5',
			'.saved-entry-content h6',
			'.saved-entry-content .saved-h1',
			'.saved-entry-content .saved-h2',
			'.saved-entry-content .saved-h3',
			'.saved-entry-content .saved-h4',
			'.saved-entry-content .saved-h5',
			'.saved-entry-content .saved-h6',
			'.mce-content-body h1',
			'.mce-content-body h2',
			'.mce-content-body h3',
			'.mce-content-body h4',
			'.mce-content-body h5',
			'.mce-content-body h6',

		),

		// Font: Body Text
		'body_font' => array(
			'body',
			'#cancel-comment-reply-link',
			'.saved-entry-short-meta a:not(.saved-icon)',
			'.saved-entry-content-short a',
			'.ctfw-breadcrumbs',
			'.saved-caption-image-description',
			'.saved-entry-full-meta-second-line',
			'#saved-header-archives-section-name',
			'.saved-comment-title span', // "Author" by name
			'#saved-calendar-title-category',
			'#saved-header-search-mobile input[type=text]',
			'.saved-entry-full-content .saved-sermon-index-list li li a:not(.saved-icon)',
			'pre.wp-block-verse',
		),

		// Main Color (Background)
		'main_color' => array(

		),

		// Main Color (Background, RGB, Semi-transparent)
		'main_color_rgba' => array(
			'.saved-color-main-bg',
			'.sf-menu ul', // menu dropdowns
			'.saved-calendar-table-header',
			'.saved-calendar-table-top',
			'.saved-calendar-table-header-row', // fills gaps in Retina when resizing
			'.mean-container .mean-nav', // mobile menu
			'.jq-dropdown .jq-dropdown-menu', // section nav dropdowns, calendar nav dropdowns, etc.
			'.jq-dropdown .jq-dropdown-panel', // section nav dropdowns, calendar nav dropdowns, etc.
			'.tooltipster-sidetip.saved-tooltipster .tooltipster-box',
			'.saved-entry-compact-image time',
			'.saved-entry-short-label',
			'#saved-sticky',

			'.has-main-background-color',
			'p.has-main-background-color',

		),

		// Main Color (Border)
		'main_color_border' => array(
			'.saved-calendar-table-header', // border is gray if dont do this.
		),

		// Main Color (Border, RGB, Semi-transparent)
		'main_color_rgba_border' => array(
			'#saved-header-top.saved-header-has-line',
			'.saved-calendar-table-header',
		),

		// Main Color (Text)
		'main_color_text' => array(
			'#saved-logo-text',
			'#saved-logo-text a',
			'.mean-container .mean-nav ul li a.mean-expand',

			'.has-main-color',
			'p.has-main-color',

		),

		// Accent Color
		'accent_color' => array(
			'a',
			'a:hover',
			'#saved-header-menu-content > li:hover > a', // top-level link (keeps top-level colored while hovering on submenu)
			'#saved-map-section-list a:hover',
			'#saved-header-search a:hover',
			'#saved-header-search-opened .saved-search-button',
			'#saved-header-icons a:hover',
			'.saved-entry-short-icons .saved-icon:hover',
			'.saved-entry-compact-icons .saved-icon:hover',
			'.saved-entry-full-meta a:hover', // full posts, not compact/widget excerpt
			'#saved-calendar-remove-category a:hover',
			'#saved-calendar-header-right a',
			'.mean-container .saved-icon-mobile-menu-close',
			'#saved-map-section-marker .saved-icon', // map marker icon
			'.saved-entry-full-content .saved-entry-short-meta a:hover',
			'.saved-entry-full-meta > li a.mdi:hover',
			'.widget_search .saved-search-button:hover',
			'#respond a:hover',
		),

		// Accent Color (!important declaration)
		'accent_color_important' => array(

			'.saved-entry-content a:hover:not(.saved-button):not(.wp-block-file__button)',
			'.saved-entry-compact-right a:hover',
			'.saved-entry-full-meta a:hover',

			// Light buttons text on hover
			'.saved-button.saved-button-light:hover',
			'.saved-buttons-list a.saved-button-light:hover',

			// Colored button on hover (acts like light)
			'.saved-button:hover',
			'.saved-buttons-list a:hover',
			'input[type=submit]:hover',
			'.widget_tag_cloud a:hover',
			'.saved-nav-left-right a:hover',
			'.wp-block-file .wp-block-file__button:hover',

			'.has-accent-color',
			'p.has-accent-color',

		),

		// Accent Color (Border)
		'accent_color_border' => array(

			'.saved-entry-short-title a',
			'.saved-entry-compact-right h3 a', // widget entry title

			// Entry Content Links (full content, short excerpt and comment content use these)
			'.saved-entry-full-content a:not(.saved-button):not(.saved-button-light):not(.wp-block-file__button)',
			'.saved-entry-full-meta a:not(.saved-button)',
			'.saved-entry-full-footer a:not(.saved-button)',
			'.saved-comments a:not(.saved-button)',
			'.saved-map-section a:not(.saved-button)',
			'#respond a:not(.saved-button)',
			'.saved-compact-content a:not(.saved-button)',
			'.textwidget a:not(.saved-button)',
			'.widget_ctfw-giving a',
			'.widget_mc4wp_form_widget a',
			'.saved-image-section-text a',
			'.mce-content-body a',

			// Major Headings (uppercase, line before)
			// Those which use Heading Font above and in base-elements.scss
			// If update this, change those to be similar (also in media-queries.scss)
			'.saved-entry-content h1::before',
			'.saved-entry-content h2::before',
			'.saved-entry-content h3::before',
			'.saved-entry-content h4::before',
			'.saved-entry-content h5::before',
			'.saved-entry-content h6::before',
			'.saved-entry-content .saved-h1::before',
			'.saved-entry-content .saved-h2::before',
			'.saved-entry-content .saved-h3::before',
			'.saved-entry-content .saved-h4::before',
			'.saved-entry-content .saved-h5::before',
			'.saved-entry-content .saved-h6::before',
			'.mce-content-body h1::before',
			'.mce-content-body h2::before',
			'.mce-content-body h3::before',
			'.mce-content-body h4::before',
			'.mce-content-body h5::before',
			'.mce-content-body h6::before',
			'.saved-widget-title::before',
			'#saved-comments-title::before',
			'#reply-title::before',
			'.saved-nav-block-title::before',
			'.saved-entry-full-meta-label::before',
			'dt::before',
			'.saved-entry-content th::before',
			'.mce-content-body th::before',
			'#saved-map-section-address::before',

			// Forms
			'#saved-header-search input[type=text]:focus',
			'input:focus',
			'textarea:focus',

		),

		// Accent Color (Border Left)
		'accent_color_border_left' => array(

		),

		// Accent Color (Background)
		'accent_color_bg' => array(
			'.saved-button',
			'.saved-buttons-list a',
			'.saved-menu-button > a',
			'input[type=submit]',
			'.widget_tag_cloud a',
			'.saved-nav-left-right a',
			'.wp-block-file .wp-block-file__button',

			'.has-accent-background-color',
			'p.has-accent-background-color',

		),

	);

	// Allow filtering
	$groups = apply_filters( 'saved_style_selectors', $groups );

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
 * Output a version of saved_head_styles() tailored to Gutenberg.
 *
 * This is called by ctfw_editor_styles() when specified in add_theme_support( 'ctfw-editor-styles' ) css_block_function.
 *
 * @since 1.2
 */
function saved_block_editor_head_styles() {

	// Colors
	$main_color = ctfw_customization( 'main_color' );
	$main_color_rgb = ctfw_hex_to_rgb( $main_color );
	$main_color_rgba = 'rgba(' . implode( ', ', $main_color_rgb ) . ', ' . saved_main_color_rgb_opacity() . ')'; // CSS
	$accent_color = ctfw_customization( 'accent_color' );

	// Fonts
	$logo_font_stack = ctfw_font_stack( ctfw_customization( 'logo_font' ), ctfw_google_fonts( 'logo_font' ) );
	$heading_font_stack = ctfw_font_stack( ctfw_customization( 'heading_font' ), ctfw_google_fonts( 'heading_font' ) );
	$nav_font_stack = ctfw_font_stack( ctfw_customization( 'nav_font' ), ctfw_google_fonts( 'nav_font' ) );
	$body_font_stack = ctfw_font_stack( ctfw_customization( 'body_font' ), ctfw_google_fonts( 'body_font' ) );

?>
<style type="text/css">

<?php echo saved_block_editor_style_selectors( 'heading_font' ); ?> {
	font-family: <?php echo $heading_font_stack; ?> !important;
}

<?php echo saved_block_editor_style_selectors( 'nav_font' ); ?> {
	font-family: <?php echo $nav_font_stack; ?> !important;
}

<?php echo saved_block_editor_style_selectors( 'body_font' ); ?> {
	font-family: <?php echo $body_font_stack; ?> !important;
}

<?php echo saved_block_editor_style_selectors( 'main_color' ); ?> {
	background-color: <?php echo $main_color; ?>;
}

<?php echo saved_block_editor_style_selectors( 'main_color_rgba' ); ?> {
	background-color: <?php echo $main_color_rgba; ?>;
}

<?php echo saved_block_editor_style_selectors( 'main_color_border' ); ?> {
	border-color: <?php echo $main_color; ?> !important;
}

<?php echo saved_block_editor_style_selectors( 'main_color_rgba_border' ); ?> {
	border-color: <?php echo $main_color_rgba; ?>;
}

<?php echo saved_block_editor_style_selectors( 'main_color_text' ); ?> {
	color: <?php echo $main_color; ?> !important;
}

<?php echo saved_block_editor_style_selectors( 'accent_color' ); ?> {
	color: <?php echo $accent_color; ?>;
}

<?php echo saved_block_editor_style_selectors( 'accent_color_important' ); ?> {
	color: <?php echo $accent_color; ?> !important;
}

<?php echo saved_block_editor_style_selectors( 'accent_color_border' ); ?> {
	border-color: <?php echo $accent_color; ?>;
}

<?php echo saved_block_editor_style_selectors( 'accent_color_border_left' ); ?> {
	border-left-color: <?php echo $accent_color; ?>;
}

<?php echo saved_block_editor_style_selectors( 'accent_color_bg' ); ?> {
	background-color: <?php echo $accent_color; ?>;
}
</style>
<?php

}

/**
 * Produce list of selectors for fonts, colors, etc. for Block Editor.
 *
 * This is used by saved_block_editor_head_styles() for Gutenberg only.
 *
 * @since 1.0
 * @param string $group Group of selectors to return
 * @return string CSS selector list
 */
function saved_block_editor_style_selectors( $group ) {

	$selectors = '';

	// Build elements array
	$groups = array(

		// Font: Navigation (Links, Buttons)
		'nav_font' => array(

			'.wp-block-freeform.block-library-rich-text__tinymce a',
			'.block-editor-rich-text__editable a:not(.blocks-format-toolbar__link-value)',
			'.wp-block-file__textlink .block-editor-rich-text__editable',
			'.wp-block-file__content-wrapper a.block-editor-rich-text__editable',

			// Buttons use nav font
			'.edit-post-visual-editor .wp-block-button',
			'.edit-post-visual-editor .saved-button',
			'.wp-block-file__button',

			// Dates/Labels/Tables
			'.wp-block-freeform.block-library-rich-text__tinymce dt',
			'.edit-post-visual-editor .wp-block-freeform dt',
			'.edit-post-visual-editor .wp-block-table tr:first-of-type .block-editor-rich-text__editable',
			'.wp-block-freeform.block-library-rich-text__tinymce th',
			'.edit-post-visual-editor .wp-block-quote__citation.block-editor-rich-text__editable',
			'.edit-post-visual-editor .wp-block-pullquote__citation.block-editor-rich-text__editable',
			'.edit-post-visual-editor .wp-block-pullquote cite',
			'.wp-block-freeform.block-library-rich-text__tinymce blockquote cite',
			'.wp-block-latest-comments__comment-author',
			'.wp-block-search__label .block-editor-rich-text__editable',
			'.wp-block-calendar #wp-calendar caption',
			'.wp-block-calendar #wp-calendar th',

			'.wp-block-latest-posts a',
			'.wp-block-categories a',
			'.wp-block-archives a',
			'.wp-block-latest-comments a',
			'.wp-block-rss a',
			'.wp-block-calendar a',
			'.wp-block-tag-cloud a',
			'.wp-block-page-list a',

		),

		// Font: Headings
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

		// Font: Body Text.
		'body_font' => array(

			'.edit-post-visual-editor',
			'.edit-post-visual-editor p',
			'.edit-post-visual-editor .block-editor-default-block-appender input[type=text].block-editor-default-block-appender__content', // body placeholder.
			'.edit-post-visual-editor .wp-block-verse',
			'.edit-post-visual-editor .wp-block-freeform blockquote:before', // Classic Editor
			'.edit-post-visual-editor .wp-block-freeform ol', // Classic Editor
			'.edit-post-visual-editor .wp-block-freeform ul', // Classic Editor
			'.edit-post-visual-editor .wp-block-latest-comments__comment-date',
			'.edit-post-visual-editor .wp-block-rss',
			'.edit-post-visual-editor .wp-block-search__input',
			'.edit-post-visual-editor .block-library-list .block-editor-rich-text__editable',
			'.edit-post-visual-editor figcaption',

			// Table rows
			'.edit-post-visual-editor .wp-block-table',
			'.edit-post-visual-editor .wp-block-table table',
			'.edit-post-visual-editor .wp-block-table td',
			'.edit-post-visual-editor .wp-block-table th',
			'.edit-post-visual-editor .wp-block-table tr:first-of-type .block-editor-rich-text__editable',

		),

		// Main Color (Background).
		'main_color' => array(
			'.edit-post-visual-editor__post-title-wrapper',
		),

		// Accent Color.
		'accent_color' => array(

		),

		// Accent Color (!important declaration).
		'accent_color_important' => array(

		),

		// Accent Color (Border).
		'accent_color_border' => array(

			// Entry Content Links.
			'.wp-block-freeform.block-library-rich-text__tinymce a',
			'.block-editor-rich-text__editable a:not(.blocks-format-toolbar__link-value)',
			'.edit-post-visual-editor .has-background.has-light-background-color:not(.has-text-color) a',
			'.wp-block-file__textlink .block-editor-rich-text__editable',
			'.wp-block-file__content-wrapper a.block-editor-rich-text__editable',

			// Headings.
			'.edit-post-visual-editor h1.block-editor-rich-text__editable::before',
			'.edit-post-visual-editor h2.block-editor-rich-text__editable::before',
			'.edit-post-visual-editor h3.block-editor-rich-text__editable::before',
			'.edit-post-visual-editor h4.block-editor-rich-text__editable::before',
			'.edit-post-visual-editor h5.block-editor-rich-text__editable::before',
			'.edit-post-visual-editor h6.block-editor-rich-text__editable::before',

			// Classic Block.
			'.wp-block-freeform.block-library-rich-text__tinymce h1::before',
			'.wp-block-freeform.block-library-rich-text__tinymce h2::before',
			'.wp-block-freeform.block-library-rich-text__tinymce h3::before',
			'.wp-block-freeform.block-library-rich-text__tinymce h4::before',
			'.wp-block-freeform.block-library-rich-text__tinymce h5::before',
			'.wp-block-freeform.block-library-rich-text__tinymce h6::before',

			'.wp-block-latest-posts a',
			'.wp-block-categories a',
			'.wp-block-archives a',
			'.wp-block-latest-comments a',
			'.wp-block-rss a',
			'.wp-block-calendar a',
			'.wp-block-tag-cloud a',
			'.wp-block-page-list a',

		),

		// Accent Color (Background).
		'accent_color_bg' => array(
			'.edit-post-visual-editor .wp-block-button .wp-block-button__link',
			'.edit-post-visual-editor .wp-block-file .wp-block-file__button',
			'.edit-post-visual-editor .saved-button',
		),

	);

	// Allow filtering.
	$groups = apply_filters( 'saved_block_editor_style_selectors', $groups );

	// Build list.
	if (! empty( $groups[ $group ] )) {
		$selectors = implode( ', ', $groups[ $group ] );
	}

	return $selectors;

}

/******************************************
 * JAVASCRIPT DETECTION
 ******************************************/

/**
 * Remove no-js and add js class to <html>
 *
 * Do this directly in <head> to it happens immediately (no wait for JS file to load or document ready)
 * This helps eliminate "flicker" effects in CSS due to a delay in classes being applied
 *
 * To Do: This could be made into a framework feature.
 *
 * @since 1.0
 */
function saved_head_js_classes() {

?>
<script type="text/javascript">

jQuery( 'html' )
 	.removeClass( 'no-js' )
 	.addClass( 'js' );

</script>
<?php

}

add_action( 'wp_head', 'saved_head_js_classes' );
