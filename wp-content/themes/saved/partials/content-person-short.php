<?php
/**
 * Short Person Content (Archive)
 */

// No direct access
if (! defined( 'ABSPATH' )) exit;

// Get data
// $position, $phone, $email, $urls
extract( ctfw_person_data() );

// Less meta if using widget on homepage
if (ctfw_is_sidebar( 'ctcom-home' )) {
	$email = '';
}

// Meta
$show_meta = $phone || $email || $urls ? true : false;

?>

<article id="post-<?php the_ID(); ?>" <?php saved_short_post_classes( 'saved-person-short' ); ?>>

	<?php if ($position && ! has_post_thumbnail()) : ?>

		<div class="saved-person-short-position saved-entry-short-label">
			<?php echo esc_html( wptexturize( $position ) ); ?>
		</div>

	<?php endif; ?>

	<?php if (has_post_thumbnail()) : ?>

		<div class="saved-entry-short-image saved-hover-image">

			<?php if ($position) : ?>

				<div class="saved-person-short-position saved-entry-short-label">
					<?php echo esc_html( wptexturize( $position ) ); ?>
				</div>

			<?php endif; ?>

			<?php if (! ctfw_has_content()) : // not linked if no content ?>

				<?php the_post_thumbnail(); ?>

			<?php else : ?>

				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
					<?php the_post_thumbnail(); ?>
				</a>

			<?php endif; ?>

		</div>

	<?php endif; ?>

	<div class="saved-entry-short-inner">

		<header class="saved-entry-short-header">

			<?php if (ctfw_has_title()) : ?>

				<h2 class="saved-entry-short-title">

					<?php if (! ctfw_has_content()) : // not linked if no content ?>

						<?php the_title(); ?>

					<?php else : ?>

						<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute( array( 'echo' => false ) ); ?>"><?php the_title(); ?></a>

					<?php endif; ?>

				</h2>

			<?php endif; ?>

			<?php if ($show_meta) : ?>

				<ul class="saved-entry-meta saved-entry-short-meta">

					<?php if ($phone) : ?>

						<li class="saved-person-short-phone">
							<?php echo ctfw_format_phone( $phone ); // escaped, possibly linked ?>
						</li>

					<?php endif; ?>

					<?php if ($email) : ?>

						<li class="saved-person-short-email">
							<?php echo ctfw_email( $email ); // link with using antispambot() and breaking before @ ?>
						</li>

					<?php endif; ?>

					<?php if ($urls) : ?>

						<li class="saved-person-short-icons saved-entry-short-icons">
							<?php saved_social_icons( $urls ); ?>
						</li>

					<?php endif; ?>

				</ul>

			<?php endif; ?>

		</header>

		<?php get_template_part( CTFW_THEME_PARTIAL_DIR . '/content-excerpt' ); // show excerpt if no image ?>

	</div>

</article>
