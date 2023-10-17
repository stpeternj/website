<?php
/**
 * Highlight Widget Template
 *
 * Produces output for appropriate widget class in framework.
 * $this, $instance (sanitized field values) and $args are available.
 */

// No direct access
if (! defined( 'ABSPATH' )) exit;

// HTML Before
echo $args['before_widget'];

// Title
$title = apply_filters( 'widget_title', $instance['title'] );
if (! empty( $title )) {
	$title = $args['before_title'] . $title . $args['after_title'];
}

// Has valid image?
$has_image = wp_get_attachment_image_src( $instance['image_id'] ) ? true : false;

?>

<div class="resurrect-caption-image resurrect-highlight<?php if (! $has_image) : ?> resurrect-caption-image-no-image<?php endif; ?>">

	<?php if ($instance['click_url']) : ?>
		<a href="<?php echo esc_url( do_shortcode( $instance['click_url'] ) ); ?>"<?php if ($instance['click_new']) : ?> target="_blank" rel="noopener noreferrer"<?php endif; ?>>
	<?php endif; ?>

		<?php if ($has_image) : // valid image specified ?>
			<?php echo wp_get_attachment_image( $instance['image_id'], 'resurrect-rect-large', false, array( 'class' => 'resurrect-image') ); ?>
		<?php else : // use transparent placeholder thumbnail of proper proportion ?>
			<img src="<?php echo apply_filters( 'resurrect_thumb_placeholder_url', CTFW_THEME_URL . '/images/thumb-placeholder.png' ); ?>">
		<?php endif; ?>

		<?php if ($title || $instance['description']) : ?>
			<div class="resurrect-caption-image-caption">
		<?php endif; ?>

			<?php if ($title) : ?>
				<div class="resurrect-caption-image-title">
					<?php echo $title; ?>
				</div>
			<?php endif; ?>

			<?php if ($instance['description']) : ?>
				<div class="resurrect-caption-image-description">
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

<?php

// HTML After
echo $args['after_widget'];
