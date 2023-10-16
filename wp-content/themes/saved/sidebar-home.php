<?php
/**
 * Homepage Widget Area
 *
 * This shows widgets on the homepage.
 */

global $saved_close_final_home_multiple_section;

?>

<main id="saved-home-main">

	<?php if ( is_active_sidebar( 'ctcom-home' ) ) : ?>

		<?php dynamic_sidebar( 'ctcom-home' ); ?>

		<?php
		// Highlights and Secondary Widgets containers needs to be closed here when used as last section on homepage.
		// See saved_close_final_home_multiple_section() for how the global is set.
		if ( isset( $saved_close_final_home_multiple_section ) ) {
			echo $saved_close_final_home_multiple_section;
		}
		?>

	<?php else : ?>

		<section class="saved-first-home-widget saved-bg-section saved-viewport-height-40 saved-color-main-bg saved-section-has-title saved-section-has-content saved-section-no-image">

			<div class="saved-bg-section-inner">

				<div class="saved-bg-section-content">

					<h1>
						<?php esc_html_e( 'Add Widgets', 'saved' ); ?>
					</h1>

					<p>
						<?php _e( 'Import sample widgets or go to <b>Appearance</b> > <b>Customize</b> > <b>Widgets</b> to add widgets to your homepage.', 'saved' ); ?>
					</p>

				</div>

			</div>

		</section>

	<?php endif; ?>

</main>
