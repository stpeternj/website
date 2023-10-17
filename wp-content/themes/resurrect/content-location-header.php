<?php
/**
 * Post Header Meta (Full and Short)
 */

// No direct access
if (! defined( 'ABSPATH' )) exit;

// Get data
// $address, $show_directions_link, $directions_url, $phone, $email, $times, $map_lat, $map_lng, $map_type, $map_zoom
extract( ctfw_location_data() );

?>

<header class="resurrect-entry-header resurrect-clearfix">

	<?php if (has_post_thumbnail()) : ?>
		<div class="resurrect-entry-image">
			<?php resurrect_post_image(); ?>
		</div>
	<?php endif; ?>

	<div class="resurrect-entry-title-meta">

		<?php if (ctfw_has_title()) : ?>
			<h1 class="resurrect-entry-title<?php if (is_singular( get_post_type() )) : ?> resurrect-main-title<?php endif; ?>">
				<?php resurrect_post_title(); // will be linked on short ?>
			</h1>
		<?php endif; ?>

		<ul class="resurrect-entry-meta">

			<?php if ($address) : ?>
				<li class="resurrect-location-address resurrect-content-icon">
					<span class="<?php resurrect_icon_class( 'location-address' ); ?>"></span>
					<?php echo nl2br( wptexturize( $address ) ); ?>
				</li>
			<?php endif; ?>

			<?php if ($times) : ?>
				<li class="resurrect-location-times resurrect-content-icon">
					<span class="<?php resurrect_icon_class( 'location-times' ); ?>"></span>
					<?php echo nl2br( wptexturize( $times ) ); ?>
				</li>
			<?php endif; ?>

			<?php if ($phone) : ?>
				<li class="resurrect-location-phone resurrect-content-icon">
					<span class="<?php resurrect_icon_class( 'location-phone' ); ?>"></span>
					<?php echo ctfw_format_phone( $phone ); // escaped, possibly linked ?>
				</li>
			<?php endif; ?>

			<?php if ($email) : ?>
				<li class="resurrect-location-email resurrect-content-icon">
					<span class="<?php resurrect_icon_class( 'location-email' ); ?>"></span>
					<a href="mailto:<?php echo antispambot( $email, true ); ?>">
						<?php echo antispambot( $email ); // this on own line or validation can fail ?>
					</a>
				</li>
			<?php endif; ?>

		</ul>

	</div>

</header>
