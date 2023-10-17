<?php
/**
 * Theme Header
 *
 * Outputs <head> and header content (logo, tagline, navigation).
 */

// No direct access
if (! defined( 'ABSPATH' )) exit;

?><!DOCTYPE html>
<!--[if IE 8 ]><html class="ie8 no-js resurrect-html" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html class="no-js resurrect-html" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); // prints out JavaScript, CSS, etc. as needed by WordPress, theme, plugins, etc. ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="resurrect-container">

	<?php
	// Do not show top bar no social icons, no search and no menu is set
	$top_has_icons = ctfw_customization( 'header_icon_urls' ) ? true : false;
	$top_has_menu = has_nav_menu( 'top' ) ? true : false;
	$top_has_search = ! ctfw_customization( 'header_hide_search' ) ? true : false;
	if ($top_has_icons || $top_has_menu || $top_has_search) :
	?>

		<div id="resurrect-top"<?php

			$top_classes = array();

			if ($top_has_icons) {
				$top_classes[] = 'resurrect-top-has-icons';
			} else {
				$top_classes[] = 'resurrect-top-no-icons';
			}

			if ($top_has_menu) {
				$top_classes[] = 'resurrect-top-has-menu';
			} else {
				$top_classes[] = 'resurrect-top-no-menu';
			}

			if ($top_has_search) {
				$top_classes[] = 'resurrect-top-has-search';
			} else {
				$top_classes[] = 'resurrect-top-no-search';
			}

			if ($top_classes) {
				echo ' class="' . esc_attr( implode( ' ', $top_classes ) ) . '"';
			}

		?>>

			<div id="resurrect-top-inner">

				<div id="resurrect-top-content" class="resurrect-clearfix">

					<?php resurrect_social_icons( ctfw_customization( 'header_icon_urls' ) ); ?>

					<div id="resurrect-top-right">

						<div id="resurrect-top-menu">

							<?php
							wp_nav_menu( array(
								'theme_location'	=> 'top',
								'menu_id'			=> 'resurrect-top-menu-links',
								'container'			=> false, // don't wrap in div
								'depth'				=> 1, // no sub menus
								'fallback_cb'		=> false // don't show pages if no menu found - show nothing
							) );
							?>

						</div>

						<?php
						// Search Box
						if (! ctfw_customization( 'header_hide_search' )) :
						?>

							<div id="resurrect-top-search">
								<?php get_search_form(); ?>
							</div>

						<?php endif; ?>

					</div>

				</div>

			</div>

		</div>

	<?php endif; ?>

	<div id="resurrect-middle">

		<div id="resurrect-middle-content" class="resurrect-clearfix">

			<header id="resurrect-header" class="resurrect-header-text-<?php echo ctfw_customization( 'header_text_color' ); ?>">

				<div id="resurrect-header-inner">

					<div id="resurrect-header-content">

						<div id="resurrect-logo">

							<div id="resurrect-logo-content">

								<?php
								// Text Logo
								if ('text' == ctfw_customization( 'logo_type' ) || ! ctfw_customization( 'logo_image' )) : // or no logo image specified
								?>

									<div id="resurrect-logo-text" class="resurrect-logo-text-<?php echo ctfw_customization( 'logo_text_size' ); ?>">
										<div id="resurrect-logo-text-inner">
											<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
												<?php echo nl2br( wptexturize( force_balance_tags( ctfw_customization( 'logo_text' ) ) ) ); // "Church <span>Name</span>"" can be used for gray portion, so force balance tags ?>
											</a>
										</div>
									</div>

								<?php
								// Image Logo
								else :
								?>

									<?php
									// Get logo URL(s)
									$logo_url = ctfw_customization( 'logo_image' ); // uploaded logo
									$logo_hidpi_url = ctfw_customization( 'logo_hidpi' ); // Retina version, if uploaded

									// Ensure logo URL uses https if site uses SSL
									// When a site switches to SSL, the saved logo URL is still often http://
									if (is_ssl()) {
										$logo_url = str_replace('http://', 'https://', $logo_url);
										$logo_hidpi_url = str_replace('http://', 'https://', $logo_hidpi_url);
									}
									?>

									<div id="resurrect-logo-image"<?php if ($logo_hidpi_url) : ?> class="resurrect-has-hidpi-logo"<?php endif; // tell stylesheet Retina logo exists ?>>

										<a href="<?php echo esc_url( home_url( '/' ) ); ?>">

											<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" id="resurrect-logo-regular">

											<?php if ($logo_hidpi_url) : // Retina logo is optional ?>
												<img src="<?php echo esc_url( $logo_hidpi_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" id="resurrect-logo-hidpi">
											<?php endif; ?>

										</a>

									</div>

								<?php endif; ?>

								<?php if (ctfw_customization( 'tagline_under_logo' )) : ?>
									<div id="resurrect-logo-tagline" class="resurrect-tagline">
										<?php bloginfo( 'description' ); ?>
									</div>
								<?php endif; ?>

							</div>

						</div>

						<div id="resurrect-header-right">

							<div id="resurrect-header-right-inner">

								<div id="resurrect-header-right-content">

									<?php get_template_part( 'header-right' ); ?>

								</div>

							</div>

						</div>

					</div>

				</div>

				<nav id="resurrect-header-menu" class="resurrect-clearfix">

					<div id="resurrect-header-menu-inner" class="resurrect-clearfix">

						<?php
						wp_nav_menu( array(
							'theme_location'	=> 'header',
							'menu_id'			=> 'resurrect-header-menu-links',
							'menu_class'		=> 'sf-menu',
							'container'			=> false, // don't wrap in div
							'fallback_cb'		=> false, // don't show pages if no menu found - show nothing
							'walker'			=> new CTFW_Walker_Nav_Menu_Description()
						) );
						?>

					</div>

				</nav>

				<?php get_template_part( 'header-banner' ); // header-banner.php ?>

			</header>
