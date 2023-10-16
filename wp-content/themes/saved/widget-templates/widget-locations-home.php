<?php
/**
 * Locations Widget Template (Homepage)
 *
 * Produces output for appropriate widget class in framework.
 * $this, $instance (sanitized field values) and $args are available.
 *
 * $this->ctfw_get_posts() can be used to produce a query according to widget field values.
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Tell map-section.php this is loaded via CT Locations widget on Homepage
$GLOBALS['saved_home_locations_widget'] = true;

// Load map section (also used in footer on sub-pages)
get_template_part( CTFW_THEME_PARTIAL_DIR . '/map-section' );
