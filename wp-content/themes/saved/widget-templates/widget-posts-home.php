<?php
/**
 * Posts Widget Template (Homepage)
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

// Buttons
$buttons = array();

	// People template page
	$blog_url = ctfw_posts_page_url();
	if ( $blog_url ) {
		$buttons[$blog_url] = _x( 'More Posts', 'homepage blog button', 'saved' );
	}

	// Blog categories
	$categories = get_terms( array(
		'taxonomy' => 'category',
		'orderby' => 'count', // order by biggest categories as they're likely to be most recently updated.
		'order' => 'DESC',
		'hide_empty' => true,
	) );
	$categories = array_slice( $categories, 0, 3 ); // maximum; there's only so much space
	foreach ( $categories as $category ) {
		$category_url = get_term_link( $category, 'category' );
		$buttons[$category_url] = $category->name;
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

			<?php if ( $posts ) : ?>

				<div class="saved-loop-entries saved-loop-<?php echo esc_attr( $columns ); ?>-columns saved-clearfix">

					<?php
					foreach ( $posts as $post ) {

						setup_postdata( $post );

						get_template_part( CTFW_THEME_PARTIAL_DIR . '/content-post-short' );

					}
					?>

				</div>

				<?php if ( $buttons ) : ?>

					<div class="saved-image-section-buttons">

						<ul class="saved-buttons-list">

							<?php
							$button_i = 0;
							foreach ( $buttons as $button_url => $button_text ) : $button_i++;
							?>

								<li>
									<a href="<?php echo esc_url( $button_url ); ?>"<?php if ( $button_i > 1 ) : ?> class="saved-button-light"<?php endif; ?>>
										<?php echo esc_html( $button_text ); ?>
									</a>
								</li>

							<?php endforeach; ?>

						</ul>

					</div>

				<?php endif; ?>

			<?php else : ?>

				<p>
					<?php echo esc_html( _x( 'There are no posts to show.', 'posts widget', 'saved' ) ); ?>
				</p>

			<?php endif; ?>

		</div>

	</div>

</section>

<?php

// Reset post data
wp_reset_postdata();
