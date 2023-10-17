<?php
/**
 * Homepage Bottom Widgets "Sidebar"
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<?php if ( is_active_sidebar( 'ctcom-home-bottom' ) ) : ?>

	<div id="resurrect-home-bottom-widgets">

		<?php dynamic_sidebar( 'ctcom-home-bottom' ); ?>

	</div>

<?php endif; ?>