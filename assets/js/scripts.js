/**
 * Bright Autonomy — Main Theme Scripts
 * @package bright-autonomy
 */

( function ( $ ) {
	'use strict';

	$( function () {

		// ─────────────────────────────────────────────────────────────
		// HEADER OFFSET
		// Sets --header-offset so sticky-aware sections can position
		// themselves. Re-calculated on resize and after fonts load.
		// ─────────────────────────────────────────────────────────────

		const $header = $( '.site-header' );

		function updateHeaderOffset() {
			if ( ! $header.length ) return;
			document.documentElement.style.setProperty(
				'--header-offset',
				$header.outerHeight() + 'px'
			);
		}

		updateHeaderOffset();

		let resizeTimer;
		$( window ).on( 'resize', function () {
			clearTimeout( resizeTimer );
			resizeTimer = setTimeout( updateHeaderOffset, 100 );
		} );

		$( window ).on( 'load', function () {
			setTimeout( updateHeaderOffset, 200 );
		} );


		// ─────────────────────────────────────────────────────────────
		// HEADER SCROLL STATE
		// Adds .is-scrolled after 30px — CSS uses this for compact mode.
		// ─────────────────────────────────────────────────────────────

		if ( $header.length ) {
			const SCROLL_THRESHOLD = 30;

			function handleScroll() {
				$header.toggleClass( 'is-scrolled', $( window ).scrollTop() > SCROLL_THRESHOLD );
			}

			handleScroll();
			$( window ).on( 'scroll', handleScroll );
		}


		// ─────────────────────────────────────────────────────────────
		// MOBILE MENU
		// ─────────────────────────────────────────────────────────────

		const $toggle  = $( '.mobile-menu-toggle' );
		const $mobileNav = $( '.mobile-navigation' );
		const $overlay = $( '.mobile-menu-overlay' );
		const $close   = $( '.mobile-menu-close' );
		const $body    = $( 'body' );

		const FOCUSABLE = 'a[href], button:not([disabled]), input, select, textarea, [tabindex]:not([tabindex="-1"])';

		function openMenu() {
			$mobileNav.addClass( 'is-active' );
			$overlay.addClass( 'is-active' );
			$toggle.addClass( 'is-open' ).attr( 'aria-expanded', 'true' );
			$mobileNav.attr( 'aria-hidden', 'false' );
			$body.addClass( 'no-scroll' );
			// Move focus to first focusable element inside panel
			$mobileNav.find( FOCUSABLE ).first().trigger( 'focus' );
		}

		function closeMenu() {
			$mobileNav.removeClass( 'is-active' );
			$overlay.removeClass( 'is-active' );
			$toggle.removeClass( 'is-open' ).attr( 'aria-expanded', 'false' );
			$mobileNav.attr( 'aria-hidden', 'true' );
			$body.removeClass( 'no-scroll' );
			$toggle.trigger( 'focus' );
		}

		function isMenuOpen() {
			return $mobileNav.hasClass( 'is-active' );
		}

		$toggle.on( 'click', function () {
			isMenuOpen() ? closeMenu() : openMenu();
		} );

		$close.on( 'click', closeMenu );
		$overlay.on( 'click', closeMenu );

		// Close when resizing back to desktop
		$( window ).on( 'resize', function () {
			if ( isMenuOpen() && $( window ).width() >= 992 ) {
				closeMenu();
			}
		} );

		// Keyboard: Escape closes; Tab traps focus inside panel
		$( document ).on( 'keydown', function ( e ) {
			if ( ! isMenuOpen() ) return;

			if ( e.key === 'Escape' ) {
				closeMenu();
				return;
			}

			if ( e.key === 'Tab' ) {
				const $focusable = $mobileNav.find( FOCUSABLE ).filter( ':visible' );
				const $first = $focusable.first();
				const $last  = $focusable.last();

				if ( e.shiftKey && $( document.activeElement ).is( $first ) ) {
					e.preventDefault();
					$last.trigger( 'focus' );
				} else if ( ! e.shiftKey && $( document.activeElement ).is( $last ) ) {
					e.preventDefault();
					$first.trigger( 'focus' );
				}
			}
		} );


		// ─────────────────────────────────────────────────────────────
		// MOBILE SUBMENU TOGGLES
		// Reuses the submenu indicator already rendered inside parent links
		// and handles expand / collapse with aria state.
		// ─────────────────────────────────────────────────────────────

		$( '.mobile-menu li.menu-item-has-children' ).each( function () {
			const $li      = $( this );
			const $submenu = $li.children( '.sub-menu' ).hide();
			const $link    = $li.children( 'a' );
			const $toggle  = $link.children( '.submenu-indicator' );

			$toggle
				.attr( {
					'aria-hidden':   'false',
					'aria-expanded': 'false',
					'aria-label':    'Toggle submenu',
					role:            'button',
					tabindex:        '0',
				} );

			function toggleSubmenu( e ) {
				e.preventDefault();
				e.stopPropagation();

				const isExpanded = $toggle.attr( 'aria-expanded' ) === 'true';

				// Close all other open submenus
				$( '.mobile-menu li.menu-item-has-children' ).not( $li ).each( function () {
					$( this ).children( '.sub-menu' ).slideUp( 300 );
					$( this ).removeClass( 'is-open' ).children( 'a' ).children( '.submenu-indicator' ).attr( 'aria-expanded', 'false' );
				} );

				$li.toggleClass( 'is-open', ! isExpanded );
				$toggle.attr( 'aria-expanded', String( ! isExpanded ) );
				$submenu.slideToggle( 300 );
			}

			$toggle.on( 'click', toggleSubmenu );
			$toggle.on( 'keydown', function ( e ) {
				if ( e.key === 'Enter' || e.key === ' ' ) {
					toggleSubmenu( e );
				}
			} );
		} );


		// ─────────────────────────────────────────────────────────────
		// DESKTOP NAV — KEYBOARD ACCESSIBILITY
		// Arrow keys navigate items; Escape closes open dropdowns.
		// ─────────────────────────────────────────────────────────────

		$( '.main-menu > li.menu-item-has-children > a' ).on( 'keydown', function ( e ) {
			if ( e.key !== 'ArrowDown' && e.key !== 'Enter' ) return;
			if ( e.key === 'Enter' && $( this ).attr( 'href' ) !== '#' ) return;

			e.preventDefault();
			const $submenu = $( this ).siblings( '.sub-menu' );
			$submenu.find( 'a' ).first().trigger( 'focus' );
		} );

		$( '.main-menu .sub-menu a' ).on( 'keydown', function ( e ) {
			const $links  = $( this ).closest( '.sub-menu' ).find( 'a' );
			const index   = $links.index( this );

			if ( e.key === 'ArrowDown' ) {
				e.preventDefault();
				$links.eq( index + 1 ).trigger( 'focus' );
			} else if ( e.key === 'ArrowUp' ) {
				e.preventDefault();
				if ( index === 0 ) {
					$( this ).closest( '.sub-menu' ).siblings( 'a' ).trigger( 'focus' );
				} else {
					$links.eq( index - 1 ).trigger( 'focus' );
				}
			} else if ( e.key === 'Escape' ) {
				$( this ).closest( '.sub-menu' ).siblings( 'a' ).trigger( 'focus' );
			}
		} );


		// ─────────────────────────────────────────────────────────────
		// READING PROGRESS (single post)
		// Fills as the article scrolls through the viewport.
		// ─────────────────────────────────────────────────────────────

		const $progressBar = $( '.reading-progress__bar' );
		const $article     = $( '.single-post' );

		if ( $progressBar.length && $article.length ) {
			const updateProgress = function () {
				const articleTop = $article.offset().top;
				const start      = articleTop;
				const end        = articleTop + $article.outerHeight() - $( window ).height();
				const scrolled   = $( window ).scrollTop();
				const ratio      = end > start ? ( scrolled - start ) / ( end - start ) : 1;
				const clamped    = Math.max( 0, Math.min( 1, ratio ) );
				$progressBar.css( 'width', ( clamped * 100 ) + '%' );
			};

			$( window ).on( 'scroll.readingProgress resize.readingProgress', updateProgress );
			updateProgress();
		}


		// ─────────────────────────────────────────────────────────────
		// SMOOTH SCROLL TO ANCHOR
		// Offset accounts for sticky header height.
		// ─────────────────────────────────────────────────────────────

		$( 'a[href^="#"]' ).on( 'click', function ( event ) {
			// Ignore programmatic triggers (e.g. WooCommerce activating its
			// description/reviews tabs via $(...).trigger('click') on load) —
			// only react to genuine user clicks on in-page nav links.
			if ( event.isTrigger ) return;

			const href = $( this ).attr( 'href' );
			if ( ! href || href === '#' || href === '#!' ) return;

			const $target = $( href );
			if ( ! $target.length ) return;

			event.preventDefault();

			const offset = $header.outerHeight() + 20 || 20;
			$( 'html, body' ).animate(
				{ scrollTop: $target.offset().top - offset },
				600,
				'swing'
			);
		} );

		// ─────────────────────────────────────────────────────────────
		// STAGE-PADDING CAROUSEL — TOGGLE TRIGGER CLASSES (MOBILE)
		// Elements opting in via .js-stage-padding get .stagePaddingRight
		// + .itemMargin (the slick spacing helpers in
		// bright-autonomy-slick-custom.css) below 768px, removed above —
		// these are what the carousel init below activates against.
		// ─────────────────────────────────────────────────────────────

		function toggleStagePaddingClasses() {
			const $elements = $( '.js-stage-padding' );
			if ( $( window ).width() <= 767 ) {
				$elements.addClass( 'stagePaddingRight itemMargin' );
			} else {
				$elements.removeClass( 'stagePaddingRight itemMargin' );
			}
		}

		toggleStagePaddingClasses();

		let stagePaddingTimer;
		$( window ).on( 'resize', function () {
			clearTimeout( stagePaddingTimer );
			stagePaddingTimer = setTimeout( toggleStagePaddingClasses, 100 );
		} );


		// ─────────────────────────────────────────────────────────────
		// STAGE-PADDING CAROUSEL — INIT (MOBILE ONLY)
		// Turns any .js-stage-padding grid into a single-slide Slick
		// carousel below 768px and un-slicks it back to a static grid
		// above that breakpoint. Cards inside (.card / .icon-card /
		// .product-card) are equal-heighted while the carousel runs.
		// Add grid-specific exclusions to the .not() list for any grid
		// that ships with its own carousel.
		// ─────────────────────────────────────────────────────────────

		function setEqualHeight() {
			if ( window.innerWidth < 768 ) {
				$( '.js-stage-padding' ).each( function () {
					const $carousel = $( this );
					const $cards    = $carousel.find( '.card, .icon-card, .product-card' );
					let maxHeight   = 0;

					$cards.css( 'height', '' );
					$cards.each( function () {
						maxHeight = Math.max( maxHeight, $( this ).outerHeight() );
					} );
					$cards.css( 'height', maxHeight + 'px' );
				} );
			} else {
				$( '.js-stage-padding .card, .js-stage-padding .icon-card, .js-stage-padding .product-card' ).css( 'height', '' );
			}
		}

		function initStagePaddingCarousel() {
			// Slick is loaded conditionally (see bright_autonomy_page_needs_slick) — bail
			// quietly if it isn't present so stray carousel markup can't throw.
			if ( typeof $.fn.slick !== 'function' ) return;

			const $carousel = $( '.js-stage-padding' ).not( '.latest-news-grid, .related-products-grid, .logo-showcase-grid, .card-grid-carousel' );

			if ( ! $carousel.length ) return;

			if ( window.innerWidth < 768 ) {
				if ( ! $carousel.hasClass( 'slick-initialized' ) ) {
					$carousel.slick( {
						dots:           false,
						arrows:         false,
						infinite:       true,
						speed:          300,
						slidesToShow:   1,
						slidesToScroll: 1,
						adaptiveHeight: false,
						onSetPosition:  setEqualHeight,
					} );

					setTimeout( setEqualHeight, 100 );
				}
			} else if ( $carousel.hasClass( 'slick-initialized' ) ) {
				$carousel.slick( 'unslick' );
				$( '.js-stage-padding .card, .js-stage-padding .icon-card, .js-stage-padding .product-card' ).css( 'height', '' );
			}
		}

		setTimeout( initStagePaddingCarousel, 100 );

		let carouselResizeTimer;
		$( window ).on( 'resize', function () {
			clearTimeout( carouselResizeTimer );
			carouselResizeTimer = setTimeout( initStagePaddingCarousel, 250 );
		} );

	} ); // end document.ready

} )( jQuery );


