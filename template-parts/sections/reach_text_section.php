<?php
    $content_title              = get_sub_field( 'content_title' );          // ACF Text Field : Content Title
    $content_description        = get_sub_field( 'content_description' );    // ACF Text Area Field : Content Description
    $content_buttons            = get_sub_field( 'content_buttons' );        // ACF Repeater Field : Content Buttons
    $text_center                = get_sub_field( 'text_center' );            // ACF True / False Field : Text Center


    $section_classes = [
        'content-intro-inner',
        'mc-container',
        'layout-padding',
    ];

    $text_align_class = '';
	if ( $text_center === true ) {
		$text_align_class = 'text-center';
	}


?>

<section>
    <div class="content-intro-section pt-lg-100 pt-50 <?php echo esc_attr( implode( ' ', $section_classes ) ); ?>">


        <div class="content-section-content <?php echo esc_attr( $text_align_class ) ; ?>">

            <?php if ( $content_title ) : ?>
                <h2 class="h3-style content-intro-title"><?php echo esc_html( $content_title ) ; ?></h2>
            <?php endif; ?>

            <?php if ( $content_description ) : ?>
                <p class=" content-intro-description "><?php echo esc_html( $content_description ) ; ?></p>
            <?php endif; ?>

            <?php
			if ( $content_buttons && function_exists( 'bright_autonomy_render_buttons' ) ) {
				bright_autonomy_render_buttons(
					$content_buttons,
					[
						'wrapper_class' => 'content-intro-buttons btns',
						'default_style' => 'btn-primary',
						'show_icon'     => true,
					]
				);
			}
			?>


        </div>
    </div>
</section>