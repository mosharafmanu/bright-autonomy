<?php
/**
 * @package bright-autonomy
 */

?>

<footer id="colophon" class="site-footer mt-50 mt-md-70 mt-lg-100">

	<div class="mc-container">
		<div class="footer-left layout-padding">

			<?php if ( function_exists( 'bright_autonomy_render_footer_logo' ) ) : ?>
				<?php bright_autonomy_render_footer_logo(); ?>
			<?php endif; ?>

			<?php if ( function_exists( 'bright_autonomy_render_footer_copyright' ) ) : ?>
				<?php bright_autonomy_render_footer_copyright(); ?>
			<?php endif; ?>

		</div>

		<div class="footer-right layout-padding">

			<?php if ( function_exists( 'bright_autonomy_render_social_medias' ) ) : ?>
				<?php bright_autonomy_render_social_medias(); ?>
			<?php endif; ?>

			<?php if ( function_exists( 'bright_autonomy_render_footer_menu' ) ) : ?>
				<?php bright_autonomy_render_footer_menu( [ 'location' => 'footerMenu', 'show_title' => false ] ); ?>
			<?php endif; ?>

		</div>
	</div>

</footer>

</div><!-- #page -->

<?php bright_autonomy_render_mobile_navigation(); ?>

<button class="back-to-top" aria-label="<?php esc_attr_e( 'Back to top', 'bright-autonomy' ); ?>" aria-hidden="true">
	<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 15l-6-6-6 6"/></svg>
</button>

<?php wp_footer(); ?>

</body>
</html>
