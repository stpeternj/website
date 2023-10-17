<?php
/**
 * Post Header Meta (Full and Short)
 */

// No direct access
if (! defined( 'ABSPATH' )) exit;

// Get data
// $position, $phone, $email, $urls
extract( ctfw_person_data() );

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

		<?php if ($position) : ?>
			<ul class="resurrect-entry-meta">
				<li class="resurrect-person-position resurrect-content-icon">
					<span class="<?php resurrect_icon_class( 'person-position' ); ?>"></span>
					<?php echo esc_html( $position ); ?>
				</li>
			</ul>
		<?php endif; ?>

		<?php if ($phone) : ?>
			<ul class="resurrect-entry-meta">
				<li class="resurrect-person-phone resurrect-content-icon">
					<span class="<?php resurrect_icon_class( 'person-phone' ); ?>"></span>
					<?php echo ctfw_format_phone( $phone ); // escaped, possibly linked ?>
				</li>
			</ul>
		<?php endif; ?>

		<?php if ($email || $urls) : ?>

			<ul class="resurrect-entry-meta">

				<?php if ($email) : ?>
				<li class="resurrect-person-email resurrect-content-icon">
					<span class="<?php resurrect_icon_class( 'person-email' ); ?>"></span>
					<a href="mailto:<?php echo antispambot( $email, true ); ?>"><?php echo antispambot( $email ); ?></a>
				</li>
				<?php endif; ?>

				<?php if ($urls) : ?>
				<li class="resurrect-entry-icons resurrect-person-icons">
					<?php resurrect_social_icons( $urls ); ?>
				</li>
				<?php endif; ?>

			</ul>

		<?php endif; ?>

	</div>

</header>
