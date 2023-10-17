<?php
/**
 * Load the appropriate sidebar for content being shown.
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Show if exists, has widgets and is not disabled via post/page Layout Options
if ( resurrect_sidebar_enabled() ) : ?>

	<div id="resurrect-sidebar-right" role="complementary">

		<?php do_action( 'resurrect_before_sidebar_widgets' ); ?>

		<?php dynamic_sidebar( resurrect_sidebar_id() ); ?>

		<?php do_action( 'resurrect_after_sidebar_widgets' ); ?>

	</div>

<?php endif; ?>