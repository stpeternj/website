<?php
/**
 * Template Name: Homepage
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Header
get_header();

// Start loop
while ( have_posts() ) : the_post();

// Show widgets
get_sidebar( 'home' );

// End loop
endwhile;

// Footer
get_footer();