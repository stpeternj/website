<?php
/**
 * This is the main template file.
 *
 * All content not using a more specific template comes through this.
 * See content-*.php for different types of content loaded via loop.php.
 *
 * More information: http://codex.wordpress.org/Template_Hierarchy
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Header (header.php)
get_header();

?>

<main id="saved-content"<?php

	// Archive with entries - use contrasting background so white boxes show clearly
	if ( ctfw_has_loop_multiple() ) {
		echo ' class="' . esc_attr( saved_alternating_bg_class( 'contrast' ) ) . '"';
	}

?>>

	<div id="saved-content-inner"<?php if ( ! is_singular() ) : ?> class="saved-centered-large saved-entry-content"<?php endif; ?>>

		<?php
		// loop-header.php shows title, description, etc. for categories, tags, archives, etc. (not used by single posts)
		get_template_part( CTFW_THEME_PARTIAL_DIR . '/loop-header' );
		?>

		<?php
		// loop.php shows single or multiple posts
		get_template_part( 'loop' );
		?>

		<?php
		// loop-author.php shows bio below a blog post
		// (loop-header.php shows the same at top of author archive)
		get_template_part( CTFW_THEME_PARTIAL_DIR . '/loop-author' );
		?>

		<?php
		// loop-navigation.php shows the appropriate navigation at bottom
		get_template_part( CTFW_THEME_PARTIAL_DIR . '/loop-navigation' );
		?>

		<?php
		// comments.php lists comments when enabled (single posts only)
		comments_template();
		?>

	</div>

</main>

<?php get_footer(); // footer.php ?>
