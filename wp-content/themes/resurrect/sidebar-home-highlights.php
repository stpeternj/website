<?php
/**
 * Homepage Highlights "Sidebar"
 * Intended for use with the CT Highlight widget.
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<?php if ( is_active_sidebar( 'ctcom-home-highlights' ) ) : ?>

	<div id="ctcom-home-highlights">

		<?php dynamic_sidebar( 'ctcom-home-highlights' ); ?>

	</div>

<?php endif; ?>