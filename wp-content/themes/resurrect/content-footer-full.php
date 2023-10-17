<?php
/**
 * Full Content Footer
 *
 * Multipage nav, taxonomy terms, admin Edit link, etc. for full display of different post types.
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Collect term lists (categories, tags, etc.) for specific post types
$term_lists = array();

// Blog Terms
if ( is_singular( 'post' ) ) {

	// Blog Tags
	/* translators: used between list items, there is a space after the comma */
	if ( $list = get_the_tag_list( '', __( ', ', 'resurrect' ) ) ) {
		$term_lists[] = '<div class="resurrect-content-icon"><span class="' . resurrect_icon_class( 'entry-tag', 'return' ) . '"></span>' . sprintf( __( 'Tagged with %s', 'resurrect' ), $list ) . '</div>';
	}

}

// Sermon Tags and Series
elseif ( is_singular( 'ctc_sermon' ) ) {

	// Series
	/* translators: used between list items, there is a space after the comma */
	if ( $list = get_the_term_list( $post->ID, 'ctc_sermon_series', '', __( ', ', 'resurrect' ) ) ) {
		$term_lists[] = '<div class="resurrect-content-icon"><span class="' . resurrect_icon_class( 'sermon-series', 'return' ) . '"></span>' . sprintf( __( 'Series: %s', 'resurrect' ), $list ) . '</div>';
	}

	// Sermon Tags
	/* translators: used between list items, there is a space after the comma */
	if ( $list = get_the_term_list( $post->ID, 'ctc_sermon_tag', '', __( ', ', 'resurrect' ) ) ) {
		$term_lists[] = '<div class="resurrect-content-icon"><span class="' . resurrect_icon_class( 'entry-tag', 'return' ) . '"></span>' . sprintf( __( 'Tagged with %s', 'resurrect' ), $list ) . '</div>';
	}

}

// Event Categories
elseif ( is_singular( 'ctc_event' ) ) {

	/* translators: used between list items, there is a space after the comma */
	$list = get_the_term_list( $post->ID, 'ctc_event_category', '', __( ', ', 'resurrect' ) );
	if ( $list ) {
		$term_lists[] = '<div class="resurrect-content-icon"><span class="' . resurrect_icon_class( 'event-category', 'return' ) . '"></span>' . $list . '</div>';
	}

}

?>

<?php
// Have footer content to show?
if ( ( ctfw_is_multipage() && ! post_password_required() ) || ! empty( $term_lists ) || ctfw_can_edit_post() ) :
?>

	<footer class="resurrect-entry-footer resurrect-clearfix">

		<?php
		// "Pages: 1 2 3" when <!--nextpage--> used
		if ( ctfw_is_multipage() && ! post_password_required() ) :
		?>
			<div class="resurrect-entry-footer-item">
				<?php
				wp_link_pages( array(
					'before'	=> '<div class="resurrect-entry-page-nav"><span>' . __( 'Pages:', 'resurrect' ) . '</span>',
					'after'		=> '</div>'
				) );
				?>
			</div>
		<?php endif; ?>

		<?php
		// Term lists (categories, tags, etc.)
		if ( ! empty( $term_lists ) ) :
		?>

			<div class="resurrect-entry-footer-item">

				<?php foreach ( $term_lists as $term_list ) : ?>
				<div class="resurrect-entry-footer-terms">
					<?php echo $term_list; ?>
				</div>
				<?php endforeach; ?>

			</div>

		<?php endif; ?>

		<?php
		// "Edit" link for privileged user
		if ( ctfw_can_edit_post() ) :
		?>

			<div class="resurrect-entry-footer-item">

				<?php
				$post_type_obj = get_post_type_object( $post->post_type );
				/* translators: %1$s is icon, %1$s is post type singular name */
				edit_post_link(
					sprintf(
						__( '%1$s Edit %2$s', 'resurrect' ), // Link text format
						'<span class="resurrect-button-icon ' . resurrect_get_icon_class( 'edit-post' ) . '"></span>', // Icon
						$post_type_obj->labels->singular_name // Post type name
					)
				);
				?>

			</div>

		<?php endif; ?>

	</footer>

<?php endif; ?>