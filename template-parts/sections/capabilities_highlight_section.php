<?php
    $highlight_card     = get_sub_field( 'capabilities_highlight_card' );   // ACF Repeater Field : Capabilities highlight content
    $column_count       = get_sub_field( 'column' ) ?: '3';                 // ACF Button Group Field : Column Count 2,3,4

    $section_classes = [
        'highlight-feature-section pt-50 pb-50 pt-lg-100 pb-lg-100',
        'layout-padding',
        
    ];

    $classes = [
        'columns-' . $column_count,
    ];

    $card_colors = [
        '#F54102', // 1
        '#F6D40A', // 2
        '#53C258', // 3
        '#057B8E', // 4
        '#FF9D00', // 5
        '#1FA0FF', // 6
    ];

?>

<section class="<?php echo esc_attr( implode( ' ', $section_classes ) ); ?>" >
    <div class="mc-container">

    <?php 
        if ( $highlight_card ) :

        $card_index = 0;
    ?>
        
    <div class="highlight-feature-boxes <?php echo esc_attr( implode( ' ', $classes ) ); ?>">

        <?php
            foreach ( $highlight_card as $card ) : {
                $title = $card['capabilities_highlight_title'];
                $body = $card['capabilities_highlight_body'];

                $card_color = $card_colors[ $card_index % count( $card_colors ) ];
                ?>

                <div
                    class="highlight-feature-card"
                    style="--card-bg: <?php echo esc_attr( $card_color ); ?>;"
                >
                    <div class="highlight-feature-content">

                        <?php if ($title): ?>
                            <h3 class="h5-style highlight-card-title"><?php echo wp_kses($title, ['br' => []]); ?></h3>
                        <?php endif; ?>

                        <?php if ($body): ?>
                            <p class=" highlight-card-body"><?php echo wp_kses($body, ['br' => []]); ?></p>
                        <?php endif; ?>

                    </div>
                    
                </div>

                <?php
                $card_index++;
                
            }

            endforeach; 
    
        ?>

    </div>

    <?php endif; ?>
  </div>
</section>