<?php
/**
 * Post Header Meta (Full and Short)
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<header class="resurrect-entry-header resurrect-clearfix">

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="resurrect-entry-image">
			<?php resurrect_post_image(); ?>
		</div>
	<?php endif; ?>

	<div class="resurrect-entry-title-meta">

		<?php if ( ctfw_has_title() ) : // might be Status Update with no title ?>
			<h1 class="resurrect-entry-title<?php if ( is_singular( get_post_type() ) ) : ?> resurrect-main-title<?php endif; ?>">
				<?php resurrect_post_title(); // will be linked on short ?>
			</h1>
		<?php endif; ?>

		<ul class="resurrect-entry-meta">

			<li class="resurrect-entry-date resurrect-content-icon">
				<span class="<?php resurrect_icon_class( 'entry-date' ); ?>"></span>
				<time datetime="<?php esc_attr( the_time( 'c' ) ); ?>"><?php ctfw_post_date(); ?></time>
			</li>

			<li class="resurrect-entry-byline resurrect-content-icon">
				<span class="<?php resurrect_icon_class( 'entry-byline' ); ?>"></span>
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a>
			</li>

			<?php if ( $categories = get_the_category_list( __( ', ', 'resurrect' ) ) ) : ?>
				<li class="resurrect-entry-category resurrect-content-icon">
					<span class="<?php resurrect_icon_class( 'entry-category' ); ?>"></span>
					<?php echo $categories; ?>
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
