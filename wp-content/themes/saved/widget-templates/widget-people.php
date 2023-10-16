<?php
/**
 * People Widget Template
 *
 * Produces output for appropriate widget class in framework.
 * $this, $instance (sanitized field values) and $args are available.
 *
 * $this->ctfw_get_posts() can be used to produce a query according to widget field values.
 */

// No direct access
if (! defined( 'ABSPATH' )) exit;

// HTML Before
echo $args['before_widget'];

// Title
$title = apply_filters( 'widget_title', $instance['title'] );
if (! empty( $title )) {
	echo $args['before_title'] . $title . $args['after_title'];
}

// Get posts
$posts = $this->ctfw_get_posts(); // widget's default query according to field values

// Loop Posts
foreach ($posts as $post) : setup_postdata( $post );

	// Get people meta data
	// $position, $phone, $email, $urls
	extract( ctfw_person_data() );

	// Show content
	$show_image = $instance['show_image'] && has_post_thumbnail() ? true : false;
	$show_title = ctfw_has_title();
	$show_position = $instance['show_position'] && $position ? true : false;
	$show_phone = $instance['show_phone'] && $phone ? true : false;
	$show_email = $instance['show_email'] && $email ? true : false;
	$show_icons = $instance['show_icons'] && $urls ? true : false;
	$show_meta = ( $show_position || $show_phone || $show_email || $show_icons ) ? true : false;
	$show_excerpt = get_the_excerpt() && $instance['show_excerpt'] ? true : false;

	// Classes
	$classes = 'saved-person-compact';
	if ($show_excerpt) {
		$classes .= ' saved-entry-has-excerpt';
	}

?>

	<article <?php saved_compact_post_classes( array(
		'classes'			=> $classes,
		'widget_instance'	=> $instance,
	) ); ?>>

		<div class="saved-entry-compact-header saved-clearfix">

			<?php if ($show_image) : ?>

				<div class="saved-entry-compact-image saved-hover-image">
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<?php the_post_thumbnail( 'saved-rect-small' ); ?>
					</a>
				</div>

			<?php endif; ?>

			<?php if ($show_title || $show_meta) : ?>

				<div class="saved-entry-compact-right">

					<?php if ($show_title) : ?>

						<h3>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						</h3>

					<?php endif; ?>

					<?php if ($show_meta) : ?>

						<ul class="saved-entry-meta saved-entry-compact-meta">

							<?php if ($show_position) : ?>
								<li class="saved-person-compact-position">
									<?php echo esc_html( wptexturize( $position ) ); ?>
								</li>
							<?php endif; ?>

							<?php if ($show_phone) : ?>
								<li class="saved-person-compact-phone">
									<?php echo ctfw_format_phone( $phone ); // escaped, possibly linked ?>
								</li>
							<?php endif; ?>

							<?php if ($show_email) : ?>
								<li class="saved-person-compact-email">
									<?php echo ctfw_email( $email ); // link with using antispambot() and breaking before @ ?>
								</li>
							<?php endif; ?>

							<?php if ($show_icons) : ?>
								<li class="saved-person-compact-icons saved-widget-entry-icons">
									<?php saved_social_icons( $urls ); ?>
								</li>
							<?php endif; ?>

						</ul>

					<?php endif; ?>

				</div>

			<?php endif; ?>

		</div>

		<?php if ($show_excerpt) : ?>

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
if (empty( $posts )) {

	?>
	<div>
		<?php _ex( 'There are no people to show.', 'people widget', 'saved' ); ?>
	</div>
	<?php

}

// HTML After
echo $args['after_widget'];
