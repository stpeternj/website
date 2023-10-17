<?php
/**
 * Attachment Header Meta (Full and Short)
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<header class="resurrect-entry-header resurrect-clearfix">

	<div class="resurrect-entry-title-meta">

		<?php if ( ctfw_has_title() ) : ?>
			<h1 class="resurrect-entry-title<?php if ( is_singular( get_post_type() ) ) : ?> resurrect-main-title<?php endif; ?>">
				<?php resurrect_post_title(); // will be linked on short ?>
			</h1>
		<?php endif; ?>

		<ul class="resurrect-entry-meta">

			<li class="resurrect-attachment-date resurrect-content-icon">
				<span class="<?php resurrect_icon_class( 'entry-date' ); ?>"></span>
				<time datetime="<?php esc_attr( the_time( 'c' ) ); ?>"><?php printf( __( 'Uploaded %s', 'resurrect' ), '<span>' . ctfw_post_date( array( 'return' => true ) ) . '</span>' ); ?></time>
			</li>

			<?php if ( $post->post_parent ) : ?>
				<li class="resurrect-entry-parent resurrect-content-icon">
					<span class="<?php resurrect_icon_class( 'entry-parent' ); ?>"></span>
					<a href="<?php echo esc_url( get_permalink( $post->post_parent ) ); ?>" title="<?php echo esc_attr( get_the_title( $post->post_parent ) ); ?>"><?php echo get_the_title( $post->post_parent ); ?></a>
				</li>
			<?php endif; ?>

			<?php if ( resurrect_show_comments() ) : ?>
				<li class="resurrect-entry-comments-link resurrect-content-icon">
					<span class="<?php resurrect_icon_class( 'comments-link' ); ?>"></span>
					<?php resurrect_comments_link(); ?>
				</li>
			<?php endif; ?>

		</ul>

	</div>

</header>
