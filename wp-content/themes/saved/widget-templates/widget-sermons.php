<?php
/**
 * Sermons Widget Template
 *
 * Produces output for appropriate widget class in framework.
 * $this, $instance (sanitized field values) and $args are available.
 *
 * $this->ctfw_get_posts() can be used to produce a query according to widget field values.
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// HTML Before
echo $args['before_widget'];

// Title
$title = apply_filters( 'widget_title', $instance['title'] );
if ( ! empty( $title ) ) {
	echo $args['before_title'] . $title . $args['after_title'];
}

// Get posts
$posts = $this->ctfw_get_posts(); // widget's default query according to field values

// Loop Posts
foreach ( $posts as $post ) : setup_postdata( $post );

	// Get sermon data:
	// $has_full_text			True if full text of sermon was provided as post content
	// $has_download   			Has at least one download (audio, video or PDF)
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

	// Show content
	$show_image = $instance['show_image'] && has_post_thumbnail() ? true : false;
	$show_title = ctfw_has_title();
	$show_image_date = $instance['show_date'] && $show_image ? true : false;
	$show_meta_date = $instance['show_date'] && ! $show_image ? true : false;
	$show_speakers = $instance['show_speaker'] && $speakers ? true : false;
	$show_topics = $instance['show_topic'] && $topics ? true : false;
	$show_books = $instance['show_book'] && $books ? true : false;
	$show_series = $instance['show_series'] && $series ? true : false;
	$show_video_icon = $video_player || $video_download_url ? true : false;
	$show_audio_icon = $audio_player || $audio_download_url ? true : false;
	$show_icons = $instance['show_media_types'] && ( $has_full_text || $show_video_icon || $show_audio_icon || $pdf_download_url ) ? true : false;
	$show_meta = ( $show_meta_date || $show_speakers || $show_topics || $show_books || $show_series || $show_icons ) ? true : false;
	$show_excerpt = get_the_excerpt() && $instance['show_excerpt'] ? true : false;

	// Classes
	$classes = 'saved-post-compact';

		$classes .= ' ' . saved_widget_image_side_class();

		if ( $show_excerpt ) {
			$classes .= ' saved-entry-has-excerpt';
		}

?>

	<article <?php saved_compact_post_classes( array(
		'classes'			=> $classes,
		'widget_instance'	=> $instance,
	) ); ?>>

		<div class="saved-entry-compact-header">

			<?php if ( $show_image ) : ?>

				<div class="saved-entry-compact-image saved-hover-image">

					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<?php the_post_thumbnail( 'saved-rect-small' ); ?>
					</a>

					<?php if ( $show_image_date ) : ?>

						<time datetime="<?php echo esc_attr( the_time( 'c' ) ); ?>">

							<?php
							ctfw_post_date( array(
								'abbreviate_date' => true, // abbreviate_month, remove_year both true when array of args not passed
							) );
							?>

						</time>

					<?php endif; ?>

				</div>

			<?php endif; ?>

			<?php if ( $show_title || $show_meta ) : ?>

				<div class="saved-entry-compact-right">

					<?php if ( $show_title ) : ?>

						<h3>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						</h3>

					<?php endif; ?>

					<?php if ( $show_meta ) : ?>

						<ul class="saved-entry-meta saved-entry-compact-meta">

							<?php if ( $show_meta_date ) : ?>
								<li class="saved-sermon-compact-date">
									<time datetime="<?php echo esc_attr( the_time( 'c' ) ); ?>"><?php ctfw_post_date(); ?></time>
								</li>
							<?php endif; ?>

							<?php if ( $show_speakers ) : ?>
								<li class="saved-sermon-compact-speaker">
									<?php echo $speakers; ?>
								</li>
							<?php endif; ?>

							<?php if ( $show_topics ) : ?>
								<li class="saved-sermon-compact-topic">
									<?php echo $topics; ?>
								</li>
							<?php endif; ?>

							<?php if ( $show_series ) : ?>
								<li class="saved-sermon-compact-series">
									<?php echo $series; ?>
								</li>
							<?php endif; ?>

							<?php if ( $show_books ) : ?>
								<li class="saved-sermon-compact-book">
									<?php echo $books; ?>
								</li>
							<?php endif; ?>

							<?php if ( $show_icons ) : ?>

								<li class="saved-entry-compact-icons">

									<ul class="saved-list-icons">

										<?php if ( $has_full_text ) : ?>
											<li><a href="<?php the_permalink(); ?>" class="<?php saved_icon_class( 'sermon-read' ); ?>" title="<?php echo esc_attr( _x( 'Read Online', 'sermon icon', 'saved' ) ); ?>"></a></li>
										<?php endif; ?>

										<?php if ( $show_video_icon ) : ?>
											<li><a href="<?php echo esc_url( $video_player ? add_query_arg( 'player', 'video', get_permalink() ) : get_permalink() ); ?>" class="<?php saved_icon_class( 'video-watch' ); ?>" title="<?php echo esc_attr( _x( 'Watch Video', 'sermon icon', 'saved' ) ); ?>"></a></li>
										<?php endif; ?>

										<?php if ( $show_audio_icon ) : ?>
											<li><a href="<?php echo esc_url( $audio_player ? add_query_arg( 'player', 'audio', get_permalink() ) : get_permalink() ); ?>" class="<?php saved_icon_class( 'audio-listen' ); ?>" title="<?php echo esc_attr( _x( 'Listen to Audio', 'sermon icon', 'saved' ) ); ?>"></a></li>
										<?php endif; ?>

										<?php if ( $pdf_download_url ) : ?>
											<li><a href="<?php echo esc_url( $pdf_download_url ); ?>" download class="<?php saved_icon_class( 'pdf-download' ); ?>" title="<?php echo esc_attr( _x( 'Download PDF', 'sermon icon', 'saved' ) ); ?>"></a></li>
										<?php endif; ?>

									</ul>

								</li>

							<?php endif; ?>

						</ul>

					<?php endif; ?>

				</div>

			<?php endif; ?>

		</div>

		<?php if ( $show_excerpt ) : ?>

			<div class="saved-entry-content saved-entry-content-compact">
				<?php saved_entry_widget_excerpt(); ?>
			</div>

		<?php endif; ?>

	</article>

<?php

// End Loop
endforeach;

// Reset post data
wp_reset_postdata();

// No items found
if ( empty( $posts ) ) {

	?>
	<div>
		<?php
		echo esc_html( sprintf(
			/* translators: $1$s is "sermons" (lowercase), possibly translated or changed by settings */
			_x( 'There are no %1$s to show.', 'sermons widget', 'saved' ),
			strtolower( ctfw_sermon_word_plural() )
		) );
		?>
	</div>
	<?php

}

// HTML After
echo $args['after_widget'];
