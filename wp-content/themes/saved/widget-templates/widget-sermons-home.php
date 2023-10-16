<?php
/**
 * Sermons Widget Template (Homepage)
 *
 * Produces output for appropriate widget class in framework.
 * $this, $instance (sanitized field values) and $args are available.
 * $GLOBALS['ctfw_current_widget'] can be used inside get_template_part();
 *
 * $this->ctfw_get_posts() can be used to produce a query according to widget field values.
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
	saved_alternating_bg_class( 'contrast' ), // contrast with white entry boxes
);

	if ( $image_url ) {
		$section_classes[] = 'saved-image-section-has-image';
		$section_classes[] = saved_widget_image_side_class(); // alternate left/right
		$image_style = ' style="background-image: url(' . esc_url( $image_url ) . ');"';
		$columns = 'three'; // make space for image
	} else {
		$section_classes[] = 'saved-image-section-no-image';
		$columns = 'four'; // full-width if no image
	}

// Get posts
$posts = $this->ctfw_get_posts(); // widget's default query according to field values
$count = count( $posts );

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

			<?php if ( $posts ) : ?>

				<div class="saved-loop-entries saved-loop-<?php echo esc_attr( $columns ); ?>-columns<?php if ( $count > 2 ) : ?> saved-entries-more-than-two<?php endif; ?> saved-clearfix">

					<?php
					foreach ( $posts as $post ) {

						setup_postdata( $post );

						get_template_part( CTFW_THEME_PARTIAL_DIR . '/content-sermon-short' );

					}
					?>

				</div>

				<?php
				// Buttons for sermon archives
				get_template_part( CTFW_THEME_PARTIAL_DIR . '/sermon-archive-buttons' );
				?>

			<?php else : ?>

				<p>
					<?php
					echo esc_html( sprintf(
						/* translators: $1$s is "sermons" (lowercase), possibly translated or changed by settings */
						_x( 'There are no %1$s to show.', 'sermons widget', 'saved' ),
						strtolower( ctfw_sermon_word_plural() )
					) );
					?>
				</p>

			<?php endif; ?>

		</div>

	</div>

</section>

<?php

// Reset post data.
wp_reset_postdata();
