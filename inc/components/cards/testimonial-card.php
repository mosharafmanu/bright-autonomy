<?php
/**
 * Testimonial card component.
 *
 * @package bright-autonomy
 */

if ( ! function_exists( 'bright_autonomy_render_testimonial_card' ) ) {
	function bright_autonomy_render_testimonial_card( $post_id = null, $args = [] ) {
		$post_id = $post_id ? absint( $post_id ) : get_the_ID();

		if ( ! $post_id ) {
			return;
		}

		$defaults = [
			'class' => '',
			'echo'  => true,
		];

		$args             = wp_parse_args( $args, $defaults );
		$icon             = get_field( 'client_logo', $post_id );
		$tagline          = get_field( 'client_tagline', $post_id );
		$title            = get_the_title( $post_id );
		$placeholder_name = $title ?: __( 'Testimonial', 'bright-autonomy' );
		$first_letter     = strtoupper( substr( $placeholder_name, 0, 1 ) );
		$card_classes     = [ 'testimonial-boxe' ];

		if ( $args['class'] ) {
			$card_classes[] = $args['class'];
		}

		ob_start();
		?>

		<div class="<?php echo esc_attr( implode( ' ', array_filter( $card_classes ) ) ); ?>">
			<div class="testimonial-body">
				<?php echo wp_kses_post( apply_filters( 'the_content', get_post_field( 'post_content', $post_id ) ) ); ?>
			</div>

			<div class="testimonial-client">
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
							<?php echo esc_html( $first_letter ); ?>
						</span>
					<?php endif; ?>
				</div>

				<div class="testimonial-client-info">
					<span class="client-name"><?php echo esc_html( $title ); ?></span>
					<p><?php echo esc_html( $tagline ); ?></p>
				</div>
			</div>
		</div>

		<?php
		$output = ob_get_clean();

		if ( $args['echo'] ) {
			echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			return $output;
		}
	}
}
