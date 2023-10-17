<?php
/**
 * Header Banner
 *
 * Outputs an image overlayed by a title of the current section based on content type.
 * Pages can use the "Banner" meta box to control how and where this is shown.
 *
 * This is loaded by header.php.
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Get banner data
$banner = resurrect_banner_data();

?>

<?php if ( $banner['page'] ) : // banner page found ?>

	<div id="resurrect-banner">

		<?php echo get_the_post_thumbnail( $banner['page']->ID, 'resurrect-banner' ); ?>

		<?php if ( ! $banner['no_text'] ) : ?>

			<h1>
				<a href="<?php echo esc_url( get_permalink( $banner['page']->ID ) ); ?>" title="<?php echo esc_attr( get_the_title( $banner['page']->ID ) ); ?>">
					<?php echo esc_html( $banner['page']->post_title ); ?>
				</a>
			</h1>

			<?php resurrect_breadcrumbs( 'banner' ); ?>

		<?php endif; ?>

	</div>

<?php endif; ?>