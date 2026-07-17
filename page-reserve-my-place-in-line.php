<?php
/**
 * Reserve My Place in Line page.
 *
 * @package bright-autonomy
 */

get_header();

$prefill_email = isset( $_GET['email'] ) ? sanitize_email( wp_unslash( $_GET['email'] ) ) : '';
$reservation   = function_exists( 'bright_get_reserve_by_email' ) && $prefill_email ? bright_get_reserve_by_email( $prefill_email ) : null;
$is_registered = $reservation ? '1' : '0';
$special_code  = isset( $_GET['scode'] ) ? sanitize_text_field( wp_unslash( $_GET['scode'] ) ) : '';

$field_value = static function ( $key ) use ( $reservation, $prefill_email ) {
	if ( 'email' === $key && ! $reservation ) {
		return $prefill_email;
	}

	if ( ! $reservation || ! isset( $reservation->{$key} ) ) {
		return '';
	}

	return $reservation->{$key};
};
?>

<main id="primary" class="site-main page-reserve-my-place-in-line">
	<section class="reserve-hero-section">
		<div class="mc-container reserve-hero-inner">
			<h1 class="reserve-hero-title"><?php esc_html_e( 'Reserve My Place in Line', 'bright-autonomy' ); ?></h1>
		</div>
	</section>

	<section class="reserve-form-section layout-padding">
		<div class="mc-container">
			<form id="form-reserve" class="reserve-form" data-ajax-url="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" novalidate>
				<input type="hidden" name="registered" value="<?php echo esc_attr( $is_registered ); ?>" />
				<?php wp_nonce_field( 'reserve_form_submition', 'nonce_field' ); ?>

				<div class="reserve-step reserve-step-1 <?php echo $reservation ? '' : 'is-active'; ?>" data-reserve-step="1">
					<div class="reserve-step-grid">
						<div class="reserve-step-copy">
							<div class="reserve-step-label"><?php esc_html_e( 'Step 1 of 2', 'bright-autonomy' ); ?></div>
							<?php if ( 'GCSAA' === $special_code ) : ?>
								<h2 class="reserve-special-offer"><?php esc_html_e( 'Congratulations! You qualify to receive a complimentary setup and digitalization service for your golf course. Additionally, this offer includes up to three free machine upgrades, enhancing their functionality to autonomous operation, all available when we reach your area.', 'bright-autonomy' ); ?></h2>
							<?php else : ?>
								<h2><?php esc_html_e( 'Interested in exploring the benefits of Bright Autonomy technology on your golf course?', 'bright-autonomy' ); ?></h2>
							<?php endif; ?>
							<p><?php esc_html_e( 'Please take a moment to share some information about your course and fleet.', 'bright-autonomy' ); ?></p>
							<p><?php esc_html_e( 'Due to high demand, we are currently scheduling fleet upgrades for the 2026 season. We invite you to join our waiting list, to have priority access to our technology once we reach your area.', 'bright-autonomy' ); ?></p>
							<p><?php esc_html_e( 'Your privacy matters to us. Rest assured, any information you provide in this sign-up form is strictly confidential and will not be shared with third parties. We appreciate your trust in us and are committed to safeguarding your data.', 'bright-autonomy' ); ?></p>
						</div>

						<div class="reserve-fields">
							<div class="reserve-field reserve-field-email" data-field="email">
								<div class="reserve-label-row">
									<label for="reserve-email"><?php esc_html_e( 'Email', 'bright-autonomy' ); ?><span>*</span></label>
									<span class="reserve-required-note"><?php esc_html_e( '* Required Field', 'bright-autonomy' ); ?></span>
								</div>
								<input id="reserve-email" type="email" name="email" value="<?php echo esc_attr( $field_value( 'email' ) ); ?>" placeholder="<?php esc_attr_e( 'name@mail.com', 'bright-autonomy' ); ?>" />
								<span class="reserve-error"></span>
							</div>

							<div class="reserve-field-row">
								<div class="reserve-field" data-field="fname">
									<label for="reserve-fname"><?php esc_html_e( 'First Name', 'bright-autonomy' ); ?><span>*</span></label>
									<input id="reserve-fname" type="text" name="fname" value="<?php echo esc_attr( $field_value( 'fname' ) ); ?>" placeholder="<?php esc_attr_e( 'John', 'bright-autonomy' ); ?>" />
									<span class="reserve-error"></span>
								</div>

								<div class="reserve-field" data-field="lname">
									<label for="reserve-lname"><?php esc_html_e( 'Last Name', 'bright-autonomy' ); ?><span>*</span></label>
									<input id="reserve-lname" type="text" name="lname" value="<?php echo esc_attr( $field_value( 'lname' ) ); ?>" placeholder="<?php esc_attr_e( 'Johnson', 'bright-autonomy' ); ?>" />
									<span class="reserve-error"></span>
								</div>
							</div>

							<div class="reserve-field" data-field="pos">
								<label for="reserve-pos"><?php esc_html_e( 'Position', 'bright-autonomy' ); ?><span>*</span></label>
								<input id="reserve-pos" type="text" name="pos" value="<?php echo esc_attr( $field_value( 'position' ) ); ?>" placeholder="<?php esc_attr_e( 'Superintendent', 'bright-autonomy' ); ?>" />
								<span class="reserve-error"></span>
							</div>

							<div class="reserve-field" data-field="golf">
								<label for="reserve-golf"><?php esc_html_e( 'Golf Course Name', 'bright-autonomy' ); ?><span>*</span></label>
								<input id="reserve-golf" type="text" name="golf" value="<?php echo esc_attr( $field_value( 'golfcourse' ) ); ?>" placeholder="<?php esc_attr_e( 'Acme Country Club', 'bright-autonomy' ); ?>" />
								<span class="reserve-error"></span>
							</div>

							<div class="reserve-field" data-field="address">
								<label for="reserve-address"><?php esc_html_e( 'Golf Course Address', 'bright-autonomy' ); ?><span>*</span></label>
								<input id="reserve-address" type="text" name="address" value="<?php echo esc_attr( $field_value( 'address' ) ); ?>" placeholder="<?php esc_attr_e( 'Address', 'bright-autonomy' ); ?>" />
								<span class="reserve-error"></span>
							</div>

							<div class="reserve-field" data-field="phone">
								<label for="reserve-phone"><?php esc_html_e( 'Phone', 'bright-autonomy' ); ?><span>*</span></label>
								<input id="reserve-phone" type="tel" name="phone" value="<?php echo esc_attr( $field_value( 'phone' ) ); ?>" placeholder="<?php esc_attr_e( '123-456-7890', 'bright-autonomy' ); ?>" />
								<span class="reserve-error"></span>
							</div>

							<div class="reserve-step-actions">
								<button type="button" class="reserve-button reserve-next"><?php esc_html_e( 'Next', 'bright-autonomy' ); ?></button>
								<?php if ( is_user_logged_in() && is_super_admin() ) : ?>
									<button type="button" class="reserve-button reserve-save-user"><?php esc_html_e( 'Save User Data', 'bright-autonomy' ); ?></button>
								<?php endif; ?>
							</div>
							<div class="reserve-save-status reserve-status" role="status" aria-live="polite"></div>
						</div>
					</div>
				</div>

				<div class="reserve-step reserve-step-2 <?php echo $reservation ? 'is-active' : ''; ?>" data-reserve-step="2">
					<div class="reserve-step-grid">
						<div class="reserve-step-copy">
							<div class="reserve-step-label"><?php esc_html_e( 'Step 2 of 2', 'bright-autonomy' ); ?></div>
							<h2><?php esc_html_e( 'Tell us about your fleet.', 'bright-autonomy' ); ?></h2>
						</div>

						<div class="reserve-fields">
							<div class="reserve-fleet-wrapper">
								<div class="reserve-fleet-group">
									<div class="reserve-field" data-field="make[]">
										<div class="reserve-label-row">
											<label><?php esc_html_e( 'Make', 'bright-autonomy' ); ?><span>*</span></label>
											<span class="reserve-required-note"><?php esc_html_e( '* Required Field', 'bright-autonomy' ); ?></span>
										</div>
										<input type="text" name="make[]" placeholder="<?php esc_attr_e( 'John Deer', 'bright-autonomy' ); ?>" />
										<span class="reserve-error"></span>
									</div>

									<div class="reserve-field" data-field="model[]">
										<label><?php esc_html_e( 'Model', 'bright-autonomy' ); ?><span>*</span></label>
										<input type="text" name="model[]" placeholder="6080A PrecisionCut&#8482;" />
										<span class="reserve-error"></span>
									</div>

									<div class="reserve-field" data-field="type[]">
										<label><?php esc_html_e( 'Machine Type', 'bright-autonomy' ); ?><span>*</span></label>
										<select name="type[]">
											<option value=""><?php esc_html_e( 'Select Machine Type', 'bright-autonomy' ); ?></option>
											<option value="Ball Picker"><?php esc_html_e( 'Ball Picker', 'bright-autonomy' ); ?></option>
											<option value="Fairway Mower"><?php esc_html_e( 'Fairway Mower', 'bright-autonomy' ); ?></option>
											<option value="Green Mower"><?php esc_html_e( 'Green Mower', 'bright-autonomy' ); ?></option>
											<option value="Roller"><?php esc_html_e( 'Roller', 'bright-autonomy' ); ?></option>
										</select>
										<span class="reserve-error"></span>
									</div>

									<div class="reserve-field" data-field="year[]">
										<label><?php esc_html_e( 'Year of manufacturing', 'bright-autonomy' ); ?><span>*</span></label>
										<input type="text" name="year[]" placeholder="<?php esc_attr_e( '2000', 'bright-autonomy' ); ?>" />
										<span class="reserve-error"></span>
									</div>
								</div>
							</div>

							<button type="button" class="reserve-add-fleet"><?php esc_html_e( '+ Add Another', 'bright-autonomy' ); ?></button>

							<div class="reserve-field reserve-terms-field" data-field="chk-terms-condition">
								<label for="chk-terms-condition">
									<input type="checkbox" id="chk-terms-condition" name="chk-terms-condition" />
									<span>
										<?php esc_html_e( 'By checking this box, I acknowledge that I have read and agree to the', 'bright-autonomy' ); ?>
										<a href="#reserve-terms-modal" class="reserve-terms-link"><?php esc_html_e( 'Terms and Conditions', 'bright-autonomy' ); ?></a>
									</span>
								</label>
								<span class="reserve-error"></span>
							</div>

							<button type="submit" class="reserve-button reserve-submit" disabled><?php esc_html_e( 'Submit', 'bright-autonomy' ); ?></button>
							<div class="reserve-status" role="status" aria-live="polite"></div>
						</div>
					</div>
				</div>

				<div class="reserve-step reserve-step-3" data-reserve-step="3">
					<div class="reserve-step-grid reserve-success-grid">
						<div class="reserve-step-copy reserve-success-copy">
							<h2><?php esc_html_e( 'Your information has been successfully received by a member of our Course Support Team.', 'bright-autonomy' ); ?></h2>
							<p><?php esc_html_e( 'Here is what you can anticipate next: A dedicated member of our Course Support team will promptly get in touch to address your specific requirements, tailor a solution that aligns perfectly with your course needs, and guide you through the retrofitting process for your existing fleet.', 'bright-autonomy' ); ?></p>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="reserve-button reserve-home-link"><?php esc_html_e( 'Return to Home', 'bright-autonomy' ); ?></a>
						</div>

						<div class="reserve-success-video">
							<iframe src="https://www.youtube.com/embed/-LlFCKAUJ8Y" title="<?php esc_attr_e( 'Bright Autonomy video', 'bright-autonomy' ); ?>" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
						</div>
					</div>
				</div>
			</form>
		</div>
	</section>

	<div id="reserve-terms-modal" class="reserve-modal" aria-hidden="true">
		<div class="reserve-modal-backdrop" data-reserve-modal-close></div>
		<div class="reserve-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="reserve-terms-title">
			<button type="button" class="reserve-modal-close" data-reserve-modal-close aria-label="<?php esc_attr_e( 'Close terms', 'bright-autonomy' ); ?>">&times;</button>
			<h2 id="reserve-terms-title"><?php esc_html_e( 'Terms and Conditions', 'bright-autonomy' ); ?></h2>
			<p><strong><?php esc_html_e( 'This represents a Letter of Intent (LOI) to Reserve a Place in Line for Future Purchase', 'bright-autonomy' ); ?></strong></p>
			<p><?php esc_html_e( 'By accepting this agreement, I, in my capacity as a duly authorized representative of our club, formally indicate our intent to enter into discussions regarding the integration of the Bright Autonomy autonomous technology platform, including the necessary hardware, software, management systems, and supervisory services, with our selected turf care machinery currently in operation. Our intention to pursue this engagement is predicated upon Bright Autonomy\'s willingness to extend its sales operations to include our geographic location, as well as the establishment of a mutually agreeable pricing structure.', 'bright-autonomy' ); ?></p>
			<p><?php esc_html_e( 'Should Bright Autonomy\'s preliminary evaluation of the specifications pertaining to our golf course and its associated equipment yield a favorable assessment for the feasible deployment of Bright Autonomy technology, we stand ready to negotiate a definitive agreement. It is understood that the stipulations of such a binding contract will take precedence over any and all provisions set forth in this LOI.', 'bright-autonomy' ); ?></p>
			<p><?php esc_html_e( 'For all intents and purposes, I shall act as the principal liaison for our club in this matter. Please do not hesitate to reach out to me with any questions or concerns.', 'bright-autonomy' ); ?></p>
		</div>
	</div>
</main>

<?php
get_footer();
