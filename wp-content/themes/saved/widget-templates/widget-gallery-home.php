<?php
/**
 * Gallery Widget Template (Homepage)
 *
 * Produces output for appropriate widget class in framework.
 * $this, $instance (sanitized field values) and $args are available.
 *
 * $this->ctfw_get_posts() can be used to produce a query according to widget field values.
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Title
$title = apply_filters( 'widget_title', $instance['title'] );

// Get photo posts
// See saved_home_gallery_widget_args which forces settings for widget on homepage
$posts = $this->ctfw_get_posts(); // widget's default query according to field values
$photo_count = count( $posts );

// Get ID's into list
$ids_array = array();
foreach ( $posts as $post ) {
	$ids_array[] = $post->ID;
}
$ids = implode( ',', $ids_array );

// Button URL
$button_url = '';

	// Use a specific page, if specified in widget settings and exists
	if ( $instance['post_id'] && 'all' != $instance['post_id'] ) {
		$button_url = get_permalink( $instance['post_id'] );
	}

	// Use page having "Galleries" template, if exists
	if ( ! $button_url ) { // either wasn't able to get a gallery's page or did no choose a specific gallery
		$button_url = ctfw_get_page_url_by_template( 'galleries.php' );
	}

// Styles
$section_classes = array(
	'saved-image-section',
	'saved-gallery-section',
	saved_alternating_bg_class( 'contrast' ),
);

	if ( $title ) {
		$section_classes[] = 'saved-gallery-section-has-title';
	}

?>

<section class="<?php echo esc_attr( implode( ' ', $section_classes ) ); ?>" <?php echo saved_homepage_section_id_attr(); ?>>

	<div class="saved-gallery-section-content">

		<?php if ( $title ) : ?>

			<header class="saved-gallery-section-header saved-centered-large">

				<?php if ( $button_url ) : ?>

					<a href="<?php echo esc_url( $button_url ); ?>" class="saved-button saved-gallery-section-button">
						<?php echo esc_html( _x( 'See More', 'home gallery widget', 'saved' ) ); ?>
					</a>

				<?php endif; ?>

				<h2 class="saved-widget-title"><?php echo $title; ?></h2>

			</header>

		<?php endif; ?>

		<?php if ( $posts ) : ?>

			<div class="saved-gallery-section-photos saved-gallery-section-photos-<?php echo esc_attr( $photo_count ); ?> saved-clearfix">

				<?php

				// Use gallery shortcode
				echo gallery_shortcode( array(
					'columns'	=> 0, // no row breaks
					'size'		=> 'post-thumbnail',
					'ids'		=> $ids,
				) );

				?>

			</div>

		<?php else : ?>

			<div class="saved-centered-large">

				<p>
					<?php echo esc_html( _x( 'There are no images to show.', 'gallery widget', 'saved' ) ); ?>
				</p>

			</div>

		<?php endif; ?>

	</div>

</section>

<?php

// Reset post data.
wp_reset_postdata();

?>
