<?php
/**
 * Page content for:
 *
 * 1. Full / Single
 * 2. Short / Multiple
 *
 * This is also the default content template. Any posts without a specific template will use this.
 * It outputs minimal content (title and content) in generic way compatible with any post type.
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/*************************************
 * 1. FULL / SINGLE
 *************************************/

/**
 * Custom page templates can use this template to insert a loop after the content.
 * For example, the Sermons page template can loop sermons after the content.
 *
 * 		// Query specific posts to loop
 * 		function resurrect_template_name_loop_after_content() { // template_name being something like 'sermons'
 * 	 		return new WP_Query();
 *    	}
 *
 *		// Make query available via filter
 *		add_filter( 'resurrect_loop_after_content_query', 'resurrect_template_name_loop_after_content' );
 *
 *		// Load main template to show the page
 *		locate_template( 'index.php', true );
 *
 * Other content can similarly be shown in this way via a custom page template:
 *
 * 		// Custom content output
 * 		function resurrect_template_name_after_content() { // template_name being something like 'sermons'
 * 			echo 'whatever';
 * 		}
 *
 * 		// Make content available via action
 *		add_action( 'resurrect_after_content', 'resurrect_template_name_after_content' );
 *
 *		// Load main template to show the page
 *		locate_template( 'index.php', true );
 */

if ( is_singular( get_post_type() ) ) :

?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'resurrect-entry-full' ); ?>>

		<?php if ( ctfw_has_title() && ! resurrect_hide_page_title() ) : // do not repeat title if already shown via header-banner.php ?>
			<h1 class="resurrect-entry-title resurrect-main-title"><?php resurrect_title_paged(); // show with (Page #) if multipage ?></h1>
		<?php endif; ?>

		<div class="resurrect-entry-content resurrect-clearfix">

			<?php the_content(); ?>

			<?php do_action( 'resurrect_after_content' ); ?>

		</div>

		<?php get_template_part( 'content-footer-full' ); // multipage nav, taxonomy terms, "Edit" button, etc. ?>

	</article>

<?php

/*************************************
 * 2. SHORT / MULTIPLE
 *************************************/

else :

?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'resurrect-entry-short' ); ?>>

		<h1 class="resurrect-entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>

		<?php if ( ctfw_has_excerpt() || ctfw_has_more_tag() ) : ?>
			<div class="resurrect-entry-content resurrect-clearfix">
				<?php resurrect_short_content(); // output excerpt or post content up until <!--more--> quicktag used ?>
			</div>
		<?php endif; ?>

		<?php get_template_part( 'content-footer-short' ); // show appropriate button(s) ?>

	</article>

<?php endif; ?>