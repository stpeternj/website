<?php
/**
 * Full Sermon Content (Single)
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Get sermon data:
// $has_full_text			True if full text of sermon was provided as post content
// $has_download   			Has at least one downloadable file (audio, video or PDF)
// $video_player			Embed code generated from uploaded file, URL for file on other site, page on oEmbed-supported site such as YouTube, or manual embed code (HTML or shortcode)
// $video_download_url 		URL to file with extension (ie. not YouTube). If local, URL changed to force "Save As" via headers.
// $video_extension			File extension for local file (e.g. mp3)
// $video_size				File size for local file (e.g. 10 MB, 980 kB, 2 GB)
// $audio_player			Same as video
// $audio_download_url 		Same as video
// $audio_extension			File extension for local file (e.g. mp3)
// $audio_size				File size for local file (e.g. 10 MB, 980 kB, 2 GB)
// $pdf_download_url 		Same as audio/video
// $pdf_size				File size for local file (e.g. 10 MB, 980 kB, 2 GB)
extract( ctfw_sermon_data() );

// Taxonomy Terms
$speakers = get_the_term_list( $post->ID, 'ctc_sermon_speaker', '', __( ', ', 'saved' ) );
$topics = get_the_term_list( $post->ID, 'ctc_sermon_topic', '', __( ', ', 'saved' ) );
$series = get_the_term_list( $post->ID, 'ctc_sermon_series', '', __( ', ', 'saved' ) );
$books = get_the_term_list( $post->ID, 'ctc_sermon_book', '', __( ', ', 'saved' ) );

// Show buttons if need to switch between video and audio players or have at least one download link
$show_buttons = false;
if ( ( $video_player && $audio_player ) || $has_download ) {
	$show_buttons = true;
}

// Player request (?player=audio or ?player=video)
// Optionally show and scroll to a specific player
$player_request = '';
if (
	isset( $_GET['player'] ) // query string is requesting a specific player
	&& (
		( 'video' == $_GET['player'] && $video_player )		// request is for video player and video player exists
		|| ( 'audio' == $_GET['player'] && $audio_player )	// request is for audio player and audio player exists
	)
) {
	$player_request = $_GET['player'];
}

// Determine which player to show
$show_player = '';
if ( $player_request ) {
	$show_player = $player_request;
} elseif ( $video_player ) {
	$show_player = 'video';
} elseif ( $audio_player ) {
	$show_player = 'audio';
}

// Scroll to player requested, if any
if ( $player_request ) {

	add_action( 'wp_footer', 'saved_sermon_player_scroll' );

	function saved_sermon_player_scroll() {

echo <<< HTML
<script>
jQuery(document).ready(function($) {
	$.smoothScroll({
		scrollTarget: '#saved-sermon-media',
		offset: -110, // consider top bar height
		easing: 'swing',
		speed: 800
	});
});
</script>
HTML;

	}

}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'saved-entry-full saved-sermon-full' ); ?>>

	<header class="saved-entry-full-header saved-centered-large">

		<?php
		// This is visible only to screenreaders.
		// Page title is shown in banner. This is for proper HTML5 and Outline
		if ( ctfw_has_title() ) :
		?>

			<h1 id="saved-main-title">
				<?php saved_title_paged(); ?>
			</h1>

		<?php endif; ?>

		<ul class="saved-entry-meta saved-entry-full-meta">

			<li id="saved-sermon-date" class="saved-entry-full-date">
				<?php /* <div class="saved-entry-full-meta-label"><?php _ex( 'Date', 'sermon meta label', 'saved' ); ?></div> */ ?>
				<time datetime="<?php echo esc_attr( the_time( 'c' ) ); ?>" class="saved-dark"><?php ctfw_post_date(); ?></time>
			</li>

			<?php if ( $speakers ) : ?>

				<li id="saved-sermon-speaker">
					<?php /* <div class="saved-entry-full-meta-label"><?php _ex( 'Speaker', 'sermon meta label', 'saved' ); ?></div> */ ?>
					<?php echo $speakers; ?>
				</li>

			<?php endif; ?>

			<?php if ( $topics ) : ?>

				<li id="saved-sermon-topic">
					<?php /* <div class="saved-entry-full-meta-label"><?php _ex( 'Topic', 'sermon meta label', 'saved' ); ?></div> */ ?>
					<?php echo $topics; ?>
				</li>

			<?php endif; ?>

			<?php if ( $series ) : ?>

				<li id="saved-sermon-series">
					<?php /* <div class="saved-entry-full-meta-label"><?php _ex( 'Series', 'sermon meta label', 'saved' ); ?></div> */ ?>
					<?php echo $series; ?>
				</li>

			<?php endif; ?>

			<?php if ( $books ) : ?>

				<li id="saved-sermon-book">
					<?php /* <div class="saved-entry-full-meta-label"><?php _ex( 'Book', 'sermon meta label', 'saved' ); ?></div> */ ?>
					<?php echo $books; ?>
				</li>

			<?php endif; ?>

		</ul>

	</header>

	<?php
	// Show media player and buttons only if post is not password protected
	if ( ( $show_player || $show_buttons ) && ! post_password_required() ) :
	?>

		<div id="saved-sermon-media" class="saved-centered-medium">

			<?php
			// Show player if have video or audio player
			if ( $show_player ) : ?>

				<div id="saved-sermon-player">

					<?php if ( 'video' == $show_player ) : ?>

						<div id="saved-sermon-video-player">
							<?php echo $video_player; ?>
						</div>

					<?php endif; ?>

					<?php if ( 'audio' == $show_player ) : ?>

						<div id="saved-sermon-audio-player">
							<?php echo $audio_player ?>
						</div>

					<?php endif; ?>

				</div>

			<?php endif; ?>

			<?php
			// Show buttons if need to switch between video and audio players or have at least one download link
			if ( $show_buttons ) :
			?>

				<ul id="saved-sermon-buttons" class="saved-buttons-list">

					<?php

					// Make sure there is no whitespace between items since they are inline-block

					if ( $video_player && $audio_player ) : // have video player and audio player to switch between
						?><li id="saved-sermon-video-player-button">
							<a href="<?php echo esc_url( add_query_arg( 'player', 'video' ) ); ?>"<?php if ( 'video' != $show_player ) : ?> class="saved-button-light"<?php endif; ?>>
								<span class="<?php saved_icon_class( 'video-watch' ); ?>"></span>
								<?php _ex( 'Watch', 'single sermon button', 'saved' ); ?>
							</a>
						</li><?php
					endif;

					if ( $audio_player && $video_player ) : // have audio player and video player to switch between
						?><li id="saved-sermon-audio-player-button">
							<a href="<?php echo esc_url( add_query_arg( 'player', 'audio' ) ); ?>"<?php if ( 'audio' != $show_player ) : ?> class="saved-button-light"<?php endif; ?>>
								<span class="<?php saved_icon_class( 'audio-listen' ); ?>"></span>
								<?php _ex( 'Listen', 'single sermon button', 'saved' ); ?>
							</a>
						</li><?php
					endif;

					if ( $has_full_text ) : // have article text
						?><li id="saved-sermon-read-button">
							<a href="#" class="saved-button-light">
								<span class="<?php saved_icon_class( 'sermon-read' ); ?>"></span>
								<?php _ex( 'Read', 'single sermon button', 'saved' ); ?>
							</a>
						</li><?php
					endif;

					if ( $has_download ) :
						?><li id="saved-sermon-download-button">
							<a href="#" class="saved-button-light">
								<span class="<?php saved_icon_class( 'download' ); ?>"></span>
								<?php _ex( 'Save', 'single sermon button', 'saved' ); ?>
							</a>
						</li><?php
					endif;

					?>

				</ul>

			<?php endif; ?>

		</div>

	<?php endif; ?>

	<?php if ( ctfw_has_content() || ctfw_has_excerpt() ) : ?>

		<div id="saved-sermon-content" class="saved-entry-content saved-entry-full-content saved-centered-small">

			<?php the_content(); ?>

			<?php do_action( 'saved_after_content' ); ?>

		</div>

	<?php endif; ?>

	<?php get_template_part( CTFW_THEME_PARTIAL_DIR . '/content-footer-full' ); // multipage nav, term lists, "Edit" button, etc. ?>

