<?php
/**
 * Giving Widget Template (Homepage)
 *
 * Produces output for appropriate widget class in framework.
 * $this, $instance (sanitized field values) and $args are available.
 * $GLOBALS['ctfw_current_widget'] can be used inside get_template_part();
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Title
$title = apply_filters( 'widget_title', $instance['title'] );

// Image
$image = wp_get_attachment_image_src( $instance['image_id'], 'saved-square-large' );
$image_url = ! empty( $image[0] ) ? $image[0] : '';

// Styles
$section_classes = array(
	'saved-image-section',
	saved_alternating_bg_class( 'contrast' ),
);

	if ( $image_url ) {
		$section_classes[] = 'saved-image-section-has-image';
		$section_classes[] = saved_widget_image_side_class(); // alternate left/right
		$image_style = ' style="background-image: url(' . esc_url( $image_url ) . ');"';
	} else {
		$section_classes[] = 'saved-image-section-no-image';
	}

// Buttons
$button_url = $instance['button_url'] && 'http://' != $instance['button_url'] ? $instance['button_url'] : '';
$buttons = array();
if ( $button_url && $instance['button_text'] ) {
	$buttons[$instance['button_url']] = $instance['button_text'];
}

?>

<section class="<?php echo esc_attr( implode( ' ', $section_classes ) ); ?>" <?php echo saved_homepage_section_id_attr(); ?>>

	<?php if ( $image_url ) : ?>
		<div class="saved-image-section-image"<?php echo $image_style; ?>></div>
	<?php endif; ?>

	<div class="saved-image-section-content saved-centered-large">

		<div class="saved-image-section-content-inner">

			<?php if ( $title ) : ?>
				<h2 class="saved-widget-title"><?php echo $title; ?></h2>
			<?php endif; ?>

			<?php if ( $instance['text'] ) : ?>

				<div class="saved-image-section-text">

					<?php echo wpautop( wptexturize( $instance['text'] ) ); ?>

				</div>

			<?php endif; ?>

			<?php if ( $buttons ) : ?>

				<div class="saved-image-section-buttons">

					<ul class="saved-buttons-list saved-buttons-list-large">

						<?php
						$button_i = 0;
						foreach ( $buttons as $button_url => $button_text ) : $button_i++;
						?>

							<li>
								<a href="<?php echo esc_url( $button_url ); ?>"<?php if ( $button_i > 1 ) : ?> class="saved-button-light saved-button-large"<?php endif; ?>>
									<?php echo esc_html( $button_text ); ?>
								</a>
							</li>

						<?php endforeach; ?>

					</ul>

				</div>

			<?php endif; ?>

		</div>

	</div>

</section>

<?php

// Reset post data
wp_reset_postdata();
