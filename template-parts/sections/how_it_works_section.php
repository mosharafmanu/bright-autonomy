<?php 
    $title              = get_sub_field( 'how_it_works_section_title' );         // ACF Text Field : Section Title
    $body               = get_sub_field( 'how_it_works_section_body' );          // ACF Text Area Field : Section Body

    $layout_style       = get_sub_field( 'layout_style' ) ?: 'grid';             // ACF Button Group Field : Layout Style grid/carousel
    $column_count       = get_sub_field( 'column_count' ) ?: '3';                // ACF Button Group Field : Column Count 2,3,4
    $worging_prosess    = get_sub_field( 'working_prosess_boxes' );              // ACF Repeater Field : Working Prosess Boxes Info


    $section_classes = [
        'how-it-works-section-wrapper',
        'mc-container',
        'layout-padding',
        
    ];

    $classes = [
        'columns-' . $column_count,
        'layout-' . $layout_style,
        'mt-30 mt-lg-50'
        
    ];


?>

<section class="how-it-works-section pt-50 pb-50 pt-lg-130 pb-lg-100" >


        <div class="how-it-works-section-content text-center <?php echo esc_attr( implode( ' ', $section_classes ) ); ?> ">

            <?php if ( $title ) : ?>
                <h3 class="how-it-works-section-title h1-style"><?php echo esc_html( $title ); ?></h3>
            <?php endif; ?>

            <?php if ( $body ) : ?>
                <p class="how-it-works-section-body"><?php echo esc_html( $body ); ?></p>
            <?php endif; ?>


        </div>

        <div class="how-it-works-boxes">
            <div class="how-it-works-box-inner <?php echo esc_attr( implode( ' ', $classes ) ); ?> <?php echo esc_attr( implode( ' ', $section_classes ) ); ?>">

                <?php
                    foreach ( $worging_prosess as $index => $card ) : {
                        $title          = $card['how_it_works_title'];
                        $body           = $card['how_it_works_body'];

                        $image          = $card['how_it_works_image'];


                        ?>

                        <div class="how-it-works-box">

                            <?php if ( $image ) : ?>
                                <div class="how-it-works-media-wrapper">
                                    <div class="how-it-works-media media">

                                        <?php
                                        if ( $image && function_exists( 'bright_autonomy_render_responsive_picture' ) ) {
                                            bright_autonomy_render_responsive_picture(
                                                $image,
                                                [
                                                    'class'         => 'how-it-works-image',
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

                            <span class="process-step-number-wrapper">
                                <span class="process-step-number">
                                    <?php echo esc_html( $index + 1 ); ?>
                                </span>
                            </span>

                            <div class="how-it-works-content" >
                            

                                <?php if ($title): ?>
                                    <h3 class="h5-style how-it-works-title"><?php echo wp_kses($title, ['br' => []]); ?></h3>
                                <?php endif; ?>

                                <?php if ($body): ?>
                                    <p class=" how-it-works-body"><?php echo wp_kses($body, ['br' => []]); ?></p>
                                <?php endif; ?>
                                
                            </div>

                        </div>
                        <?php
                        
                    }

                    endforeach; 
            
                ?>

            </div>
        </div>


</section>