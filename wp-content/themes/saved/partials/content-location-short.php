<?php
/**
 * Short Location Content (Archive)
 */

// No direct access
if (! defined( 'ABSPATH' )) exit;

// Get data
// $address, $show_directions_link, $directions_url, $phone, $email, $times, $map_lat, $map_lng, $map_has_coordinates, $map_type, $map_zoom
extract( ctfw_location_data() );

?>

<article id="post-<?php the_ID(); ?>" <?php saved_short_post_classes( 'saved-location-short' ); ?>>

	<?php if (has_post_thumbnail()) : ?>

		<div class="saved-entry-short-image saved-hover-image">

			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail(); ?>
			</a>

		</div>

	<?php endif; ?>

	<div class="saved-entry-short-inner">

		<header class="saved-entry-short-header">

			<?php if (ctfw_has_title()) : ?>

				<h2 class="saved-entry-short-title">
					<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute( array( 'echo' => false ) ); ?>"><?php the_title(); ?></a>
				</h2>

			<?php endif; ?>

			<?php if ($address) : ?>

				<ul class="saved-entry-meta saved-entry-short-meta">

					<?php if ($address) : ?>

						<li class="saved-location-short-address">
							<?php echo ctfw_address_one_line( $address ); ?>
						</li>

					<?php endif; ?>

					<?php /* keep minimal

					<?php if ( $phone ) : ?>

						<li class="saved-location-short-phone">
							<?php echo ctfw_format_phone( $phone ); // escaped, possibly linked ?>
						</li>

					<?php endif; ?>

					<?php if ( $email ) : ?>

						<li class="saved-location-short-email">
							<?php echo ctfw_email( $email ); // link with using antispambot() and breaking before @ ?>
						</li>

					<?php endif; ?>

					*/ ?>

				</ul>

			<?php endif; ?>

		</header>

		<?php get_template_part( CTFW_THEME_PARTIAL_DIR . '/content-excerpt' ); // show excerpt if no image ?>

	</div>

</article>
