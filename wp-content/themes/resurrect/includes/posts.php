<?php
/**
 * Post Functions
 *
 * These relate to posts in general -- all types.
 *
 * @package    Resurrect
 * @subpackage Functions
 * @copyright  Copyright (c) 2016, ChurchThemes.com
 * @link       https://github.com/churchthemes/church-theme-framework
 * @license    GPLv2 or later
 * @since      2.0
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/*******************************************
 * EXCERPTS
 *******************************************/

/**
 * Replace excerpt's [...] with ...
 *
 * @since 2.0
 */
function resurrect_excerpt_more( $more ) {

    return '&hellip;';

}

add_filter( 'excerpt_more', 'resurrect_excerpt_more' );
