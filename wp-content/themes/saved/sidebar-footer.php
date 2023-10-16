<?php
/**
 * Footer Widget Area
 *
 * This shows three widgets at the bottom of every page.
 */

// Ouput container only if have widgets
if ( ! is_active_sidebar( 'ctcom-footer' ) ) {
	return;
}

// Background class (always secondary on subpages)
$start_secondary = ctfw_is_page_template( 'homepage' ) ? false : true;
$bg_class = saved_alternating_bg_class( 'contrast', $start_secondary );

?>

<div id="saved-footer-widgets-row" class="saved-widgets-row <?php echo esc_attr( $bg_class ); ?>">

	<div class="saved-widgets-row-inner saved-centered-large">

		<div class="saved-widgets-row-content">

			<?php dynamic_sidebar( 'ctcom-footer' ); ?>

		</div>

	</div>

</div>
