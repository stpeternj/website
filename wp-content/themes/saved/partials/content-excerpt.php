<?php
/**
 * Excerpt
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Get and prepare excerpt for output
$content = saved_short_content();

// Have content? If not, don't show empty container
if ( ! $content ) {
	return;
}

?>

<div class="saved-entry-content saved-entry-content-short">
	<?php echo $content; ?>
</div>
