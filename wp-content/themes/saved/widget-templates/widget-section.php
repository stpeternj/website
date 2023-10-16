<?php
/**
 * Section Widget Template
 *
 * Produces output for appropriate widget class in framework.
 * $this, $instance (sanitized field values) and $args are available.
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Is this ifrst of all widgets on homepage?
$is_first_widget = ctfw_is_first_widget(); // first widget in section

// Brightness
$brightness_decimal = 1 - ( ( ! empty( $instance['image_brightness'] ) ? $instance['image_brightness'] : ctfw_customization( 'header_image_brightness' ) ) / 100 ); // reversed since overlay

// Opacity
$opacity_decimal = ( ! empty( $instance['image_opacity'] ) ? $instance['image_opacity'] : ctfw_customization( 'header_image_opacity' ) ) / 100;
$opacity_decimal_image = $opacity_decimal;
$opacity_decimal_video = 1 - $opacity_decimal; // 0.9 instead of 0.1 when laid over video

// Image
$image = wp_get_attachment_image_src( $instance['image_id'], 'saved-section' );
$image_url = ! empty( $image[0] ) ? $image[0] : '';

// Video
// First widget on homepage only. Poor performance/overwhelming on multiple.
// Multiple videos also create z-index issues in non-webkit browsers (FF, Edge, IE)
// Video opacity is 100% and color goes on top because of opacity big w/Chrome on Mac: http://stackoverflow.com/questions/40349678/video-with-css-opacity-property-appears-unusually-dim-on-chrome-54-for-mac-onl
$video_url = $is_first_widget && ! empty( $instance['video'] ) ? $instance['video'] : '';
if ( $video_url ) {

	// Is it MP4?
	$video_url_no_qs = strtok( $video_url, '?' ); // check without query string, so Dropbox ?raw=1 can be used.
	$video_url_data = wp_check_filetype( $video_url_no_qs );
	if ( 'mp4' == $video_url_data['ext'] ) { // these are same if .mp4 was not removed

		// Enqueue Vide JS only when a widget uses video on homepage
		wp_enqueue_script( 'jquery-vide', get_theme_file_uri( CTFW_THEME_JS_DIR . '/lib/jquery.vide.js' ), array( 'jquery' ), CTFW_THEME_VERSION ); // bust cache on theme update

	}

	// Unset video URL since not MP4
	else {
		$video_url = '';
	}

}

// Heading tag
$heading_tag = 'h1';
if ( ! $is_first_widget ) {
	$heading_tag = 'h2';
}

?>

<section<?php

	$li_classes = array();

	// Main classes
	$li_classes[] = 'saved-bg-section';

	// Is first widget
	if ( $is_first_widget ) {
		$li_classes[] = 'saved-first-home-widget';
	}

	// Height
	$li_classes[] = 'saved-viewport-height-' . $instance['height'];

	// Color class
	$li_classes[] = 'saved-color-main-bg';

	// Title
	if ( $instance['title'] ) {
		$li_classes[] = 'saved-section-has-title';
	} else {
		$li_classes[] = 'saved-section-no-title';
	}

	// Content
	if ( $instance['content'] ) {
		$li_classes[] = 'saved-section-has-content';
	} else {
		$li_classes[] = 'saved-section-no-content';
	}

	// Image
	if ( $image_url ) {
		$li_classes[] = 'saved-section-has-image';
	} else {
		$li_classes[] = 'saved-section-no-image';
	}

	// Video
	if ( $video_url ) {
		$li_classes[] = 'saved-section-has-video';
	} else {
		$li_classes[] = 'saved-section-no-video';
	}

	// Image or Video
	if ( $image_url || $video_url ) {
		$li_classes[] = 'saved-section-has-image-or-video';
	} elseif ( ! $image_url && ! $video_url ) {
		$li_classes[] = 'saved-section-no-image-or-video';
	}

	// Attachment
	$li_classes[] = 'saved-bg-section-attachment-' . $instance['attachment'];

	// Large Text
	// Vertical orientation only
	if ( 'large' == $instance['text_size'] && $instance['orientation'] != 'horizontal' ) {
		$li_classes[] = 'saved-section-has-large-text';
	} else {
		$li_classes[] = 'saved-section-no-large-text';
	}

	// Centered
	if ( $instance['centered'] ) {
		$li_classes[] = 'saved-section-is-centered';
	} else {
		$li_classes[] = 'saved-section-not-centered';
	}

	// Orientation
	$li_classes[] = 'saved-section-orientation-' . $instance['orientation'];

	// Output classes
	if ( ! empty( $li_classes ) ) {
		echo ' class="' . esc_attr( implode( ' ', $li_classes ) ) . '"';
	}

?> <?php echo saved_homepage_section_id_attr(); ?>>

	<?php if ( $image_url ) : ?>
		<div class="saved-bg-section-image" style="<?php echo esc_attr( "opacity: $opacity_decimal_image; background-image: url($image_url);" ); ?>"></div> <!-- faster than :before on FF/Retina -->
	<?php endif; ?>

	<?php if ( $video_url ) : ?>

		<div id="saved-bg-section-video">

			<div id="saved-bg-section-video-vide" data-video-url="<?php echo esc_url( $video_url ); ?>"></div>

			<div id="saved-bg-section-video-color" class="saved-color-main-bg" style="<?php echo esc_attr( "opacity: $opacity_decimal_video;" ); ?>"></div>

		</div>

	<?php endif; ?>

	<?php if ( $image_url || $video_url ) : ?>
		<div class="saved-bg-section-brightness" style="<?php echo esc_attr( "opacity: $brightness_decimal;" ); ?>"></div>
	<?php endif; ?>

	<div class="saved-bg-section-inner">

		<div class="saved-bg-section-content">

			<?php if ( $instance['title'] ) : // title provided ?>

				<<?php echo $heading_tag; ?>>
					<?php echo esc_html( $instance['title'] ); ?>
				</<?php echo $heading_tag; ?>>

			<?php endif; ?>

			<?php if ( $instance['content'] ) : // content provided ?>

				<div class="saved-bg-section-text<?php if ( preg_match( '/^\".*/i', $instance['content'] ) ) : // starts with " ?> saved-bg-section-text-quote<?php endif; ?>">
					<?php echo do_shortcode( wpautop( wptexturize( force_balance_tags( $instance['content'] ) ) ) ); ?>
				</div>

			<?php endif; ?>

			<?php
			$links = $this->ctfw_links();
			$i = 0;
			if ( $links ) :
			?>

				<div class="saved-section-bg-buttons">

					<ul class="saved-buttons-list<?php if ( $instance['orientation'] != 'horizontal' ) : ?> saved-buttons-list-large<?php endif; ?>">

						<?php foreach( $links as $link ) : $i++ ?>
							<li><a href="<?php echo esc_url( $link['url'] ); ?>" class="<?php if ( $i > 1 || ! ( $image_url || $video_url ) || $instance['image_opacity'] < 40 ) : ?>saved-button-light<?php endif; ?><?php if ( ! $image_url && ! $video_url ) : ?> saved-button-no-hover-line<?php endif; ?>"><?php echo esc_html( $link['text'] ); ?></a></li>
						<?php endforeach; ?>

					</ul>

				</div>

			<?php endif; ?>

		</div>

	</div>

</section>
