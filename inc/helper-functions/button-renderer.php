<?php
/**
 * @package bright-autonomy
 */

if ( ! function_exists( 'bright_autonomy_get_button_icon_slug' ) ) {
	function bright_autonomy_get_button_icon_slug( $icon ) {
		if ( is_array( $icon ) ) {
			$file_id = isset( $icon['ID'] ) ? absint( $icon['ID'] ) : 0;
			$title   = $file_id ? get_the_title( $file_id ) : '';

			return $title ? sanitize_title( $title ) : 'uploaded';
		}

		if ( is_numeric( $icon ) ) {
			$title = get_the_title( absint( $icon ) );

			return $title ? sanitize_title( $title ) : 'uploaded';
		}

		$slug = is_string( $icon ) ? sanitize_key( $icon ) : '';

		return $slug ?: 'star';
	}
}

if ( ! function_exists( 'bright_autonomy_render_button_icon' ) ) {
	function bright_autonomy_render_button_icon( $icon, $args = [] ) {
		$defaults = [
			'class' => 'btn-icon-image',
			'alt'   => '',
			'echo'  => true,
		];
		$args = wp_parse_args( $args, $defaults );

		ob_start();

		if ( ( is_array( $icon ) || is_numeric( $icon ) ) && function_exists( 'bright_autonomy_render_icon' ) ) {
			$uploaded_icon = bright_autonomy_render_icon(
				$icon,
				[
					'class' => $args['class'],
					'alt'   => $args['alt'],
					'echo'  => false,
				]
			);

			if ( $uploaded_icon ) {
				echo $uploaded_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				get_template_part( 'assets/svgs/star' );
			}
		} else {
			$icon_slug = is_string( $icon ) ? sanitize_key( $icon ) : 'star';
			$icon_slug = $icon_slug ?: 'star';

			if ( ! file_exists( get_theme_file_path( 'assets/svgs/' . $icon_slug . '.php' ) ) ) {
				$icon_slug = 'star';
			}

			get_template_part( 'assets/svgs/' . $icon_slug );
		}

		$output = ob_get_clean();

		if ( $args['echo'] ) {
			echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			return;
		}

		return $output;
	}
}

if ( ! function_exists( 'bright_autonomy_render_button' ) ) {
	function bright_autonomy_render_button( $button_link, $args = [] ) {
		if ( empty( $button_link ) || ! is_array( $button_link ) || empty( $button_link['url'] ) ) {
			return;
		}

		$defaults = [
			'style'     => 'btn-primary',
			'show_icon' => false,
			'icon'      => 'star',
			'class'     => '',
			'echo'      => true,
		];
		$args = wp_parse_args( $args, $defaults );

		$link_url    = $button_link['url'] ?? '';
		$link_title  = $button_link['title'] ?? '';
		$link_target = $button_link['target'] ?? '_self';

		if ( empty( $link_title ) ) {
			return;
		}

		$button_icon      = ! empty( $args['icon'] ) ? $args['icon'] : 'star';
		$button_icon_slug = bright_autonomy_get_button_icon_slug( $button_icon );

		$button_classes = 'site-btn ' . esc_attr( $args['style'] );
		if ( $args['show_icon'] ) {
			$button_classes .= ' has-icon';
		}
		if ( ! empty( $args['class'] ) ) {
			$button_classes .= ' ' . esc_attr( $args['class'] );
		}

		ob_start();
		?>
		<a href="<?php echo esc_url( $link_url ); ?>"
			class="<?php echo esc_attr( $button_classes ); ?>"
			target="<?php echo esc_attr( $link_target ); ?>">
			
			<?php if ( $args['show_icon'] ) : ?>
				<span class="<?php echo esc_attr( 'btn-icon btn-icon--' . $button_icon_slug ); ?>">
					<?php bright_autonomy_render_button_icon( $button_icon ); ?>
				</span>
			<?php endif; ?>
			
			<span class="btn-text"><?php echo esc_html( $link_title ); ?></span>
		</a>
		<?php
		$output = ob_get_clean();

		if ( $args['echo'] ) {
			echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			return $output;
		}
	}
}

if ( ! function_exists( 'bright_autonomy_render_buttons' ) ) {
	function bright_autonomy_render_buttons( $buttons, $args = [] ) {
		if ( empty( $buttons ) || ! is_array( $buttons ) ) {
			return;
		}

		$defaults = [
			'wrapper_class' => 'btns',
			'default_style' => 'btn-primary',
			'show_icon'     => false,
			'default_icon'  => 'star',
			'echo'          => true,
		];
		$args = wp_parse_args( $args, $defaults );

		ob_start();
		?>
		<div class="<?php echo esc_attr( $args['wrapper_class'] ); ?>">
			<?php foreach ( $buttons as $button ) : ?>
				<?php
				$button_link  = $button['button_link'] ?? [];
				$button_style = $button['button_style'] ?? $args['default_style'];
				$show_icon    = array_key_exists( 'button_show_icon', $button ) ? (bool) $button['button_show_icon'] : (bool) $args['show_icon'];
				$button_icon  = ! empty( $button['button_icon'] ) ? $button['button_icon'] : $args['default_icon'];

				if ( empty( $button_link ) || empty( $button_link['url'] ) ) {
					continue;
				}

				if ( function_exists( 'bright_autonomy_render_button' ) ) {
					bright_autonomy_render_button(
						$button_link,
						[
							'style'     => $button_style,
							'show_icon' => $show_icon,
							'icon'      => $button_icon,
							'echo'      => true,
						]
					);
				}
				?>
			<?php endforeach; ?>
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
