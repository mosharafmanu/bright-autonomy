<?php 
    $eyebrow        = get_sub_field( 'mc5050_eyebrow' );                    // ACF Text Field : Section Eyebrow
    $title          = get_sub_field( 'mc5050_title' );                      // ACF Text Field : Section Title
    $body           = get_sub_field( 'mc5050_body' );                       // ACF WYSIWYG Editor Field : Section Body

    $media_position = get_sub_field( 'mc5050_media_position' ) ?: 'right';  // ACF Button Group Field : Media Position left / right 
    $media_type     = get_sub_field( 'mc5050_media_type' ) ?: 'image';      // ACF Button Group Field : Media Type image / video 
    $image          = get_sub_field( 'mc5050_image' );                      // ACF Image Field : Image
    $video          = get_sub_field( 'mc5050_video' );                      // ACF Group Field : Video
    $section_bg     = get_sub_field( 'mc5050_bg_color' );                   // ACF true/false : Section Background

    $has_image = ( 'image' === $media_type && ! empty( $image ) );
    $has_video = ( 'video' === $media_type && ! empty( $video ) );
    $has_media = $has_image || $has_video;

    $section_classes = [
        'media-content-5050-section',
    ];

    if ( true === $section_bg ) {
        $section_classes[] = 'mc-5050-bg';
    }

    $section_inner_classes = [
        'media-content-5050-inner mt-50 mt-lg-80',
        'mc-container',
        'layout-padding',
        
    ];

    $row_classes = [ 'media-content-5050-row', 'media-' . $media_position ];

?>

<section class="<?php echo esc_attr( implode( ' ', $section_classes ) ); ?>">
    <div class="<?php echo esc_attr( implode( ' ', $section_inner_classes ) ); ?>">

        <div class="<?php echo esc_attr( implode( ' ', $row_classes ) ); ?>">

            <!-- Content column -->
            <div class="mc5050-content">

                <?php if ( $eyebrow ) : ?>
                    <p class="mc5050-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
                <?php endif; ?>

                <?php if ( $title ) : ?>
                    <h2 class="mc5050-title"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>

                <?php if ( $body ) : ?>
                    <div class="mc5050-body wysiwyg-content"><?php echo wp_kses_post( $body ); ?></div>
                <?php endif; ?>

                

            </div>

            <!-- Media column -->
            <?php if ( $has_media ) : ?>
                <div class="mc5050-media media">

                    <?php if ( $has_video && function_exists( 'bright_autonomy_render_video' ) ) : ?>
                        <?php
                        $video_behavior = ! empty( $video['video_behavior'] ) ? $video['video_behavior'] : 'autoplay';
                        bright_autonomy_render_video(
                            $video,
                            [
                                'behavior'           => $video_behavior,
                                'autoplay'           => true,
                                'autoplay_on_scroll' => ! empty( $video['autoplay_on_scroll'] ),
                                'muted'              => true,
                                'loop'               => true,
                                'controls'           => ! empty( $video['controls_visibility'] ),
                                'class'              => 'mc5050-video',
                                'container_class'    => 'mc5050-video-container',
                            ]
                        );
                        ?>

                    <?php elseif ( $has_image && function_exists( 'bright_autonomy_render_responsive_picture' ) ) : ?>
                        <?php
                        bright_autonomy_render_responsive_picture(
                            $image,
                            [
                                'class' => 'mc5050-img',
                                'lazy'  => true,
                                'sizes' => '(max-width: 767px) 100vw, 50vw',
                            ]
                        );
                        ?>
                    <?php endif; ?>

                </div>
            <?php endif; ?>

        </div>

    </div>
</section>
