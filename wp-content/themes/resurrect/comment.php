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

<li id="li-comment-<?php comment_ID(); ?>" <?php comment_class( 'resurrect-comment' ); ?>>

	<article id="comment-<?php comment_ID(); ?>">

		<div class="resurrect-comment-meta">

			<?php
			$avatar_img = get_avatar( $comment, 100 );
			if ( $avatar_img ) : // 50x50 (doubled to 100 for HiDPI/Retina); don't show for trackback/pingback
			?>
				<div class="resurrect-comment-avatar">
					<?php echo $avatar_img; ?>
				</div>
			<?php endif; ?>

			<div class="resurrect-comment-buttons">

				<?php
				if ( ! $is_trackback ) { // no reply button for trackbacks/pingbacks
					comment_reply_link( array_merge( $args, array(
						'reply_text' => sprintf( __( '%s Reply', 'resurrect' ), '<span class="resurrect-button-icon ' . resurrect_get_icon_class( 'comment-reply' ) . '"></span>' ),
						'login_text' => __( 'Log in to Reply', 'resurrect' ),
						'depth' => $depth,
						'max_depth' => $args['max_depth']
					) ) );
				}
				?>

				<?php edit_comment_link( sprintf( _x( '%s Edit', 'comment', 'resurrect' ), '<span class="resurrect-button-icon ' . resurrect_get_icon_class( 'comment-edit' ) . '"></span>' ) ); ?>

			</div>

			<div class="<?php echo ( $is_trackback ? 'resurrect-comment-trackback-link' : 'resurrect-comment-author' ); // use appopriate class for type of comment or trackback/pingback ?> ">

				<?php comment_author_link(); ?>

				<?php if ( $is_post_author || $is_trackback ) : // post author or trackback ?>
					<span>
						<?php

						// "Author" after name if post author
						if ( $is_post_author ) {
							_ex( '(Author)', 'comments', 'resurrect' );
						}

						// "Trackback" or "Pingback" after link
						elseif ( $is_trackback ) {
							if ( 'trackback' == $comment->comment_type ) {
								_e( '(Trackback)', 'resurrect' );
							} elseif ( 'pingback' == $comment->comment_type ) {
								_e( '(Pingback)', 'resurrect' );
							}
						}

						?>
					</span>
				<?php endif; ?>

			</div>

			<?php
			/* translators: %3$s is date and %4$s is time for comments */
			printf( '<a href="%1$s"><time datetime="%2$s">' . _x( '%3$s <span class="resurrect-comment-time">at %4$s</span>', 'comments', 'resurrect' ) . '</time></a>',
				esc_url( get_comment_link( $comment->comment_ID ) ), // comment link
				get_comment_time( 'c' ), // datetime attribute
				get_comment_date(), // human friendly date
				get_comment_time() // human friendly time
			);
			?>

		</div>

		<div class="resurrect-comment-content resurrect-entry-content">

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="resurrect-comment-moderation"><?php _e( 'Your comment is awaiting moderation.', 'resurrect' ); ?></p>
			<?php endif; ?>

			<?php comment_text(); ?>

		</div>

	</article>

<?php

// </li> is auto-closed
