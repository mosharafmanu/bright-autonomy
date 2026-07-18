<?php

	$overlay_content			= get_sub_field( 'overlay_content' );				// ACF Button Group : Overlay And Content
    $content_title              = $overlay_content[ 'content_title' ];          		// ACF Text Field : Content Title
    $content_description        = $overlay_content[ 'content_description' ];    		// ACF Text Area Field : Content Description
    $content_buttons            = $overlay_content[ 'content_buttons' ] ;        		// ACF Text Repeater Field : Content Buttons
    $show_content         		= get_sub_field( 'show_content' );          	// ACF Rtue / False Field : BG Overlay

    $background_type            = get_sub_field( 'background_type' ) ?: 'image';  	// ACF Button Group Field : Content BG Type solid/image/video 
    $content_image              = get_sub_field( 'content_image' );          		// ACF Imge Field : Content BG image
    $content_video              = get_sub_field( 'content_video' );          		// ACF Video Field : Content BG video


	$bg_overlay_class = '';
	if ( $show_content === true ) {
		$bg_overlay_class = 'background_overlay';
	}

    $section_classes = [
        'full-width-media-inner',
        'mc-container',
        'layout-padding',
    ];

    if ( 'video' === $background_type && is_array( $content_video ) && ! empty( $content_video ) ) {
        $section_classes[] = 'content-has-video';
    } elseif ( $content_image ) {
        $section_classes[] = 'content-has-image';
    }

?>

<section>
    <div class="full-width-media-section">

		<?php if ( ( 'image' === $background_type && $content_image ) || ( 'video' === $background_type && is_array( $content_video ) && $content_video ) ) : ?>
			<div class="full-width-media-media <?php echo esc_attr( $bg_overlay_class ) ; ?>">
				<div class="full-width-media-media-wrapper media">

					<?php
					if ( 'image' === $background_type && $content_image && function_exists( 'bright_autonomy_render_responsive_picture' ) ) {
						bright_autonomy_render_responsive_picture(
							$content_image,
							[
								'class'         => 'full-width-media-image',
								'sizes'         => '(max-width: 991px) 100vw, 50vw',
								'lazy'          => false,
								'fetchpriority' => 'high',
							]
						);
					} elseif ( 'video' === $background_type && is_array( $content_video ) && $content_video && function_exists( 'bright_autonomy_render_video' ) ) {
						$video_behavior       = $content_video['video_behavior'] ?? 'autoplay';
						$video_autoplay       = array_key_exists( 'video_autoplay', $content_video ) ? ! empty( $content_video['video_autoplay'] ) : true;
						$video_muted          = array_key_exists( 'video_muted', $content_video ) ? ! empty( $content_video['video_muted'] ) : true;
						$video_loop           = array_key_exists( 'video_loop', $content_video ) ? ! empty( $content_video['video_loop'] ) : true;
						$video_popup_autoplay = array_key_exists( 'video_popup_autoplay', $content_video ) ? ! empty( $content_video['video_popup_autoplay'] ) : true;
						$video_popup_controls = array_key_exists( 'video_popup_controls', $content_video ) ? ! empty( $content_video['video_popup_controls'] ) : true;

						bright_autonomy_render_video(
							$content_video,
							[
								'behavior'           => $video_behavior,
								'autoplay'           => $video_autoplay,
								'autoplay_on_scroll' => ! empty( $content_video['video_autoplay_on_scroll'] ),
								'muted'              => $video_muted,
								'loop'               => $video_loop,
								'controls'           => 'autoplay' === $video_behavior && ! empty( $content_video['video_controls'] ),
								'popup_autoplay'     => $video_popup_autoplay,
								'popup_controls'     => $video_popup_controls,
								'class'              => 'full-width-media-video',
								'container_class'    => 'full-width-media-video-wrapper',
							]
						);
					}
					?>

				</div>
			</div>
		<?php endif; ?>

		<?php if ( $show_content) : ?>
        <div class="full-width-media-content <?php echo esc_attr( implode( ' ', $section_classes ) ); ?>">

            <?php if ( $content_title ) : ?>
                <h2 class="h3-style full-width-media-title"><?php echo esc_html( $content_title ) ; ?></h2>
            <?php endif; ?>

            <?php if ( $content_description ) : ?>
                <p class=" full-width-media-description "><?php echo esc_html( $content_description ) ; ?></p>
            <?php endif; ?>

            <?php
			if ( $content_buttons && function_exists( 'bright_autonomy_render_buttons' ) ) {
				bright_autonomy_render_buttons(
					$content_buttons,
					[
						'wrapper_class' => 'full-width-media-buttons btns',
						'default_style' => 'btn-primary',
					]
				);
			}
			?>


        </div>
		<?php endif; ?>
    </div>
</section>
