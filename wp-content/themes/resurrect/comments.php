<?php
/**
 * List Comments and Form
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Show comments only on single posts and pages
if ( ! is_singular() || resurrect_loop_after_content_used() ) {
	return;
}

// If comments are closed and none have been made, hide the whole comment section
if ( ! have_comments() && ! comments_open() ) {
	return;
}

?>

<section id="comments" class="resurrect-content-block"><?php // #comments is hardcoded in WP core comments_popup_link(), so no resurrect- prefix ?>

	<?php
	// Show message if post is password protected
	if ( post_password_required() ) :
	?>

		<h1 id="resurrect-comments-title" class="resurrect-main-title">
			<?php _ex( 'Comments', 'password protected', 'resurrect' ); ?>
		</h1>

		<p>
			<?php _e( 'Enter the password above to view any comments.', 'resurrect' ); ?>
		</p>

	<?php
	// Show comments if not password protected
	else :
	?>

		<h1 id="resurrect-comments-title" class="resurrect-main-title">
			<?php
			printf(
				_n( 'One Comment', '%1$s Comments', get_comments_number(), 'resurrect' ), // title for 1 comment, title for 2+ comments
				number_format_i18n( get_comments_number() )
			);
			?>
		</h1>

		<?php
		// List comments
		if ( have_comments() ) :
		?>

			<ol class="resurrect-comments">
				<?php
				wp_list_comments( array(
					'callback' => 'ctfw_comment' // framework function that loads comment.php for each comment
				) );
				?>
			</ol>

			<?php
			// Comment navigation
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
			?>
				<nav class="resurrect-nav-left-right resurrect-clearfix" id="resurrect-comment-nav">
					<div class="resurrect-nav-left"><?php previous_comments_link( sprintf( __( ' %s Older Comments', 'resurrect' ), '<span class="resurrect-button-icon ' . resurrect_get_icon_class( 'nav-left' ) . '"></span>' ) ); ?></div>
					<div class="resurrect-nav-right"><?php next_comments_link( sprintf( __( 'Newer Comments %s', 'resurrect' ), '<span class="resurrect-button-icon ' . resurrect_get_icon_class( 'nav-right' ) . '"></span>' ) ); ?></div>
				</nav>
			<?php endif; ?>

		<?php endif; ?>

		<?php
		// Comments open
		if ( comments_open() ) : // show if comments not closed
		?>

			<?php
			// Show form
			comment_form( array(
				'title_reply'			=> _x( 'Add a Comment', 'comment form', 'resurrect' ),
				'title_reply_to'		=> __( 'Add a Reply to %s', 'resurrect' ),
				'cancel_reply_link'		=> _x( 'Cancel', 'comment form', 'resurrect' ),
				'label_submit'			=> _x( 'Add Comment', 'comment form', 'resurrect' )
			) );
			?>

		<?php
		// Comments closed
		else :
		?>

		<p id="resurrect-comments-closed">
			<?php _e( 'Commenting has been turned off.', 'resurrect' ); // Show message if comments closed ?>
		</p>

		<?php endif; ?>

	<?php endif; ?>

</section>
