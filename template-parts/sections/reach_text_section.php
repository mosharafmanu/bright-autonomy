<?php
    $content_title              = get_sub_field( 'content_title' );             // ACF Text Field : Content Title
    $content_description        = get_sub_field( 'content_description' );       // ACF Text Area Field : Content Description
    $content_buttons            = get_sub_field( 'content_buttons' );           // ACF Repeater Field : Content Buttons
    $text_center                = get_sub_field( 'text_center' );               // ACF True / False Field : Text Center
    $show_image                 = get_sub_field( 'reach_to_text_bg_image' );    // ACF True / False Field : Text Show Imamge
    $image                      = get_sub_field( 'image' );                     // ACF Image Field : Reach To Text Background Image

    $has_image = ( true === $show_image && ! empty( $image ) );


    $section_classes = [
        'content-intro-inner',
        'mc-container',
        'layout-padding',
    ];

    $text_align_class = '';
	if ( $text_center === true ) {
		$text_align_class = 'text-center';
	}

    $body_text = [];

    if ( ! empty( $content_title ) ) {
        $body_text[] = 'content-intro-width';
    }
    if ( empty( $content_title ) ) {
        $body_text[] = 'font-size-md';
    }

    $section = [];

        if ( ! $has_image ) {
            $section = [
                'pt-50 pb-50 pt-lg-80 pb-lg-100',
            ];
        }

        if ( $has_image ) {
            $section[] = 'has-image';
        }


?>

<section class="content-intro-section <?php echo esc_attr( implode( ' ', $section ) ); ?>">
    <?php if ( $has_image ) : ?>
        <div class="reach-to-text-media-wrapper">
            <div class="reach-to-text-media media">

                <?php
                if ( $image && function_exists( 'bright_autonomy_render_responsive_picture' ) ) {
                    bright_autonomy_render_responsive_picture(
                        $image,
                        [
                            'class'         => 'reach-to-text-image',
                            'sizes'         => '(max-width: 991px) 100vw, 50vw',
                            'lazy'          => false,
                            'fetchpriority' => 'high',
                        ]
                    );
                } 
                
                ?>

            </div>
        </div>
    <?php endif; ?>

    <div class="<?php echo esc_attr( implode( ' ', $section_classes ) ); ?>">
        <div class="content-section-content <?php echo esc_attr( implode( ' ', $body_text ) ); ?> <?php echo esc_attr( $text_align_class ) ; ?>">

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