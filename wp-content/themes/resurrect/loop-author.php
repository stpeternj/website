<?php
/**
 * Author Box
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Show only on single blog posts and list of author's posts
if ( ! is_singular( 'post' ) && ! is_author() ) return;

// Show only if have profile bio
if ( ! get_the_author_meta( 'description' ) ) return;

?>

<aside class="resurrect-content-block resurrect-clearfix">

	<div class="resurrect-author-box">

		<div class="resurrect-author-avatar">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), 200 ); // 100x100 so 200 for hiDPI/Retina ?>
		</div>

		<div class="resurrect-author-content">

			<h1><?php printf( __( 'About %s', 'resurrect' ), get_the_author() ); ?></h1>

			<?php the_author_meta( 'description' ); ?>

			<?php if ( is_singular() && get_the_author_posts() > 1 ) : // not on author archive and has more than this post ?>
				<div class="resurrect-author-box-archive">
					<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php printf( __( 'More posts by %1$s', 'resurrect' ), get_the_author() ); ?></a>
				</div>
			<?php endif; ?>

		</div>

	</div>

</aside>
