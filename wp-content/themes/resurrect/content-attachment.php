<?php
/**
 * Attachment content for images (gallery) and other files.
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'resurrect-entry-full resurrect-attachment-full' ); ?>>

	<?php get_template_part( 'content-attachment-header' ); ?>

	<div class="resurrect-entry-attachment">

		<?php
		// Image is displayed
		if ( wp_attachment_is_image() ) :
		?>

			<div class="wp-caption aligncenter">

				<?php echo wp_get_attachment_image( $post->ID, 'large' ); ?>

				<?php if ( ctfw_has_manual_excerpt() ) : ?>
					<p class="wp-caption-text">
						<?php echo wptexturize( get_the_excerpt() ); ?>
					</p>
				<?php endif; ?>

			</div>

		<?php
		// Other files are represented by download link
		// (typically non-image file attachment pages are never linked to)
		else :
		?>

			<a href="<?php echo esc_url( ctfw_download_url( wp_get_attachment_url( $post->ID ) ) ); ?>" class="resurrect-button resurrect-attachment-download" download="download">
				<span class="resurrect-button-icon <?php resurrect_icon_class( 'download' ); ?>"></span>
				<?php
				$filetype = wp_check_filetype( wp_get_attachment_url( $post->ID ) );
				if ( $filetype['ext'] ) {
					/* translators: %s is file extension */
					printf( __( 'Download %s', 'resurrect' ), strtoupper( $filetype['ext'] ) );
				}
				?>
			</a>

		<?php endif; ?>

	</div>

	<?php if ( ctfw_has_content() ) : ?>
	<div class="resurrect-entry-content resurrect-clearfix">

		<?php the_content(); ?>

		<?php do_action( 'resurrect_after_content' ); ?>

	</div>
	<?php endif; ?>

	<?php get_template_part( 'content-footer-full' ); // multipage nav, term lists, "Edit" button, etc. ?>

</article>