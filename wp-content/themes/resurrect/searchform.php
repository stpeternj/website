<?php
/**
 * Search form
 *
 * Provides contents of get_search_form() for the search widget
 */

// No direct access
if (! defined( 'ABSPATH' )) exit;

?>

<div class="resurrect-search-form">
	<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label class="screen-reader-text"><?php _e( 'Search', 'resurrect' ); ?></label>
		<div class="resurrect-search-field">
			<input type="text" name="s" aria-label="<?php esc_attr_e( 'Search', 'resurrect' ); ?>">
		</div>
		<a href="#" class="resurrect-search-button <?php resurrect_icon_class( 'search-button' ); ?>" title="<?php echo esc_attr(_x('Search', 'search icon', 'resurrect')); ?>"></a>
	</form>
</div>