// ─────────────────────────────────────────────────────────────────
// VIDEO AUTOPLAY ON SCROLL
// Plays/pauses .autoplay-video containers on intersection.
// Kept outside jQuery wrapper — no jQuery dependency needed.
// ─────────────────────────────────────────────────────────────────

document.addEventListener( 'DOMContentLoaded', function () {
	const containers = document.querySelectorAll( '.autoplay-video' );
	if ( ! containers.length ) return;

	const observer = new IntersectionObserver( function ( entries ) {
		entries.forEach( function ( entry ) {
			const video = entry.target.querySelector( 'video' );
			if ( ! video ) return;
			if ( entry.isIntersecting ) {
				video.currentTime = 0;
				video.play().catch( function () {} );
			} else {
				video.pause();
			}
		} );
	}, { threshold: 0.5 } );

	containers.forEach( function ( el ) {
		observer.observe( el );
	} );
} );



// Image Size Calculation for How It's Work Section
window.addEventListener('load', () => {
    const firstBox = document.querySelector('.how-it-works-box');
    const image = firstBox?.querySelector('.how-it-works-image');
    const boxesContainer = document.querySelector('.how-it-works-boxes');

    if (image && boxesContainer) {
        boxesContainer.style.setProperty(
            '--step-position',
            `${image.offsetHeight + 55}px`
        );
    }
});

