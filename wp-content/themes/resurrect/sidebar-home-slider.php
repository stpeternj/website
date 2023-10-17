<?php
/**
 * Homepage Slider "Sidebar"
 * Intended for use by the CT Slide widget.
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<?php if ( is_active_sidebar( 'ctcom-home-slider' ) ) : ?>

	<div id="resurrect-slider">

		<div id="resurrect-slider-inner">

			<div class="flexslider">

				<ul class="slides">

					<?php dynamic_sidebar( 'ctcom-home-slider' ); ?>

				</ul>

			</div>

		</div>

	</div>

<?php endif; ?>