<?php
/**
 * Template Name: Sermon Speakers
 *
 * This shows a page with sermon speakers.
 *
 * content.php outputs the page content.
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Prepare sermon speakers to output after page content
function resurrect_sermon_speakers_after_content() {

	// Get speakers
	$speakers = wp_list_categories( array(
		'taxonomy' => 'ctc_sermon_speaker',
		'hierarchical' => false,
		'show_count' => true,
		'title_li' => '',
		'echo' => false,
	) );

	?>

	<div id="resurrect-sermon-speakers" class="resurrect-sermon-index<?php if ( ctfw_has_content() ) : ?> resurrect-sermon-index-has-content<?php endif; ?>">

		<?php
		// Buttons for switching between indexes
		get_template_part( 'sermon-index-header' );
		?>

		<?php if ( $speakers ) : ?>

			<ul id="resurrect-sermon-speakers-list" class="resurrect-list resurrect-sermon-index-list resurrect-sermon-index-list-three-columns">
				<?php echo $speakers; ?>
			</ul>

		<?php else : ?>

			<p id="resurrect-sermon-index-none">
				<?php _e( 'There are no speakers to show.', 'resurrect' ); ?>
			</p>

		<?php endif; ?>

	</div>

	<?php

}

// Insert content after the_content() in content.php
add_action( 'resurrect_after_content', 'resurrect_sermon_speakers_after_content' );

// Load main template to show the page
locate_template( 'index.php', true );