<?php
/**
 * Full Person Content (Single)
 */

// No direct access
if (! defined( 'ABSPATH' )) exit;

// Get data
// $position, $phone, $email, $urls
extract( ctfw_person_data() );

// Has meta to show?
$has_meta = ( $position || $phone || $email || $urls ) ? true : false;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'saved-entry-full saved-person-full' ); ?>>

	<header class="saved-entry-full-header saved-centered-large">

		<?php
		// This is visible only to screenreaders.
		// Page title is shown in banner. This is for proper HTML5 and Outline
		if (ctfw_has_title()) :
		?>

			<h1 id="saved-main-title">
				<?php saved_title_paged(); ?>
			</h1>

		<?php endif; ?>

		<?php if ($has_meta) : ?>

			<ul class="saved-entry-meta saved-entry-full-meta">

				<?php if ($position) : ?>

					<li id="saved-person-position" class="saved-entry-full-meta-bold">
						<?php echo esc_html( wptexturize( $position ) ); ?>
					</li>

				<?php endif; ?>

				<?php if ($phone) : ?>

					<li id="saved-person-phone">
						<?php echo ctfw_format_phone( $phone ); // escaped, possibly linked ?>
					</li>

				<?php endif; ?>

				<?php if ($email) : ?>

					<li id="saved-person-email">
						<?php echo ctfw_email( $email ); // link with using antispambot() and breaking before @ ?>
					</li>

				<?php endif; ?>

				<?php if ($urls) : ?>

					<li id="saved-person-icons" class="saved-entry-full-icons">
						<?php saved_social_icons( $urls ); ?>
					</li>

				<?php endif; ?>

			</ul>

		<?php endif; ?>

	</header>

	<?php if (ctfw_has_content()) : // might not be any content, so let header sit flush with bottom ?>

		<div id="saved-person-content" class="saved-entry-content saved-entry-full-content saved-centered-small">

			<?php the_content(); ?>

			<?php do_action( 'saved_after_content' ); ?>

		</div>

	<?php endif; ?>

	<?php get_template_part( CTFW_THEME_PARTIAL_DIR . '/content-footer-full' ); // multipage nav, term lists, "Edit" button, etc. ?>

</article>
