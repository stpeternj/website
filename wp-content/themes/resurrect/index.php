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

get_header(); // header.php ?>

<div id="resurrect-content" class="<?php echo resurrect_sidebar_enabled() ? 'resurrect-has-sidebar' : 'resurrect-no-sidebar'; ?>">

	<div id="resurrect-content-inner">

		<?php resurrect_breadcrumbs( 'content' ); ?>

		<div class="resurrect-content-block resurrect-content-block-close resurrect-clearfix">

			<?php
			// loop-header.php shows title, description, etc. for categories, tags, archives, etc. (not used by single posts)
			get_template_part( 'loop-header' );
			?>

			<?php
			// loop.php shows single or multiple posts
			get_template_part( 'loop' );
			?>

		</div>

		<?php
		// author-box.php shows bio below blog posts and author archives
		get_template_part( 'loop-author' );
		?>

		<?php
		// loop-navigation.php shows the appropriate navigation at bottom
		get_template_part( 'loop-navigation' );
		?>

		<?php
		// comments.php lists comments when enabled (single posts only)
		comments_template();
		?>

	</div>

</div>

<?php get_sidebar(); // load sidebar.php to show appropriate sidebar ?>

<?php get_footer(); // footer.php ?>