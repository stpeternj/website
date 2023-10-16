<?php
/**
 * This loops to show one or multiple posts using content-*.php templates.
 *
 * It is used by index.php, saved_loop_after_content() and can be used elsewhere.
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<?php if ( have_posts() && ! is_404() ) : ?>

	<?php if ( ! is_singular() ) : $GLOBALS['saved_loop_multiple'] = true; ?>

		<div id="saved-loop-multiple" class="saved-clearfix saved-loop-entries <?php

			if ( isset( $wp_query->post_count ) ) {

				// Get posts count
				$post_count = $wp_query->post_count;

				// Less columns when there are few posts
				// Example, if only two locations, don't show four columns
				if ( $post_count <= 3 ) {
					echo 'saved-loop-three-columns';
				} else {
					echo 'saved-loop-four-columns';
				}

			}

		?>">

	<?php endif; ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php ctfw_get_content_template(); // load content-*.php according to post type and post format ?>

		<?php endwhile; ?>

	<?php if ( ! is_singular() ) : ?>
		</div>
	<?php endif; ?>

<?php endif; ?>
