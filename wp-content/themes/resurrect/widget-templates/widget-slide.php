<?php
/**
 * Slide Widget Template
 *
 * Produces output for appropriate widget class in framework.
 * $this, $instance (sanitized field values) and $args are available.
 */

// No direct access
if (! defined( 'ABSPATH' )) exit;

// Slide has valid image
if (wp_get_attachment_image_src( $instance['image_id'] )) :

	$video_url = $instance['video'];

?>

	<li<?php

		$li_classes = array();

		if ($video_url) {
			$li_classes[] = 'resurrect-slide-video';
		}

		if ($instance['click_url']) {
			$li_classes[] = 'resurrect-slide-linked';
		}

		if ($instance['click_new']) {
			$li_classes[] = 'resurrect-slide-click-new'; // for JavaScript
		}

		if (! $instance['description']) {
			$li_classes[] = 'resurrect-slide-no-description';
		}

		if (! empty( $li_classes )) {
			echo ' class="' . implode( ' ', $li_classes ) . '"';
		}

	?>>

		<div class="flex-image-container">

			<?php if ($instance['click_url'] || $video_url) : // image is linked ?>
				<a href="<?php echo esc_url( do_shortcode( $video_url ? $video_url : $instance['click_url'] ) ); // use video URL if is video slide ?>"<?php if ($instance['click_new']) : ?> target="_blank" rel="noopener noreferrer"<?php endif; ?>>
			<?php endif; ?>

				<?php echo wp_get_attachment_image( $instance['image_id'], 'resurrect-slide', false, array( 'alt' => '', 'title' => '', 'class' => '' ) ); ?>

				<?php if ($video_url) : // show play button hover overlay for video slide ?>
					<div class="flex-play-overlay"></div>
				<?php endif; ?>

			<?php if ($instance['click_url'] || $video_url) : // image is linked ?>
				</a>
			<?php endif; ?>

		</div>

		<?php if ($instance['title'] || $instance['description']) : // title or description provided ?>

			<div class="flex-caption">

				<?php if ($instance['title']) : // title provided ?>

					<?php if ($instance['click_url']) : // slide is linked ?>

						<a href="<?php echo do_shortcode( $instance['click_url'] ); ?>" class="flex-title"<?php if ($instance['click_new']) : ?> target="_blank" rel="noopener noreferrer"<?php endif; ?>>
							<?php echo force_balance_tags( $instance['title'] ); ?>
						</a>

					<?php else : // slide not linked ?>

						<div class="flex-title"><?php echo force_balance_tags( $instance['title'] ); // auto-close <b> tag to prevent messing up whole page ?></div>

					<?php endif; ?>

				<?php endif; ?>

				<?php if ($instance['description']) : // description provided ?>
					<div class="flex-description"><?php echo force_balance_tags( $instance['description'] ); // auto-close <b> tag to prevent messing up whole page ?></div>
				<?php endif; ?>

			</div>

		<?php endif; ?>

	</li>

<?php

endif;
