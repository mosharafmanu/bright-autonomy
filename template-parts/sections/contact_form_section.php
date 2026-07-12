<?php 
    $map_embed          = get_sub_field( 'map_embed' );             // ACF Text Area Field : Map Embed 
    $title              = get_sub_field( 'form_section_title' );    // ACF Text Field : Contact Form Section Title
    $body               = get_sub_field( 'form_section_body' );     // ACF Text Area Field : Contact Form Section Body
    $field_notice       = get_sub_field( 'fields_notice' );         // ACF Text Field : Contact Form Requerd Field Notice
    $form_short_code    = get_sub_field( 'form_embed' );             // ACF Text Area Field : Map Embed 
    

    $section_classes = [
        'contact-form-section mt-50 mt-lg-80',
        'mc-container',
        'layout-padding',
        
    ];




?>

<section class="<?php echo esc_attr( implode( ' ', $section_classes ) ); ?>" >
    <div class="contact-form-section-inner">

        <?php if ( $map_embed ) : ?>
            <div class="contact-panel__map">
                <?php echo do_shortcode( $map_embed ); ?>
            </div>
        <?php endif; ?>

        <div class="contact-form-section-info">

            <?php if ( $title ) : ?>
                <h2 class="contact-form-title"><?php echo esc_html( $title ); ?></h2>
            <?php endif; ?>

            <?php if ( $body ) : ?>
                <p class="contact-form-body"><?php echo esc_html( $body ); ?></p>
            <?php endif; ?>

            
        </div>

        <?php if ( $form_short_code ) : ?>
            <div class="contact-form">
                <?php echo do_shortcode( $form_short_code ); ?>
            </div>
        <?php endif; ?>


    </div>


</section>