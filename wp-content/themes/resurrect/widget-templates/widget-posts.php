<?php
/**
 * Posts Widget Template
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
$i = 0;
foreach ( $posts as $post ) : setup_postdata( $post ); $i++;
?>

	<article <?php post_class( 'resurrect-widget-entry resurrect-blog-widget-entry resurrect-clearfix' . ( 1 == $i ? ' resurrect-widget-entry-first' : '' ) ); ?>>

		<header class="resurrect-clearfix">

			<?php if ( $instance['show_image'] && has_post_thumbnail() ) : ?>
				<div class="resurrect-widget-entry-thumb">
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'resurrect-thumb-small', array( 'class' => 'resurrect-image' ) ); ?></a>
				</div>
			<?php endif; ?>

			<h1 class="resurrect-widget-entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
					<?php if ( ctfw_has_title() ) : ?>
						<?php the_title(); ?>
					<?php else : // no title for Status post format, for example ?>
						<?php echo ctfw_shorten( strip_tags( get_the_excerpt() ) , 38 ); // use first part of content as title ?>
					<?php endif; ?>
				</a>
			</h1>

			<ul class="resurrect-widget-entry-meta resurrect-clearfix">

				<?php if ( $instance['show_date'] ) : ?>
					<li class="resurrect-widget-entry-date">
						<time datetime="<?php esc_attr( the_time( 'c' ) ); ?>"><?php ctfw_post_date(); ?></time>
					</li>
				<?php endif; ?>

				<?php if ( $instance['show_author'] ) : ?>
					<li class="resurrect-widget-entry-byline">
						<?php
						printf(
							_x( 'by <a href="%1$s">%2$s</a>', 'posts widget', 'resurrect' ),
							esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), // author URL
							get_the_author() // author name
						);
						?>
					</li>
				<?php endif; ?>

			</ul>

		</header>

		<?php if ( get_the_excerpt() && ! empty( $instance['show_excerpt'] )): ?>
			<div class="resurrect-widget-entry-content">
				<?php the_excerpt(); ?>
			</div>
		<?php endif; ?>

	</article>

<?php

// End Loop
endforeach;

// No items found
if ( empty( $posts ) ) {

	?>
	<div>
		<?php _ex( 'There are no posts to show.', 'posts widget', 'resurrect' ); ?>
	</div>
	<?php

}

// HTML After
echo $args['after_widget'];