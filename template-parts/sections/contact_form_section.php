<?php
$map_embed       = get_sub_field( 'map_embed' );
$title           = get_sub_field( 'form_section_title' );
$body            = get_sub_field( 'form_section_body' );
$form_short_code = get_sub_field( 'form_embed' );

$section_classes = [
	'contact-form-section mt-50 mt-lg-80 pb-50 pb-lg-80',
	'mc-container',
	'layout-padding',
];

$map_allowed_html = [
	'iframe' => [
		'src'             => true,
		'width'           => true,
		'height'          => true,
		'style'           => true,
		'loading'         => true,
		'allowfullscreen' => true,
		'referrerpolicy'  => true,
		'title'           => true,
		'aria-label'      => true,
	],
	'div'    => [
		'class' => true,
		'id'    => true,
		'style' => true,
	],
	'span'   => [
		'class' => true,
		'id'    => true,
		'style' => true,
	],
];
?>

<section class="<?php echo esc_attr( implode( ' ', $section_classes ) ); ?>">
	<div class="contact-form-section-inner">

		<?php if ( $map_embed ) : ?>
			<div class="contact-panel__map">
				<?php echo wp_kses( do_shortcode( $map_embed ), $map_allowed_html ); ?>
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
