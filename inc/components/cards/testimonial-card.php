


<div class="testimonial-boxe ">

    <div class="testimonial-body">
        <?php the_content(); ?>
    </div>

    

    <div class="testimonial-client">
        <?php
            $icon      = get_field( 'client_logo' );
            $tagline   = get_field( 'client_tagline' );

            $placeholder_name = get_the_title();

            $first_latter          = strtoupper( substr( $placeholder_name , 0, 1 )) ;
        ?>

        <div class="testimonial-logo-wrap">
            <?php if ( $icon && function_exists( 'bright_autonomy_render_icon' ) ) : ?>
                <?php
                bright_autonomy_render_icon(
                    $icon,
                    [
                        'class' => 'client-logo',

                    ]
                );
                ?>

            <?php else : ?>
                <span class="avatar-placeholder">
                    <?php echo esc_html( $first_latter ); ?>
                </span>
            <?php endif; ?>
        </div>


        <div class="testimonial-client-info">
            <span class="client-name"><?php the_title(); ?></span>
            <p><?php echo esc_html( $tagline ); ?></p>
        </div>
    </div>
    

</div>
