<?php
/**
 * Comment Template
 *
 * This renders each single coment.
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Get post
$post = get_post();

// Is this the post author? (blog posts only)
$is_post_author = false;
if ( $comment->user_id === $post->post_author && 'post' == get_post_type() ) {
	$is_post_author = true;
}

// Is this a trackback/pingback?
$is_trackback = false;
if ( in_array( $comment->comment_type, array( 'trackback', 'pingback' ) ) ) {
	$is_trackback = true;
}

?>

<li id="li-comment-<?php comment_ID(); ?>" <?php comment_class( 'saved-comment' ); ?>>

	<article id="comment-<?php comment_ID(); ?>">

		<header class="saved-comment-meta">

			<?php
			$avatar_img = get_avatar( $comment, 108 ); // double what's in CSS (variables.scss) for Retina
			if ( $avatar_img ) :
			?>
				<div class="saved-comment-avatar">
					<?php echo $avatar_img; ?>
				</div>
			<?php endif; ?>

			<ul class="saved-comment-buttons saved-buttons-list">

				<?php
				if ( ! $is_trackback ) { // no reply button for trackbacks/pingbacks
					comment_reply_link( array_merge( $args, array(
						/* translators: %s is icon */
						'reply_text' => sprintf( __( '%s Reply', 'saved' ), '<span class="saved-button-icon ' . saved_get_icon_class( 'comment-reply' ) . '"></span>' ),
						/* translators: %s is icon */
						'login_text' => sprintf( __( '%s Reply', 'saved' ), '<span class="saved-button-icon ' . saved_get_icon_class( 'comment-reply' ) . '"></span>' ),
						'depth' => $depth,
						'max_depth' => $args['max_depth'],
						'before' => '<li>',
						'after' => '</li>',
					) ) );
				}
				?>

				<?php
				edit_comment_link(
					sprintf(
						/* translators: %s is icon */
						_x( '%s Edit', 'comment', 'saved' ),
						'<span class="' . saved_get_icon_class( 'comment-edit' ) . '"></span>'
					),
					'<li>',
					'</li>'
				);
				?>

			</ul>

			<h3 class="saved-h5 saved-comment-title <?php echo ( $is_trackback ? 'saved-comment-trackback-link' : 'saved-comment-author' ); // use appopriate class for type of comment or trackback/pingback ?> ">

				<?php comment_author_link(); ?>

				<?php if ( $is_post_author || $is_trackback ) : // post author or trackback ?>
					<span>
						<?php

						// "Author" after name if post author
						if ( $is_post_author ) {
							_ex( 'Author', 'comments', 'saved' );
						}

						// "Trackback" or "Pingback" after link
						elseif ( $is_trackback ) {
							if ( 'trackback' == $comment->comment_type ) {
								_e( 'Trackback', 'saved' );
							} elseif ( 'pingback' == $comment->comment_type ) {
								_e( 'Pingback', 'saved' );
							}
						}

						?>
					</span>
				<?php endif; ?>

			</h3>

			<?php
			/* translators: %3$s is date and %4$s is time for comments */
			printf( '<a href="%1$s"><time datetime="%2$s">' . _x( '%3$s <span class="saved-comment-time">%4$s</span>', 'comments', 'saved' ) . '</time></a>',
				esc_url( get_comment_link( $comment->comment_ID ) ), // comment link
				get_comment_time( 'c' ), // datetime attribute
				get_comment_date(), // human friendly date
				get_comment_time() // human friendly time
			);
			?>

		</header>

		<div class="saved-comment-content saved-entry-content">

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="saved-comment-moderation"><?php _e( 'Your comment is awaiting moderation.', 'saved' ); ?></p>
			<?php endif; ?>

			<?php comment_text(); ?>

		</div>

	</article>

<?php

// </li> is auto-closed
