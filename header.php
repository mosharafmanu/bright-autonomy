<?php
/**
 * @package bright-autonomy
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

<header class="site-header">
	<div class="mc-container header-main-inner layout-padding">
		<div class="site-branding">
			<?php bright_autonomy_render_site_logo(); ?>
		</div>

		<div class="site-header-bar">
			<nav id="primary-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Main navigation', 'bright-autonomy' ); ?>">
				<?php
				wp_nav_menu( [
					'theme_location' => 'mainMenu',
					'container'      => false,
					'menu_class'     => 'main-menu',
					'fallback_cb'    => false,
					'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				] );
				?>
			</nav>

			<div class="site-header-actions">
				<?php bright_autonomy_render_header_button(); ?>
				<button class="mobile-menu-toggle" aria-controls="mobile-navigation" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle menu', 'bright-autonomy' ); ?>">
					<span class="hamburger-line"></span>
					<span class="hamburger-line"></span>
					<span class="hamburger-line"></span>
				</button>
			</div>
		</div>




	</div>
</header>