<?php
/**
 * Search form
 *
 * Provides contents of get_search_form() for the search widget
 */

// No direct access
if (! defined( 'ABSPATH' )) exit;

?>

<div class="saved-search-form">

	<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">

		<label class="screen-reader-text"><?php esc_html_e( 'Search', 'saved' ); ?></label>

		<div class="saved-search-field">
			<input type="text" name="s" aria-label="<?php esc_attr_e( 'Search', 'saved' ); ?>">
		</div>

		<?php /* Note: submiting via onClick instead of in main.js to solve issue with submit failing on mobile menu */ ?>
		<a href="#" onClick="jQuery( this ).parent( 'form' ).trigger('submit'); return false;" class="saved-search-button <?php saved_icon_class( 'search-button' ); ?>" title="<?php echo esc_attr(_x('Search', 'search icon', 'saved')); ?>"></a>

	</form>

</div>
