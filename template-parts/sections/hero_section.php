<?php
/**
 * Hero section.
 *
 * @package bright-autonomy
 */

$hero_title       = get_sub_field( 'hero_title' );
$hero_description = get_sub_field( 'hero_description' );
$hero_buttons     = get_sub_field( 'hero_buttons' );
$media_type       = get_sub_field( 'media_type' ) ?: 'image';
$hero_image       = get_sub_field( 'hero_image' );
$hero_video       = get_sub_field( 'hero_video' );

if ( ! $hero_title && ! $hero_description && ! $hero_buttons && ! $hero_image && ! $hero_video ) {
	return;
}

if ( 'video' === $media_type && is_array( $hero_video ) && empty( $hero_video['video_source'] ) && ! empty( $hero_video['url'] ) ) {
	$hero_video = [
		'video_source'         => 'self_host',
		'video_self_host_file' => $hero_video,
		'video_behavior'       => 'autoplay',
		'video_autoplay'       => true,
		'video_muted'          => true,
		'video_loop'           => true,
	];
}

if ( 'video' === $media_type && is_array( $hero_video ) && empty( $hero_video['video_source'] ) && ! empty( $hero_video['video_self_host_file'] ) ) {
	$hero_video['video_source'] = 'self_host';
}

$section_classes = [
	'hero-section',
	'mc-container',
	'layout-padding',
];

if ( 'video' === $media_type && is_array( $hero_video ) && ! empty( $hero_video ) ) {
	$section_classes[] = 'has-video';
} elseif ( $hero_image ) {
	$section_classes[] = 'has-image';
}
?>

<section class="<?php echo esc_attr( implode( ' ', $section_classes ) ); ?>">
	<div class="hero-section-inner">
		<div class="hero-content">

			<?php if ( $hero_title ) : ?>
				<h1 class="hero-title"><?php echo esc_html( $hero_title ); ?></h1>
			<?php endif; ?>

			<?php if ( $hero_description ) : ?>
				<p class="hero-description"><?php echo esc_html( $hero_description ); ?></p>
			<?php endif; ?>

			<?php
			if ( $hero_buttons && function_exists( 'bright_autonomy_render_buttons' ) ) {
				bright_autonomy_render_buttons(
					$hero_buttons,
					[
						'wrapper_class' => 'hero-buttons btns',
						'default_style' => 'btn-primary',
						'show_icon'     => false,
					]
				);
			}
			?>

		</div>

		<?php if ( ( 'image' === $media_type && $hero_image ) || ( 'video' === $media_type && is_array( $hero_video ) && $hero_video ) ) : ?>
			<div class="hero-media">
				<div class="hero-media-wrapper media">

					<?php
					if ( 'image' === $media_type && $hero_image && function_exists( 'bright_autonomy_render_responsive_picture' ) ) {
						bright_autonomy_render_responsive_picture(
							$hero_image,
							[
								'class'         => 'hero-image',
								'sizes'         => '(max-width: 991px) 100vw, 50vw',
								'lazy'          => false,
								'fetchpriority' => 'high',
							]
						);
					} elseif ( 'video' === $media_type && is_array( $hero_video ) && $hero_video && function_exists( 'bright_autonomy_render_video' ) ) {
						$video_behavior       = $hero_video['video_behavior'] ?? 'autoplay';
						$video_autoplay       = array_key_exists( 'video_autoplay', $hero_video ) ? ! empty( $hero_video['video_autoplay'] ) : true;
						$video_muted          = array_key_exists( 'video_muted', $hero_video ) ? ! empty( $hero_video['video_muted'] ) : true;
						$video_loop           = array_key_exists( 'video_loop', $hero_video ) ? ! empty( $hero_video['video_loop'] ) : true;
						$video_popup_autoplay = array_key_exists( 'video_popup_autoplay', $hero_video ) ? ! empty( $hero_video['video_popup_autoplay'] ) : true;
						$video_popup_controls = array_key_exists( 'video_popup_controls', $hero_video ) ? ! empty( $hero_video['video_popup_controls'] ) : true;

						bright_autonomy_render_video(
							$hero_video,
							[
								'behavior'           => $video_behavior,
								'autoplay'           => $video_autoplay,
								'autoplay_on_scroll' => ! empty( $hero_video['video_autoplay_on_scroll'] ),
								'muted'              => $video_muted,
								'loop'               => $video_loop,
								'controls'           => 'autoplay' === $video_behavior && ! empty( $hero_video['video_controls'] ),
								'popup_autoplay'     => $video_popup_autoplay,
								'popup_controls'     => $video_popup_controls,
								'class'              => 'hero-video',
								'container_class'    => 'hero-video-wrapper',
							]
						);
					}
					?>

				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
