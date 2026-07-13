<?php 
    $title              = get_sub_field( 'image_card_grid_section_title' );         // ACF Text Field : Section Title
    $body               = get_sub_field( 'image_card_grid_section_body' );          // ACF Text Area Field : Section Body

    $column_count       = get_sub_field( 'column_count' ) ?: '2';                   // ACF Button Group Field : Column Count 2,3,4
    $card_grid_box      = get_sub_field( 'image_card_grid_boxes' );                 // ACF Repeater Field : Image Card Grid Boxes Info


    $section_classes = [
        'image-card-grid-section pt-50 pb-60 pt-lg-90 pb-lg-150',
        'layout-padding',
        
    ];

    $classes = [
        'columns-' . $column_count,
        'mt-30 mt-lg-50'
    ];


?>


<section class="<?php echo esc_attr( implode( ' ', $section_classes ) ); ?>"> 
	<div class="mc-container">
		<div class="image-card-grid-section-content ">

			<?php if ( $title ) : ?>
				<h2 class="image-card-grid-section-title h1-style"><?php echo esc_html( $title ); ?></h2>
			<?php endif; ?>

			<?php if ( $body ) : ?>
				<p class="image-card-grid-section-body"><?php echo esc_html( $body ); ?></p>
			<?php endif; ?>


		</div>

        <div class="image-card-grid-boxes <?php echo esc_attr( implode( ' ', $classes ) ); ?>">

            <?php
                foreach ( $card_grid_box as $card ) : {
                    $badge_bg       = $card['highlight_badge_color'];
                    $badge_title    = $card['image_card_highlight_text'];
                    $title          = $card['image_card_grid_title'];
                    $body           = $card['image_card_grid_body'];

                    $media_type     = $card['media_type'] ?: 'image';
                    $image          = $card['image_card_grid_image'];
                    $video          = $card['image_card_grid_video'];


                    $highlight_badge = [
                        ''
                    ];

                    if ( $badge_bg ) {
                        $highlight_badge[] = 'highlight-badge';
                    }
                    
                    if ( 'video' === $media_type && is_array( $video ) && ! empty( $video ) ) {
                        $media_classes[] = 'content-has-video';
                    } elseif ( $image ) {
                        $media_classes[] = 'content-has-image';
                    }   

                    ?>

                    <div class="image-card-grid-box">
                        <div class="image-card-grid-content" >
                            
                            <?php if ($badge_title): ?>
                                <span class="highlight-badge-title <?php echo esc_attr( implode( ' ', $highlight_badge ) ); ?> "><?php echo wp_kses($badge_title, ['br' => []]); ?></span>
                            <?php endif; ?>

                             <div class="image-card-content">
                                <?php if ($title): ?>
                                    <h3 class="h4-style highlight-card-title"><?php echo wp_kses($title, ['br' => []]); ?></h3>
                                <?php endif; ?>

                                <?php if ($body): ?>
                                    <p class=" highlight-card-body"><?php echo wp_kses($body, ['br' => []]); ?></p>
                                <?php endif; ?>
                             </div>
                            
                        </div>

                        <?php if ( ( 'image' === $media_type && $image ) || ( 'video' === $media_type && is_array( $video ) && $video ) ) : ?>
                            <div class="image-card-grid-media <?php echo esc_attr( $media_classes ) ; ?>">
                                <div class="image-card-grid-media-wrapper media">

                                    <?php
                                    if ( 'image' === $media_type && $image && function_exists( 'bright_autonomy_render_responsive_picture' ) ) {
                                        bright_autonomy_render_responsive_picture(
                                            $image,
                                            [
                                                'class'         => 'image-card-grid-image',
                                                'sizes'         => '(max-width: 991px) 100vw, 50vw',
                                                'lazy'          => false,
                                                'fetchpriority' => 'high',
                                            ]
                                        );
                                    } elseif ( 'video' === $media_type && is_array( $video ) && $video && function_exists( 'bright_autonomy_render_video' ) ) {
                                        $video_behavior       = $video['video_behavior'] ?? 'autoplay';
                                        $video_autoplay       = array_key_exists( 'video_autoplay', $video ) ? ! empty( $video['video_autoplay'] ) : true;
                                        $video_muted          = array_key_exists( 'video_muted', $video ) ? ! empty( $video['video_muted'] ) : true;
                                        $video_loop           = array_key_exists( 'video_loop', $video ) ? ! empty( $video['video_loop'] ) : true;
                                        $video_popup_autoplay = array_key_exists( 'video_popup_autoplay', $video ) ? ! empty( $video['video_popup_autoplay'] ) : true;
                                        $video_popup_controls = array_key_exists( 'video_popup_controls', $video ) ? ! empty( $video['video_popup_controls'] ) : true;

                                        bright_autonomy_render_video(
                                            $video,
                                            [
                                                'behavior'           => $video_behavior,
                                                'autoplay'           => $video_autoplay,
                                                'autoplay_on_scroll' => ! empty( $video['video_autoplay_on_scroll'] ),
                                                'muted'              => $video_muted,
                                                'loop'               => $video_loop,
                                                'controls'           => 'autoplay' === $video_behavior && ! empty( $video['video_controls'] ),
                                                'popup_autoplay'     => $video_popup_autoplay,
                                                'popup_controls'     => $video_popup_controls,
                                                'class'              => 'image-card-grid-video',
                                                'container_class'    => 'image-card-grid-video-wrapper',
                                            ]
                                        );
                                    }
                                    ?>

                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                    <?php
                    
                }

                endforeach; 
        
            ?>

        </div>
    </div>
</section>