<?php
/**
 * Full Post Content (Single)
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Taxonomy Terms
$categories = get_the_category_list(
	/* translators: used between list items, there is a space after the comma */
	__( ', ', 'saved' )
);

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'saved-entry-full saved-blog-full' ); ?>>

	<header class="saved-entry-full-header saved-centered-large">

		<?php
		// This is visible only to screenreaders.
		// Page title is shown in banner. This is for proper HTML5 and Outline
		if ( ctfw_has_title() ) :
		?>

			<h1 id="saved-main-title">
				<?php saved_title_paged(); ?>
			</h1>

		<?php endif; ?>

		<ul class="saved-entry-meta saved-entry-full-meta">

			<li class="saved-entry-full-date">
				<time datetime="<?php echo esc_attr( the_time( 'c' ) ); ?>" class="saved-dark"><?php ctfw_post_date(); ?></time>
			</li>

			<li class="saved-entry-full-author">
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a>
			</li>

			<?php if ( $categories ) : ?>

				<li class="saved-entry-full-category">
					<?php echo $categories; ?>
				</li>

			<?php endif; ?>

		</ul>

	</header>

	<div class="saved-entry-content saved-entry-full-content saved-centered-small">

		<?php the_content(); ?>

		<?php do_action( 'saved_after_content' ); ?>

	</div>

	<?php get_template_part( CTFW_THEME_PARTIAL_DIR . '/content-footer-full' ); // multipage nav, term lists, "Edit" button, etc. ?>

</article>
