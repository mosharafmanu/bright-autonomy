<?php 
    $title          = get_sub_field( 'features_grid_title' );           // ACF Text Field : Section Title
    $body           = get_sub_field( 'features_grid_body' );            // ACF Text Area Field : Section Body
    $column_count   = get_sub_field( 'columns' ) ?: '3';                // ACF Button Group Field : Grid Column 2,3,4
    $content_center = get_sub_field( 'text_align_center' );             // ACF True / False Field : Content Align Center
    $feature_items  = get_sub_field( 'feature_content_items' );         // ACF Repeater Field : Feature Items
    $section_bg     = get_sub_field( 'feature_section_bg' );            // ACF True / False Field : Section Background

    $section_classes = [
        'feature-content-section mt-50 mt-lg-85 pt-50 pb-50 pt-lg-70 pb-lg-90',
        'layout-padding',
    ];
    if ( $section_bg ) {
        $section_classes[] = 'feature-section-bg';
    }


    $classes = [
        'columns-' . $column_count,
    ];

    if ( $content_center ) {
        $classes[] = 'text-center';
    }

?>


<section class="<?php echo esc_attr( implode( ' ', $section_classes ) ); ?>">
    <div class="mc-container">
         <div class="feature-content-inner">
            <div class="feature-content-content">
                
                <?php if ($title): ?>
                    <h2 class="feature-content-title text-center"><?php echo wp_kses($title, ['br' => []]); ?></h2>
                <?php endif; ?>
                
                <?php if ($body): ?>
                    <p class="feature-content-body"><?php echo wp_kses($body, ['br' => []]); ?></p>
                <?php endif; ?>
                
            </div>

            <div class="feature-content-items-wrap">
                
                <?php if ($feature_items) : ?>
                    <div class="feature-content-boxes <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
                        <?php foreach ($feature_items as $item): ?>

                            <?php
                                $feature_icon = $item['feature_content_grid_icon'] ?? [];
                                $icon_name = $item['name'] ?? '';
                                $title = $item['feature_content_grid_title'] ;
                                $body = $item['feature_content_grid_body'] ;

                                if (empty($feature_icon) || !function_exists('bright_autonomy_render_icon')) {
                                    continue;
                                }
                                ?>

                            <div class="feature-content-box">

                                <div class="feature-box-icon">
                                    <?php
                                    bright_autonomy_render_icon(
                                        $feature_icon,
                                        [
                                            'class' => 'feature-content-logo',
                                            'alt'   => $icon_name,
                                        ]
                                    );
                                    ?>
                                </div>

                                <div class="feature-box-content">

                                    <?php if ($title): ?>
                                        <h3 class=" feature-content-title h5-style"><?php echo esc_html( $title ); ?></h3>
                                    <?php endif; ?>

                                    <?php if ($body): ?>
                                        <p class="feature-content-description"><?php echo esc_html( $body ); ?></p>
                                    <?php endif; ?>

                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
