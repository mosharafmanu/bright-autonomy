<?php 
    $title              = get_sub_field( 'testimonial_section_title' );     // ACF Text Field : Section Title
    $testimonials       = get_sub_field( 'bright_autonomy_testimonial' );   // ACF Relationship : Testimonial
    $layout_style       = get_sub_field( 'layout_style' ) ?: 'carousel';    // ACF Button Group Field : Layout Style grid/carousel
    $column_count       = get_sub_field( 'column' ) ?: '3';                 // ACF Button Group Field : Column Count 2,3,4
    $testimonial_posts  = [];


    $section_classes = [
        'testimonial-section pt-50 pb-60 pt-lg-100 pb-lg-110',
        'layout-padding',
        
    ];


    $classes = [
        'layout-' . $layout_style,
    ];

    if ( 'grid' === $layout_style ) {
        $classes[] = 'columns-' . $column_count;
    }

    if ( is_array( $testimonials ) && ! empty( $testimonials ) ) {
        foreach ( $testimonials as $testimonial ) {
            $testimonial_id = $testimonial instanceof WP_Post ? $testimonial->ID : absint( $testimonial );

            if ( $testimonial_id ) {
                $testimonial_posts[] = $testimonial_id;
            }
        }
    } else {
        $testimonial_query = new WP_Query(
            [
                'post_type'      => 'testimonial',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'orderby'        => 'menu_order',
                'order'          => 'ASC',
            ]
        );

        if ( $testimonial_query->have_posts() ) {
            $testimonial_posts = wp_list_pluck( $testimonial_query->posts, 'ID' );
        }

        wp_reset_postdata();
    }


?>


<div class="<?php echo esc_attr( implode( ' ', $section_classes ) ); ?>">

   <div class="mc-container">
        <div class="testimonial-section-content text-center">

            <?php if ( $title ) : ?>
                <h4 class="h1-style testimonial-section-title"><?php echo esc_html( $title ); ?></h4>
            <?php endif; ?>

        </div>

        <div class="testimonial-boxes-wrapper">
            <div class="testimonial-boxes <?php echo esc_attr( implode( ' ', $classes ) ); ?>">

                <?php if ( ! empty( $testimonial_posts ) ) : ?>
                    <?php foreach ( $testimonial_posts as $testimonial_post_id ) : ?>
                    <?php
                    if ( function_exists( 'bright_autonomy_render_testimonial_card' ) ) {
                        bright_autonomy_render_testimonial_card( $testimonial_post_id );
                    }
                    ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <?php if ( 'carousel' === $layout_style && count( $testimonial_posts ) > 1 ) : ?>
            <div class="testimonial-navigation" aria-label="<?php esc_attr_e( 'Testimonials navigation', 'bright-autonomy' ); ?>">
                <button class="testimonial-prev" type="button" aria-label="<?php esc_attr_e( 'Previous testimonial', 'bright-autonomy' ); ?>">
                    <?php echo file_get_contents( get_template_directory() . '/assets/svgs/left-arrow.php' ); ?>
                </button>
                <button class="testimonial-next" type="button" aria-label="<?php esc_attr_e( 'Next testimonial', 'bright-autonomy' ); ?>">
                    <?php echo file_get_contents( get_template_directory() . '/assets/svgs/right-arrow.php' ); ?>
                </button>
            </div>
            <?php endif; ?>
        </div>
   </div>


</div>
