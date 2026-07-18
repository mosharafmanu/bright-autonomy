<?php
/**
 * Mobile Navigation Component
 * @package bright-autonomy
 */

if ( ! function_exists( 'bright_autonomy_render_mobile_navigation' ) ) {
	function bright_autonomy_render_mobile_navigation() {
		$header_cta    = function_exists( 'bright_autonomy_get_header_button' ) ? bright_autonomy_get_header_button() : false;
		$social_medias = function_exists( 'bright_autonomy_get_social_medias' ) ? bright_autonomy_get_social_medias() : false;
		?>

		<div class="mobile-menu-overlay" aria-hidden="true"></div>

		<nav id="mobile-navigation" class="mobile-navigation" aria-label="<?php esc_attr_e( 'Mobile navigation', 'bright-autonomy' ); ?>" aria-hidden="true">
			<div class="mobile-nav-inner">

				<div class="mobile-nav-header">
					<div class="site-branding mobile-nav-logo">
						<?php bright_autonomy_render_site_logo(); ?>
					</div>
					<button class="mobile-menu-close" aria-label="<?php esc_attr_e( 'Close menu', 'bright-autonomy' ); ?>">
						<span></span>
						<span></span>
					</button>
				</div>

				<div class="mobile-nav-menu">
					<?php
					wp_nav_menu( [
						'theme_location' => 'mainMenu',
						'container'      => false,
						'menu_class'     => 'mobile-menu',
						'fallback_cb'    => false,
						'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					] );
					?>
				</div>

				<?php if ( $header_cta ) : ?>
				<div class="mobile-nav-cta">
					<?php
					if ( function_exists( 'bright_autonomy_render_header_button' ) ) {
						bright_autonomy_render_header_button(
							[
								'class' => 'mobile-cta-btn',
							]
						);
					}
					?>
				</div>
				<?php endif; ?>

				<?php if ( $social_medias && is_array( $social_medias ) && function_exists( 'bright_autonomy_render_social_medias' ) ) : ?>
				<div class="mobile-nav-social">
					<?php
					// Reuse the same helper the footer calls (bright_autonomy_render_social_medias)
					// rather than re-deriving SVG-vs-image handling and aria-labels here —
					// it already injects an icon class onto each SVG's root element, which
					// is what lets CSS size them; the hand-rolled markup this replaced
					// echoed raw, unconstrained file_get_contents() output with no class
					// to hook into, rendering each icon at its native (huge) viewBox size
					// in a bare bulleted <ul>.
					bright_autonomy_render_social_medias( [
						'list_class' => 'mobile-social-list',
						'item_class' => 'mobile-social-item',
						'link_class' => 'mobile-social-link',
						'icon_class' => 'mobile-social-icon',
					] );
					?>
				</div>
				<?php endif; ?>

			</div>
		</nav>

		<?php
	}
}
