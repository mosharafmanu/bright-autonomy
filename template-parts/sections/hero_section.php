<?php 
    $hero_title           = get_sub_field('hero_title');          // ACF Text Field : Hero Title
    $hero_description     = get_sub_field('hero_description');    // ACF Text Area Field : Hero Description
    $hero_buttons         = get_sub_field('hero_buttons');        // ACF Repeater Field : Hero Buttons

    $media_type           = get_sub_field('media_type');          // ACF Button Group : Media type image/video 
    $hero_image           = get_sub_field('hero_image');          // ACF Image Field : Hero Image
    $hero_video           = get_sub_field('hero_video');          // ACF File Field : Hero Video

    // Build section classes
    $section_classes = ['hero-section'];
    if ('video' === $media_type && $hero_video) {
        $section_classes[] = 'has-video';
    } elseif ($hero_image) {
        $section_classes[] = 'has-image';
    }




?>

<section class="hero-section mc-container layout-padding">
    <div class="hero-section-inner">
        <div class="hero-conten">

            <?php if ( $hero_title ) : ?>
                <h1 class="hero-title"><?php echo esc_html( $hero_title ) ; ?></h1>
            <?php endif; ?>

            <?php if ( $hero_description ) : ?>
                <p class="hero-description"><?php echo esc_html( $hero_description ) ; ?></p>
            <?php endif; ?>

            <?php
                if ($hero_buttons && function_exists('bright_autonomy_render_buttons')) {
                    bright_autonomy_render_buttons(
                        $hero_buttons,
                        [
                            'wrapper_class' => 'hero-buttons btns',
                            'default_style' => 'primary-btn',
                            'show_icon'     => false,
                        ]
                    );
                }
            ?>

        </div>
        <div class="hero-media">

            <?php if ( $media_type ) : ?>

                <div class="hero-media-wrapper media">

                    <?php if ( 'image' === $media_type && $hero_image ) : ?>

                        <img src="<?php echo esc_url( $hero_image['url'] ); ?>" alt="<?php echo esc_attr( $hero_image['title'] ); ?>">

                    <?php elseif ( 'video' === $media_type && $hero_video ) : ?>
                        
                        <video class="hero-video" muted autoplay loop>
                            <source src="<?php echo esc_url( $hero_video['url'] ); ?>" type="video/mp4">
                            <source src="<?php echo esc_url( $hero_video['url'] ); ?>" type="video/ogg">
                        </video>

                    <?php endif; ?>

                </div>

            <?php endif; ?>

        </div>
    </div>
</section>

