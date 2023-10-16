<?php
/**
 * Sermon Archive Buttons
 *
 * Buttons for sermon indexes, if available (Topics, Series, Books, etc.)
 * Use at top of sermon indexes and on CT Sermons widget on homepage.
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Is this homepage or an index page?
$is_homepage = ctfw_is_page_template( 'homepage' );

// Sermon Archive Data
$archives = ctfw_content_type_archives( array(
	'content_type' => 'sermon', // since homepage won't auto-detect this
) );

// Archive Meta
$archives_meta = array(
	'ctc_sermon_topic' => array(
		'page_template'	=> 'sermon-topics.php',
		'icon'			=> 'sermon-topic',
	),
	'ctc_sermon_series' => array(
		'page_template'	=> 'sermon-series.php',
		'icon'			=> 'sermon-series',
	),
	'ctc_sermon_book' => array(
		'page_template'	=> 'sermon-books.php',
		'icon'			=> 'sermon-book',
	),
	'ctc_sermon_speaker' => array(
		'page_template'	=> 'sermon-speakers.php',
		'icon'			=> 'sermon-speaker',
	),
	'months' => array(
		'page_template'	=> 'sermon-dates.php',
		'icon'			=> 'sermon-date',
		'name'			=> _x( 'Dates', 'sermon archives', 'saved' ), // override
	),
);

// Build Buttons
$buttons = array();
foreach ( $archives as $archive_key => $archive ) {

	// Get page template and icon
	$archive_meta = $archives_meta[$archive_key];

	// Does page with proper template exist?
	$url = ctfw_get_page_url_by_template( $archive_meta['page_template'] );
	if ( ! $url ) {
		continue;
	}

	// Is there at least one tax term to show?
	if ( empty( $archive['items']) ) {
		continue;
	}

	// Prepare button
	$buttons[$archive_key] = array(
		'text'		=> isset( $archive_meta['name'] ) ? $archive_meta['name'] : $archive['name'],
		'icon'		=> isset( $archive_meta['icon'] ) ? $archive_meta['icon'] : $archive_meta['icon'],
		'url'		=> $url,
		'selected'	=> ctfw_is_page_template( $archive_meta['page_template'] ),
	);

}

// Don't show if only one button on an index page (okay on homepage)
if ( count( $buttons ) < 2 && ! $is_homepage ) {
	return;
}

?>

<?php if ( $is_homepage ) : ?>

	<div class="saved-image-section-buttons">

<?php else : ?>

	<div id="saved-sermon-index-header">

<?php endif; ?>

	<ul class="saved-buttons-list">

		<?php

		// Main archive button for homepage
		// Make sure there is no whitespace between items since they are inline-block
		if ( $is_homepage ) :

			// Get sermon archive URL
			$sermons_url =  ctfw_post_type_archive_url( 'ctc_sermon' );
			if ( $sermons_url ) :

				?><li>
					<a href="<?php echo esc_url( $sermons_url ); ?>">
						<?php
							esc_html( printf(
								/* translators: %1$s is "Sermons", possibly translated or changed by settings */
								_x( 'All %1$s', 'homepage sermon buttons', 'saved' ),
								ctfw_sermon_word_plural()
							) );
						?>
					</a>
				</li><?php

			endif;

		endif;

		?>

		<?php

		// Loop buttons
		// Make sure there is no whitespace between items since they are inline-block
		foreach ( $buttons as $key => $button ) :

			// No "Dates" on homepage, too long
			if ( $is_homepage && 'months' == $key ) {
				continue;
			}

			?><li>

				<a href="<?php echo esc_url( $button['url'] ); ?>"<?php if ( ! $button['selected'] ) : ?> class="saved-button-light"<?php endif; ?>>

					<?php if ( ! $is_homepage ) : ?>
						<span class="<?php saved_icon_class( $button['icon'] ); ?>"></span>
					<?php endif; ?>

					<?php echo esc_html( $button['text'] ); ?>

				</a>

			</li><?php

		endforeach;

		?>

	</ul>

</div>
