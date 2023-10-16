<?php
/**
 * Short Page Content (Archive)
 *
 * This is also the default content template. Any posts without a specific template will use this.
 * It outputs minimal content (title and content) in generic way compatible with any post type.
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<article id="post-<?php the_ID(); ?>" <?php saved_short_post_classes( 'saved-entry-short' ); ?>>

	<?php if ( has_post_thumbnail() ) : ?>

		<div class="saved-entry-short-image saved-hover-image">

			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail(); ?>
			</a>

		</div>

	<?php endif; ?>

	<div class="saved-entry-short-inner">

		<header class="saved-entry-short-header">

			<?php if ( ctfw_has_title() ) : ?>

				<h2 class="saved-entry-short-title">
					<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute( array( 'echo' => false ) ); ?>"><?php the_title(); ?></a>
				</h2>

			<?php endif; ?>

		</header>

		<?php get_template_part( CTFW_THEME_PARTIAL_DIR . '/content-excerpt' ); // show excerpt if no image ?>

	</div>

</article>
