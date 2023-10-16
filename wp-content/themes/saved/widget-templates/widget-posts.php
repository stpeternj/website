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
foreach ( $posts as $post ) : setup_postdata( $post );

	// Categories
	$categories = get_the_category_list(
		/* translators: used between list items, there is a space after the comma */
		__( ', ', 'saved' )
	);

	// Show content
	$show_image = $instance['show_image'] && has_post_thumbnail() ? true : false;
	$show_title = ctfw_has_title();
	$show_image_date = $instance['show_date'] && $show_image ? true : false;
	$show_meta_date = $instance['show_date'] && ! $show_image ? true : false;
	$show_meta = $show_title || $show_meta_date ? true : false;
	$show_excerpt = get_the_excerpt() && $instance['show_excerpt'] ? true : false;

	// Classes
	$classes = 'saved-post-compact';
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

			<?php if ( $show_meta ) : ?>

				<div class="saved-entry-compact-right">

					<?php if ( ctfw_has_title() ) : ?>

						<h3>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						</h3>

					<?php endif; ?>


					<?php if ( $show_meta_date || $instance['show_author'] || ( $instance['show_category'] && $categories ) ) : ?>

						<ul class="saved-entry-meta saved-entry-compact-meta">

							<?php if ( $show_meta_date ) : ?>
								<li class="saved-entry-compact-date">
									<time datetime="<?php echo esc_attr( the_time( 'c' ) ); ?>"><?php ctfw_post_date(); ?></time>
								</li>
							<?php endif; ?>

							<?php if ( $instance['show_author'] ) : ?>
								<li class="saved-entry-compact-author">
									<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a>
								</li>
							<?php endif; ?>

							<?php if ( $instance['show_category'] && $categories ) : ?>
								<li class="saved-entry-compact-category">
									<?php echo $categories; ?>
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
		<?php _ex( 'There are no posts to show.', 'posts widget', 'saved' ); ?>
	</div>
	<?php

}

// HTML After
echo $args['after_widget'];