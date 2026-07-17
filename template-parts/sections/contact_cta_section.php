<?php
    $title              = get_sub_field( 'contact_cta_title' );             // ACF Text Field : Content cta Title
    $body               = get_sub_field( 'contact_cta_body' );              // ACF Text Area Field : Content cta Description
    $cta_buttons        = get_sub_field( 'contact_cta_buttons' );           // ACF Repeater Field : Content cta Buttons

    $cta_bg_image       = get_sub_field( 'contact_cta_background_image' );  // ACF image Field : Content cta BG


    $cta_content_classes = [
        'mc-container',
        'layout-padding',
    ];


?>

<?php if ( empty( $cta_buttons ) ) {
    return;
} ?>

<section>
    <div class="contact-cta-section">


        <div class="contact-cta-content <?php echo esc_attr( implode( ' ', $cta_content_classes ) ); ?>">

            <?php if ( $title ) : ?>
                <h2 class="h1-style contact-cta-title"><?php echo esc_html( $title ) ; ?></h2>
            <?php endif; ?>

            <?php if ( $body ) : ?>
                <p class=" contact-cta-description "><?php echo esc_html( $body ) ; ?></p>
            <?php endif; ?>

            <?php
			if ( $cta_buttons && function_exists( 'bright_autonomy_render_buttons' ) ) {
				bright_autonomy_render_buttons(
					$cta_buttons,
					[
						'wrapper_class' => 'cta-buttons btns',
						'default_style' => 'btn-primary',
						'show_icon'     => true,
					]
				);
			}
			?>


        </div>

        <?php if ( $cta_bg_image ) : ?>
			<div class="contact_cta_bg__media media">
				<?php
				if ( function_exists( 'bright_autonomy_render_responsive_picture' ) ) {
					bright_autonomy_render_responsive_picture(
						$cta_bg_image,
						[
							'size'           => 'bright-900',
							'mobile_size'    => 'bright-600',
							'class'          => 'contact_cta_bg__image',
							'lazy'           => true,
							'fetch_priority' => 'auto',
						]
					);
				}
				?>
			</div>
		<?php endif; ?>


    </div>
</section>