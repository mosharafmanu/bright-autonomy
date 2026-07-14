<?php 
    $title              = get_sub_field( 'testimonial_section_title' );     // ACF Text Field : Section Title

    $testimonials       = get_sub_field( 'bright_autonomy_testimonial' );   // ACF Relation Ship : Testimonial
    $logo               = get_field( 'client_logo' );                       // ACF Image Field : Client Logo
    $layout_style       = get_sub_field( 'layout_style' ) ?: 'carousel';    // ACF Button Group Field : Layout Style grid/carousel
    $column_count       = get_sub_field( 'column' ) ?: '3';                 // ACF Button Group Field : Column Count 2,3,4


    $section_classes = [
        'testimonial-section mt-50 mt-lg-80',
        'mc-container',
        'layout-padding',
        
    ];


    $classes = [
        'layout-' . $layout_style,
    ];

    if ( 'grid' === $layout_style ) {
        $classes[] = 'columns-' . $column_count;
    }


?>


<div class="<?php echo esc_attr( implode( ' ', $section_classes ) ); ?>">

    <div class="testimonial-section-content">

        <?php if ( $title ) : ?>
            <h4 class="h1-style testimonial-section"><?php echo esc_html( $title ); ?></h4>
        <?php endif; ?>

    </div>

    <div class="testimonial-boxes <?php echo esc_attr( implode( ' ', $classes ) ); ?>">

        <?php 
            $testimonial            = new WP_Query(array(
                'post_type'         => 'testimonial',
            ));
        
        ?>

        <?php if ( $testimonial ) : ?>
            <?php if ( $testimonial->have_posts()) : ?>
            <?php while ( $testimonial->have_posts()) : $testimonial->the_post(); ?>

            <?php
            if ( function_exists( 'bright_autonomy_render_testimonial_card' ) ) {
                bright_autonomy_render_testimonial_card();
            }
            ?>


        <?php endwhile; endif; endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>


</div>
