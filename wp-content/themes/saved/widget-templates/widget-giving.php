<?php
/**
 * Giving Widget Template
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
	echo $args['before_title'] . $title . $args['after_title'];
}

?>

<div class="saved-giving-widget">

	<?php if (! empty( $instance['text'] )) :	?>
		<div class="saved-giving-widget-text saved-compact-content">
			<?php echo wpautop( wptexturize( $instance['text'] ) ); ?>
		</div>
	<?php endif; ?>

	<?php
	$button_url = ! empty( $instance['button_url'] ) && 'http://' != $instance['button_url'] ? $instance['button_url'] : '';
	if ($button_url && ! empty( $instance['button_text'] )) :
	?>
		<div class="saved-giving-widget-button">
			<a href="<?php echo esc_url( $button_url ); ?>" target="_blank" rel="noopener noreferrer" class="saved-button saved-button-large"><?php echo esc_html( $instance['button_text'] ); ?></a>
		</div>
	<?php endif; ?>

</div>

<?php

// HTML After
echo $args['after_widget'];
