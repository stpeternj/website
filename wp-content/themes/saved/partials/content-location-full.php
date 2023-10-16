<?php
/**
 * Full Location Content (Single)
 */

// No direct access
if (! defined( 'ABSPATH' )) exit;

// Get data
// $address, $show_directions_link, $directions_url, $phone, $email, $times, $map_lat, $map_lng, $map_has_coordinates, $map_type, $map_zoom
extract( ctfw_location_data() );

// Classes
$classes = '';

// Show meta
// Not showing when have map coordinates because same details are shown in box by map already
if (! $map_has_coordinates && ( $address || $times || $phone || $email || $directions_url )) {
	$show_meta = true;
	$classes = 'saved-entry-has-meta';
} else {
	$show_meta = false;
	$classes = 'saved-entry-no-meta';
}

// Has buttons?
if ($directions_url) {
	$classes .= ' saved-entry-meta-has-buttons';
} else {
	$classes .= ' saved-entry-meta-no-buttons';
}

// Has content?
if (ctfw_has_content()) {
	$classes .= ' saved-entry-has-content';
} else {
	$classes .= ' saved-entry-no-content';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'saved-entry-full saved-location-full ' . $classes ); ?>>

	<?php
	// Load map section (also used on homepage and footer)
	get_template_part( CTFW_THEME_PARTIAL_DIR . '/map-section' );
	?>

	<header class="saved-entry-full-header">

		<?php
		// This is visible only to screenreaders.
		// Page title is shown in banner. This is for proper HTML5 and Outline
		if (ctfw_has_title()) :
		?>

			<h1 id="saved-main-title">
				<?php saved_title_paged(); ?>
			</h1>

		<?php endif; ?>

		<?php if ($show_meta) : ?>

			<ul class="saved-entry-meta saved-entry-full-meta">

				<?php if ($address) : ?>

					<li id="saved-location-address">
						<?php echo nl2br( esc_html( wptexturize( $address ) ) ); ?>
					</li>

				<?php endif; ?>

				<?php if ($times) : ?>

					<li id="saved-location-time">
						<div class="saved-dark"><?php echo nl2br( esc_html( wptexturize( $times ) ) ); ?></div>
					</li>

				<?php endif; ?>

				<?php if ($phone) : ?>

					<li id="saved-location-phone">
						<div class="saved-dark">
							<?php echo ctfw_format_phone( $phone ); // escaped, possibly linked ?>
						</div>
					</li>

				<?php endif; ?>

				<?php if ($email) : ?>

					<li id="saved-location-email">
						<?php echo ctfw_email( $email ); // link with using antispambot() and breaking before @ ?>
					</li>

				<?php endif; ?>

				<?php if ($directions_url) : ?>

					<li class="saved-entry-full-meta-buttons" id="saved-location-buttons">

						<?php if ($directions_url) : ?>

							<a href="<?php echo esc_url( $directions_url ); ?>" target="_blank" rel="noopener noreferrer" id="saved-location-directions-button" class="saved-button">
								<?php echo esc_html( __( 'Directions', 'saved' ) ); ?>
							</a>

						<?php endif; ?>

					</li>

				<?php endif; ?>

			</ul>

		<?php endif; ?>

	</header>

	<?php if (ctfw_has_content()) : // might not be any content, so let header sit flush with bottom ?>

		<div id="saved-location-content" class="saved-entry-content saved-entry-full-content saved-centered-small">

			<?php the_content(); ?>

			<?php do_action( 'saved_after_content' ); ?>

		</div>

	<?php endif; ?>

	<?php get_template_part( CTFW_THEME_PARTIAL_DIR . '/content-footer-full' ); // multipage nav, term lists, "Edit" button, etc. ?>

</article>
