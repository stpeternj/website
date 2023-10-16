<?php
/**
 * Output navigation at bottom of single and multiple loops
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/*********************************
 * ATTACHMENT - Back to Parent
 *********************************/

// No prev/next for gallery images since images can belong to multiple galleries.
// Instead, a lightbox plugin like Jetpack Carousel can be used for prev/next.

if ( is_attachment() ) :

?>

	<?php if ( ! empty( $post->post_parent ) && $parent_post = get_post( $post->post_parent ) ) : ?>

		<div class="saved-nav-left-right">
			<div class="saved-nav-left"><?php previous_post_link( '%link', sprintf( __( ' %s Back to %s', 'saved' ), '<span class="' . saved_get_icon_class( 'nav-button-left' ) . '"></span>', $parent_post->post_title ) ); ?></div>
		</div>

	<?php endif; ?>

<?php

/*********************************
 * SINGLE POST - Prev / Next
 *********************************/

elseif ( is_singular() && ! is_page() && ! saved_loop_after_content_used() ) : // use Multiple Posts nav on "loop after content" pages

	// Get prev/next posts
	$prev_post = get_previous_post();
	$next_post = get_next_post();

	// Show only if has prev or next post
	if ( ! $prev_post && ! $next_post ) {
		return;
	}

	// Get url, label and image_style
	$data_prev = saved_single_post_nav_data( 'previous', $prev_post );
	$data_next = saved_single_post_nav_data( 'next', $next_post );

	// Let child themes change this
	$prev_next_title_characters = apply_filters( 'saved_prev_next_title_characters', 50 ); // approx 2 lines

	?>

	<div class="saved-nav-blocks saved-color-main-bg<?php

		// Have both posts
		if ( $prev_post && $next_post ) {
			echo ' saved-nav-block-has-both';
		}

		// No images on either
		if ( ! $data_prev['image_style'] && ! $data_next['image_style'] ) {
			echo ' saved-nav-block-no-images';
		}

	?>">

		<div class="saved-nav-block saved-nav-block-left saved-hover-image<?php if ( ! $prev_post ) : ?> saved-nav-block-empty<?php endif; ?>">

			<?php if ( $prev_post ) : ?>

				<?php if ( $data_prev['image_style'] ) : ?>
					<div class="saved-nav-block-image saved-hover-bg" style="<?php echo esc_attr( $data_prev['image_style'] ); ?>">
						<div class="saved-nav-block-image-brightness" style="<?php echo esc_attr( $data_prev['image_brightness_style'] ); ?>"></div>
						<div class="saved-banner-image-gradient"></div>
					</div>
				<?php endif; ?>

				<div class="saved-nav-block-content">

					<div class="saved-nav-block-content-columns">

						<div class="saved-nav-block-content-column saved-nav-block-content-left saved-nav-block-content-arrow">

							<a href="<?php echo esc_url( $data_prev['url'] ); ?>"><span class="<?php echo saved_get_icon_class( 'nav-block-left' ); ?>"></span></a>

						</div>

						<div class="saved-nav-block-content-column saved-nav-block-content-right saved-nav-block-content-text">

							<?php if ( $data_prev['label'] ) : ?>
								<div class="saved-nav-block-label"><?php echo esc_html( $data_prev['label'] ); ?></div>
							<?php endif; ?>

							<a href="<?php echo esc_url( $data_prev['url'] ); ?>" class="saved-nav-block-title"><?php echo esc_html( ctfw_shorten( $prev_post->post_title, $prev_next_title_characters ) ); ?></a>

						</div>

					</div>

				</div>

			<?php endif; ?>

		</div>

		<div class="saved-nav-block saved-nav-block-right saved-hover-image<?php if ( ! $next_post ) : ?> saved-nav-block-empty<?php endif; ?>">

			<?php if ( $next_post ) : ?>

				<?php if ( $data_next['image_style'] ) : ?>
					<div class="saved-nav-block-image saved-hover-bg" style="<?php echo esc_attr( $data_next['image_style'] ); ?>">
						<div class="saved-nav-block-image-brightness" style="<?php echo esc_attr( $data_next['image_brightness_style'] ); ?>"></div>
						<div class="saved-banner-image-gradient"></div>
					</div>

				<?php endif; ?>

				<div class="saved-nav-block-content">

					<div class="saved-nav-block-content-columns">

						<div class="saved-nav-block-content-column saved-nav-block-content-left saved-nav-block-content-text">

							<?php if ( $data_next['label'] ) : ?>
								<div class="saved-nav-block-label"><?php echo esc_html( $data_next['label'] ); ?></div>
							<?php endif; ?>

							<a href="<?php echo esc_url( $data_next['url'] ); ?>" class="saved-nav-block-title"><?php echo esc_html( ctfw_shorten( $next_post->post_title, $prev_next_title_characters ) ); ?></a>

						</div>

						<div class="saved-nav-block-content-column saved-nav-block-content-right saved-nav-block-content-arrow">

							<a href="<?php echo esc_url( $data_next['url'] ); ?>"><span class="<?php echo saved_get_icon_class( 'nav-block-right' ); ?>"></span></a>

						</div>

					</div>

				</div>

			<?php endif; ?>

		</div>

	</div>

<?php

/*********************************
 * MULTIPLE POSTS - Page 1 2 3
 *********************************/

else :

	// Query to use for pagination
	$query = saved_loop_after_content_query();
	if ( ! $query ) {  // use "loop after content" query if available
		$query = $wp_query; // otherwise use default query
	}

?>

	<?php if ( $query->max_num_pages > 1 ) : // show only if more than 1 page ?>

		<div class="saved-pagination">

			<?php
			// To Do: Replace with the_posts_pagination(), new as of WP 4.1 (how to use with CPT?)
			echo paginate_links( array(
				'base' 		=> str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ), // for search and archives: https://codex.wordpress.org/Function_Reference/paginate_links#Examples
				'current' 	=> max( 1, ctfw_page_num() ), // ctfw_page_num() returns/corrects $paged so pagination works on static front page
				'total' 	=> $query->max_num_pages,
				'type' 		=> 'list',
				'prev_text'	=> '<span class="' . saved_get_icon_class( 'nav-links-left' ) . '"></span>',
				'next_text'	=> '<span class="' . saved_get_icon_class( 'nav-links-right' ) . '"></span>',
			) );
			?>

		</div>

	<?php endif; ?>

<?php endif; ?>