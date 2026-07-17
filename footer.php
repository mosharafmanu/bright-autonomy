<?php
/**
 * @package bright-autonomy
 */

?>

<footer id="colophon" class="site-footer pt-50 pb-50 pt-lg-85 pb-lg-85">

	<div class="mc-container">
		<div class="footer-inner">
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
	</div>

</footer>

</div><!-- #page -->

<?php bright_autonomy_render_mobile_navigation(); ?>

<?php wp_footer(); ?>

</body>
</html>
