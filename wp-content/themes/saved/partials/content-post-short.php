<?php
/**
 * Short Post Content (Archive)
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Date.
$date = ctfw_post_date( array(
	'abbreviate_date' => array( // arguments for ctfw_abbreviate_date_format(); or set true to use defaults
		'abbreviate_month'	=> true, // December = Dec
		'remove_year'		=> false,
	),
	'return' => true,
) );
?>

<article id="post-<?php the_ID(); ?>" <?php saved_short_post_classes(); ?>>

	<?php if ( ! has_post_thumbnail() ) : ?>

		<time datetime="<?php echo esc_attr( the_time( 'c' ) ); ?>" class="saved-entry-short-date saved-entry-short-label">
			<?php echo $date; ?>
		</time>

	<?php endif; ?>

	<?php if ( has_post_thumbnail() ) : ?>

		<div class="saved-entry-short-image saved-hover-image">

			<time datetime="<?php echo esc_attr( the_time( 'c' ) ); ?>" class="saved-entry-short-date saved-entry-short-label">
				<?php echo $date; ?>
			</time>

			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail(); ?>
			</a>

		</div>

	<?php endif; ?>

	<div class="saved-entry-short-inner">

		<header class="saved-entry-short-header">

			<?php if ( ctfw_has_title() ) : ?>

				<h2 class="saved-entry-short-title">
					<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute( array( 'echo' => false ) ); ?>"><?php the_title(); ?></a>
				</h2>

			<?php endif; ?>

			<ul class="saved-entry-meta saved-entry-short-meta">

				<li class="saved-entry-short-author">
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a>
				</li>

				<?php /* if ( $categories ) : ?>

					<li class="saved-entry-short-category">
						<?php echo $categories; ?>
					</li>

				<?php endif; */ ?>

			</ul>

		</header>

		<?php get_template_part( CTFW_THEME_PARTIAL_DIR . '/content-excerpt' ); // show excerpt if no image ?>

	</div>

</article>
