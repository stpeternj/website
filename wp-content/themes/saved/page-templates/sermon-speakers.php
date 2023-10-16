<?php
/**
 * Template Name: Sermon Speakers
 *
 * This shows a page with sermon speakers.
 *
 * partials/content-full.php outputs the page content.
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Prepare sermon speakers to output after page content
function saved_sermon_speakers_after_content() {

	// Get speakers
	$speakers = wp_list_categories( array(
		'taxonomy' => 'ctc_sermon_speaker',
		'hierarchical' => false,
		'show_count' => true,
		'title_li' => '',
		'echo' => false,
	) );

	?>

	<div id="saved-sermon-speakers" class="saved-sermon-index">

		<?php
		// Buttons for switching between indexes
		get_template_part( CTFW_THEME_PARTIAL_DIR . '/sermon-archive-buttons' );
		?>

		<?php if ( $speakers ) : ?>

			<ul id="saved-sermon-speakers-list" class="saved-sermon-index-list saved-sermon-index-list-three-columns">
				<?php echo $speakers; ?>
			</ul>

		<?php else : ?>

			<p id="saved-sermon-index-none">
				<?php _e( 'There are no speakers to show.', 'saved' ); ?>
			</p>

		<?php endif; ?>

	</div>

	<?php

}

// Insert content after the_content() in content.php
add_action( 'saved_after_content', 'saved_sermon_speakers_after_content' );

// Load main template to show the page
locate_template( 'index.php', true );