</article>

<?php if ( $has_download ) : ?>

	<div id="saved-sermon-download-dropdown" class="jq-dropdown">

  		<div class="jq-dropdown-panel">

	  		<ul>

		  		<?php if ( $video_download_url ) : ?>

		  			<li>

						<span class="<?php saved_icon_class( 'video-download' ); ?>"></span>

						<a href="<?php echo esc_url( $video_download_url ); ?>" download>
							<?php
							printf(
								/* translators: %s is file type (e.g. MP3) */
								_x( 'Video (%s)', 'save link', 'saved' ),
								strtoupper( $video_extension )
							);
							?>
						</a>

						<?php if ( $video_size ) : ?>
							<span class="saved-sermon-download-dropdown-filesize"><?php echo $video_size; ?></span>
						<?php endif; ?>

					</li>

				<?php endif; ?>

		  		<?php if ( $audio_download_url ) : ?>

		  			<li>

						<span class="<?php saved_icon_class( 'audio-download' ); ?>"></span>

						<a href="<?php echo esc_url( $audio_download_url ); ?>" download>
							<?php
							printf(
								/* translators: %s is file type (e.g. MP3) */
								_x( 'Audio (%s)', 'save link', 'saved' ),
								strtoupper( $audio_extension )
							);
							?>
						</a>

						<?php if ( $audio_size ) : ?>
							<span class="saved-sermon-download-dropdown-filesize"><?php echo $audio_size; ?></span>
						<?php endif; ?>

					</li>

				<?php endif; ?>

		  		<?php if ( $pdf_download_url ) : ?>

		  			<li>

						<span class="<?php saved_icon_class( 'pdf-download' ); ?>"></span>

						<a href="<?php echo esc_url( $pdf_download_url ); ?>" download>
							<?php _ex( 'PDF', 'save link', 'saved' ); ?>
						</a>

						<?php if ( $pdf_size ) : ?>
							<span class="saved-sermon-download-dropdown-filesize"><?php echo $pdf_size; ?></span>
						<?php endif; ?>

					</li>

				<?php endif; ?>

			</ul>

		</div>

	</div>

<?php endif; ?>
