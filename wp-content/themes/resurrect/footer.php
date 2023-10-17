<?php
/**
 * Theme Footer
 */

// No direct access
if (! defined( 'ABSPATH' )) exit;

?>

		</div>

	</div>

	<!-- Middle End -->

	<!-- Footer Start -->

	<footer id="resurrect-footer">

		<div id="resurrect-footer-inner">

			<div id="resurrect-footer-content" class="resurrect-clearfix">

				<!---
				<div id="resurrect-footer-responsive-toggle">

					<a id="resurrect-footer-full-site" href="#">
						<?php _e( 'View Full Site', 'resurrect' ); ?>
					</a>

					<a id="resurrect-footer-mobile-site" href="#">
						<?php _e( 'View Mobile Site', 'resurrect' ); ?>
					</a>

				</div>
				--->

				<div id="resurrect-footer-left" class="resurrect-clearfix">

					<?php
					wp_nav_menu( array(
						'theme_location'	=> 'footer',
						'menu_id'			=> 'resurrect-footer-menu-links',
						'container'			=> false, // don't wrap in div
						'depth'				=> 1, // no sub menus
						'fallback_cb'		=> false // don't show pages if no menu found - show nothing
					) );
					?>

					<?php if ($footer_icons = resurrect_social_icons( ctfw_customization( 'footer_icon_urls' ), 'return' )) : ?>
						<div id="resurrect-footer-social-icons">
							<?php echo $footer_icons; ?>
						</div>
					<?php endif; ?>

				</div>

				<div id="resurrect-footer-right">

					<?php if (ctfw_customization( 'footer_address' ) || ctfw_customization( 'footer_phone' )) : ?>

						<ul id="resurrect-footer-contact">

							<?php if (ctfw_customization( 'footer_address' )) : ?>
							<li><span id="resurrect-footer-icon-address" class="<?php resurrect_icon_class( 'footer-address' ); ?>"></span> <span id="resurrect-footer-address"><?php echo ctfw_customization( 'footer_address' ); ?></span></li>
							<?php endif; ?>

							<?php if (ctfw_customization( 'footer_phone' )) : ?>
							<li><span id="resurrect-footer-icon-phone" class="<?php resurrect_icon_class( 'footer-phone' ); ?>"></span> <span id="resurrect-footer-phone"><?php echo ctfw_format_phone( ctfw_customization( 'footer_phone' ) ); // escaped, possibly linked ?></span></li>
							<?php endif; ?>

						</ul>

					<?php endif; ?>

					<?php if (ctfw_customization( 'footer_notice' )) : ?>
						<div id="resurrect-notice">
							<?php echo nl2br( wptexturize( do_shortcode( ctfw_customization( 'footer_notice' ) ) ) ); ?>
						</div>
					<?php endif; ?>

				</div>

			</div>

		</div>

	</footer>

	<!-- Footer End -->

</div>

<!-- Container End -->

<?php
wp_footer(); // a hook for extra code in the footer, if needed
?>

</body>
</html>
