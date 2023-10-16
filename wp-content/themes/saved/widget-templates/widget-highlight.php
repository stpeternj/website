<?php
/**
 * Highlight Widget Template
 *
 * Produces output for appropriate widget class in framework.
 * $this, $instance (sanitized field values) and $args are available.
 */

// No direct access
if (! defined( 'ABSPATH' )) exit;

// No before_widget / after_widget on homepage section
if (ctfw_is_sidebar( 'ctcom-home' )) {
	$args['before_widget'] = '';
	$args['after_widget'] = '';
}

// Override before/after title
// This is because Homepage Section does not use before/after, but need it for Highlight widget styling
$args['before_title'] = '<h2 class="saved-widget-title">';
$args['after_title'] = '</h2>';

// Title
$title = apply_filters( 'widget_title', $instance['title'] );
if (! empty( $title )) {
	$title = $args['before_title'] . $title . $args['after_title'];
}

// Brightness and Opacity
$brightness_decimal = 1 - ( ( ! empty( $instance['image_brightness'] ) ? $instance['image_brightness'] : ctfw_customization( 'header_image_brightness' ) ) / 100 ); // reversed since overlay
$opacity_decimal = ( ! empty( $instance['image_opacity'] ) ? $instance['image_opacity'] : ctfw_customization( 'header_image_opacity' ) ) / 100;

// Image
$image = wp_get_attachment_image_src( $instance['image_id'], 'saved-square' );
$image_url = ! empty( $image[0] ) ? $image[0] : '';

// HTML Before
echo $args['before_widget'];

// Important that there is no whitespace between elements
?><div<?php

	$li_classes = array( 'saved-caption-image', 'saved-highlight' );

	// Has image?
	if ($image_url) {
		$li_classes[] = 'saved-caption-image-has-image';
	} else {
		$li_classes[] = 'saved-caption-image-no-image'; // main color if no image
	}

	// Is it linked?
	if ($instance['click_url']) {
		$li_classes[] = 'saved-highlight-linked';
	}

	// Link opens in new window?
	if ($instance['click_new']) {
		$li_classes[] = 'saved-highlight-click-new';
	}

	// Has title?
	if ($instance['title']) {
		$li_classes[] = 'saved-highlight-has-title';
	} else {
		$li_classes[] = 'saved-highlight-no-title';
	}

	// Has description?
	if ($instance['description']) {
		$li_classes[] = 'saved-highlight-has-description';
	} else {
		$li_classes[] = 'saved-highlight-no-description';
	}

	// Has title or description (caption)?
	if ($instance['title'] || $instance['description']) {
		$li_classes[] = 'saved-highlight-has-caption';
	} else {
		$li_classes[] = 'saved-highlight-no-caption';
	}

	// Add classes to div
	if (! empty( $li_classes )) {
		echo ' class="' . implode( ' ', $li_classes ) . '"';
	}

?>>

	<div class="saved-caption-image-inner saved-color-main-bg">

		<?php if ($instance['click_url']) : ?>
			<a href="<?php echo esc_url( do_shortcode( $instance['click_url'] ) ); ?>"<?php if ($instance['click_new']) : ?> target="_blank" rel="noopener noreferrer"<?php endif; ?>>
		<?php endif; ?>

			<?php if ($image_url) : // valid image specified ?>

				<div class="saved-caption-image-bg saved-hover-bg" style="<?php echo esc_attr( "opacity: $opacity_decimal; background-image: url( $image_url );" ); ?>"></div>

				<div class="saved-caption-image-brightness" style="<?php echo esc_attr( "opacity: $brightness_decimal" ); ?>"></div>

				<div class="saved-caption-image-gradient"></div>

			<?php endif; ?>

			<img src="<?php echo apply_filters( 'saved_square_placeholder_url', CTFW_THEME_URL . '/images/square-placeholder.png' ); ?>" alt=""> <?php // use transparent placeholder thumbnail of proper proportion ?>

			<?php if ($title || $instance['description']) : ?>
				<div class="saved-caption-image-caption">
			<?php endif; ?>

				<?php if ($title) : ?>
					<div class="saved-caption-image-title">
						<?php echo $title; ?>
					</div>
				<?php endif; ?>

				<?php if ($instance['description']) : ?>
					<div class="saved-caption-image-description">
						<?php echo $instance['description']; ?>
					</div>
				<?php endif; ?>

			<?php if ($title || $instance['description']) : ?>
				</div>
			<?php endif; ?>

		<?php if ($instance['click_url']) : ?>
			</a>
		<?php endif; ?>

	</div>

</div><?php // Important that there is no whitespace between elements

// HTML After
echo $args['after_widget'];