window.addEventListener('load', () => {
    const boxes = document.querySelectorAll('.how-it-works-box');

    let currentRowTop = null;

    boxes.forEach((box) => {
        const top = box.offsetTop;

        if (top !== currentRowTop) {
            currentRowTop = top;
            box.classList.add('row-start');
        }
    });
});




jQuery(document).ready(function ($) {

    $('.testimonial-boxes-wrapper').each(function () {
        const $wrapper = $(this);
        const $carousel = $wrapper.find('.layout-carousel');

        if (!$carousel.length || typeof $.fn.slick !== 'function') {
            return;
        }

        $carousel.slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            dots: false,
            infinite: true,
			autoplay: true,
			arrows: true,
			prevArrow: $wrapper.find('.testimonial-prev'),
			nextArrow: $wrapper.find('.testimonial-next'),
			responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
				
        });

    });

});


// Reserve My Place in Line form.
jQuery(document).ready(function ($) {
	const $form = $('#form-reserve');

	if (!$form.length) {
		return;
	}

	const $submit = $form.find('.reserve-submit');
	const ajaxUrl = $form.data('ajax-url');

	function setStep(step) {
		$form.find('.reserve-step').removeClass('is-active');
		$form.find('.reserve-step-' + step).addClass('is-active');
	}

	function setFieldError($field, message) {
		$field.addClass('has-error');
		$field.find('.reserve-error').first().text(message);
	}

	function clearFieldError($field) {
		$field.removeClass('has-error');
		$field.find('.reserve-error').first().text('');
	}

	function validateEmail(email) {
		return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
	}

	function validateRequiredField(name, message) {
		const $input = $form.find('[name="' + name + '"]').first();
		const $field = $input.closest('.reserve-field');
		const value = $.trim($input.val());

		if (!value) {
			setFieldError($field, message);
			return false;
		}

		clearFieldError($field);
		return true;
	}

	function validateStepOne() {
		let valid = true;
		const $email = $form.find('[name="email"]');
		const $emailField = $email.closest('.reserve-field');
		const email = $.trim($email.val());

		if (!email) {
			setFieldError($emailField, 'Email Required');
			valid = false;
		} else if (!validateEmail(email)) {
			setFieldError($emailField, 'Email Invalid');
			valid = false;
		} else {
			clearFieldError($emailField);
		}

		valid = validateRequiredField('fname', 'First Name Required') && valid;
		valid = validateRequiredField('lname', 'Last Name Required') && valid;
		valid = validateRequiredField('pos', 'Position Required') && valid;
		valid = validateRequiredField('golf', 'Golf Course Name Required') && valid;
		valid = validateRequiredField('address', 'Golf Course Address Required') && valid;
		valid = validateRequiredField('phone', 'Phone Required') && valid;

		return valid;
	}

	function validateFleetFields() {
		let valid = true;
		const fieldMessages = {
			'make[]': 'Make Required',
			'model[]': 'Model Required',
			'type[]': 'Machine Type Required',
			'year[]': 'Year Required',
		};

		$.each(fieldMessages, function (name, message) {
			$form.find('[name="' + name + '"]').each(function () {
				const $input = $(this);
				const $field = $input.closest('.reserve-field');

				if (!$.trim($input.val())) {
					setFieldError($field, message);
					valid = false;
				} else {
					clearFieldError($field);
				}
			});
		});

		return valid;
	}

	function updateSubmitState() {
		$submit.prop('disabled', !$form.find('[name="chk-terms-condition"]').is(':checked'));
	}

	function setButtonBusy($button, busy, label) {
		if (!$button.length) {
			return;
		}

		if (busy) {
			$button.data('original-text', $button.text()).text(label).prop('disabled', true);
			return;
		}

		$button.text($button.data('original-text') || $button.text()).prop('disabled', false);
	}

	function getStepOnePayload(action) {
		return {
			action: action,
			registered: $form.find('[name="registered"]').val(),
			nonce: $form.find('[name="nonce_field"]').val(),
			email: $form.find('[name="email"]').val(),
			fname: $form.find('[name="fname"]').val(),
			lname: $form.find('[name="lname"]').val(),
			pos: $form.find('[name="pos"]').val(),
			golf: $form.find('[name="golf"]').val(),
			address: $form.find('[name="address"]').val(),
			phone: $form.find('[name="phone"]').val(),
		};
	}

	function buildShareLink() {
		const email = encodeURIComponent($form.find('[name="email"]').val());
		const baseUrl = window.location.href.split('?')[0];

		return baseUrl + '?email=' + email;
	}

	function buildFleetGroup() {
		return [
			'<div class="reserve-fleet-group">',
				'<div class="reserve-field" data-field="make[]">',
					'<label>Make<span>*</span></label>',
					'<input type="text" name="make[]" placeholder="John Deer" />',
					'<span class="reserve-error"></span>',
				'</div>',
				'<div class="reserve-field" data-field="model[]">',
					'<label>Model<span>*</span></label>',
					'<input type="text" name="model[]" placeholder="6080A PrecisionCut\\u2122" />',
					'<span class="reserve-error"></span>',
				'</div>',
				'<div class="reserve-field" data-field="type[]">',
					'<label>Machine Type<span>*</span></label>',
					'<select name="type[]">',
						'<option value="">Select Machine Type</option>',
						'<option value="Ball Picker">Ball Picker</option>',
						'<option value="Fairway Mower">Fairway Mower</option>',
						'<option value="Green Mower">Green Mower</option>',
						'<option value="Roller">Roller</option>',
					'</select>',
					'<span class="reserve-error"></span>',
				'</div>',
				'<div class="reserve-field" data-field="year[]">',
					'<label>Year of manufacturing<span>*</span></label>',
					'<input type="text" name="year[]" placeholder="2000" />',
					'<span class="reserve-error"></span>',
				'</div>',
			'</div>',
		].join('');
	}

	$form.on('keydown', function (event) {
		if (event.key === 'Enter') {
			event.preventDefault();
		}
	});

	$form.on('click', '.reserve-next', function () {
		if (validateStepOne()) {
			setStep(2);
		}
	});

	$form.on('click', '.reserve-save-user', function () {
		const $button = $(this);
		const $status = $form.find('.reserve-save-status');

		$status.removeClass('is-error').text('');

		if (!validateStepOne()) {
			return;
		}

		setButtonBusy($button, true, 'Saving...');
		$status.text('Saving...');

		$.ajax({
			url: ajaxUrl,
			type: 'POST',
			dataType: 'json',
			data: getStepOnePayload('save_user_submition'),
			success: function (response) {
				if (response && response.status === 'success') {
					$form.find('[name="registered"]').val('1');
					$status.html('<p>Link to share.</p><p><a href="' + buildShareLink() + '">' + buildShareLink() + '</a></p>');
					return;
				}

				$status.addClass('is-error').html(((response && response.message) ? response.message : 'Something went wrong. Please try again.') + '<p><a href="' + buildShareLink() + '">' + buildShareLink() + '</a></p>');
			},
			error: function () {
				$status.addClass('is-error').text('Something went wrong. Please try again.');
			},
			complete: function () {
				setButtonBusy($button, false);
			},
		});
	});

	$form.on('click', '.reserve-add-fleet', function () {
		$form.find('.reserve-fleet-wrapper').append(buildFleetGroup());
	});

	$form.on('change', '[name="chk-terms-condition"]', updateSubmitState);
	updateSubmitState();

	$form.on('submit', function (event) {
		event.preventDefault();

		const $status = $form.find('.reserve-status');

		$status.removeClass('is-error').text('');

		if (!validateFleetFields()) {
			return;
		}

		$submit.prop('disabled', true);
		$status.text('Submitting...');

		$.ajax({
			url: ajaxUrl,
			type: 'POST',
			dataType: 'json',
			data: {
				...getStepOnePayload('form_reserve_submition'),
				makes: $form.find('[name="make[]"]').serialize(),
				models: $form.find('[name="model[]"]').serialize(),
				types: $form.find('[name="type[]"]').serialize(),
				years: $form.find('[name="year[]"]').serialize(),
			},
			success: function (response) {
				if (response && response.status === 'success') {
					setStep(3);
					$('.reserve-hero-title').text('Success!');
					$form[0].reset();
					updateSubmitState();
					return;
				}

				$status.addClass('is-error').text((response && response.message) ? response.message : 'Something went wrong. Please try again.');
			},
			error: function () {
				$status.addClass('is-error').text('Something went wrong. Please try again.');
			},
			complete: function () {
				updateSubmitState();
			},
		});
	});

	$('.reserve-terms-link').on('click', function (event) {
		event.preventDefault();
		$('.reserve-modal').addClass('is-open').attr('aria-hidden', 'false');
		$('body').addClass('reserve-modal-open');
	});

	$('[data-reserve-modal-close]').on('click', function () {
		$('.reserve-modal').removeClass('is-open').attr('aria-hidden', 'true');
		$('body').removeClass('reserve-modal-open');
	});

	$(document).on('keydown', function (event) {
		if (event.key === 'Escape') {
			$('.reserve-modal').removeClass('is-open').attr('aria-hidden', 'true');
			$('body').removeClass('reserve-modal-open');
		}
	});
});


	

	
