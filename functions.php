<?php
/**
 * @package bright-autonomy
 */

if ( ! defined( 'BRIGHT_AUTONOMY_VERSION' ) ) {
	define( 'BRIGHT_AUTONOMY_VERSION', '1.0.43' );
}


// ─────────────────────────────────────────────────────────────────
// ACF DEPENDENCY CHECK
// This theme requires Advanced Custom Fields (free or pro).
// Without it the dispatcher, section builder, and all settings
// helpers are non-functional. Fail loudly rather than silently.
// ─────────────────────────────────────────────────────────────────

add_action( 'admin_notices', function () {
	if ( class_exists( 'ACF' ) ) {
		return;
	}

	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	$install_url = admin_url( 'plugin-install.php?s=advanced+custom+fields&tab=search&type=term' );
	?>
	<div class="notice notice-error">
		<p>
			<?php
			printf(
				wp_kses(
					/* translators: %s: URL to plugin installer */
					__( '<strong>Bright Autonomy requires Advanced Custom Fields.</strong> The page builder, section templates, and all site settings depend on it. <a href="%s">Install ACF Free &rarr;</a>', 'bright-autonomy' ),
					[
						'strong' => [],
						'a'      => [ 'href' => [] ],
					]
				),
				esc_url( $install_url )
			);
			?>
		</p>
	</div>
	<?php
} );


// ─────────────────────────────────────────────────────────────────
// THEME SETUP
// ─────────────────────────────────────────────────────────────────

function bright_autonomy_setup() {
	load_theme_textdomain( 'bright-autonomy', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 400,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

	register_nav_menus( array(
		'mainMenu'   => esc_html__( 'Main Menu',   'bright-autonomy' ),
		'footerMenu' => esc_html__( 'Footer Menu', 'bright-autonomy' ),
	) );

	// Controls max width for oEmbed — should match --bright-container-max.
	$GLOBALS['content_width'] = 1440;
}
add_action( 'after_setup_theme', 'bright_autonomy_setup' );


// ─────────────────────────────────────────────────────────────────
// WIDGET AREAS
// ─────────────────────────────────────────────────────────────────

function bright_autonomy_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'bright-autonomy' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'bright_autonomy_widgets_init' );


// ─────────────────────────────────────────────────────────────────
// SCRIPTS & STYLES
// ─────────────────────────────────────────────────────────────────

function bright_autonomy_scripts() {
	// Slick (carousel) ships its CSS + JS only on pages that actually render a
	// carousel — see bright_autonomy_page_needs_slick(). Base core renders none, so it
	// is off by default; the assets stay registered so a child theme / filter /
	// render-time enqueue can opt in. scripts.js self-guards when Slick is absent.
	$needs_slick = function_exists( 'bright_autonomy_page_needs_slick' ) && bright_autonomy_page_needs_slick();

	// ── Fonts ────────────────────────────────────────────────────
	wp_enqueue_style(
		'bright-autonomy-fonts',
		'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap',
		array(),
		null,
		'all'
	);

	// ── Core CSS ─────────────────────────────────────────────────
	wp_enqueue_style( 'bright-autonomy-spacer',         get_template_directory_uri() . '/assets/css/spacer.css',                        array(), BRIGHT_AUTONOMY_VERSION );
	wp_enqueue_style( 'bright-autonomy-utilities',      get_template_directory_uri() . '/assets/css/utilities.css',                     array(), BRIGHT_AUTONOMY_VERSION );
	// Video CSS is registered, not enqueued — bright_autonomy_render_video() pulls it in at
	// render time (like the video JS below), so pages without a video ship neither.
	wp_register_style( 'bright-autonomy-video',         get_template_directory_uri() . '/assets/css/video-behaviors.css',               array(), BRIGHT_AUTONOMY_VERSION );
	wp_register_style( 'bright-autonomy-video-popup',   get_template_directory_uri() . '/assets/css/video-popup.css',                   array(), BRIGHT_AUTONOMY_VERSION );
	// Registered always so they can be opted in; enqueued only where needed.
	wp_register_style( 'slick-carousel',              get_template_directory_uri() . '/assets/css/slick.css',                         array(), BRIGHT_AUTONOMY_VERSION );
	wp_register_style( 'bright-autonomy-slick-custom',  get_template_directory_uri() . '/assets/css/bright-autonomy-slick-custom.css',    array( 'slick-carousel' ), BRIGHT_AUTONOMY_VERSION );
	if ( $needs_slick ) {
		wp_enqueue_style( 'slick-carousel' );
		wp_enqueue_style( 'bright-autonomy-slick-custom' );
	}
	wp_enqueue_style( 'bright-autonomy-design-style',   get_template_directory_uri() . '/assets/css/bright-autonomy-design-style.css',    array(), BRIGHT_AUTONOMY_VERSION );
	wp_enqueue_style( 'bright-autonomy-form-style',    get_template_directory_uri() . '/assets/css/bright-autonomy-form.css',             array(), BRIGHT_AUTONOMY_VERSION );
	wp_enqueue_style( 'bright-autonomy-starter-style',  get_template_directory_uri() . '/assets/css/bright-autonomy-starter-style.css',   array(), BRIGHT_AUTONOMY_VERSION );
	wp_enqueue_style( 'bright-autonomy-imran',          get_template_directory_uri() . '/imran.css',                                    array(), BRIGHT_AUTONOMY_VERSION );
	wp_enqueue_style( 'bright-autonomy-faisal',         get_template_directory_uri() . '/faisal.css',                                   array(), BRIGHT_AUTONOMY_VERSION );
	wp_enqueue_style( 'bright-autonomy-style',          get_stylesheet_uri(),                                                           array(), BRIGHT_AUTONOMY_VERSION );

	// ── Core JS ──────────────────────────────────────────────────
	// Slick JS: registered always, enqueued only where a carousel renders.
	// scripts.js no longer hard-depends on it (its carousel init self-guards when
	// $.fn.slick is absent), so scripts.js loads everywhere while Slick is gated.
	wp_enqueue_style( 'slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css' , array(), null	);
	
    wp_enqueue_script( 'slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), null, true );
	
	wp_register_script( 'slick-carousel',             get_template_directory_uri() . '/assets/js/slick.js',                       array( 'jquery' ), BRIGHT_AUTONOMY_VERSION, true );
	if ( $needs_slick ) {
		wp_enqueue_script( 'slick-carousel' );
	}
	wp_enqueue_script( 'bright-autonomy-scripts',         get_template_directory_uri() . '/assets/js/scripts.js',                   array( 'jquery' ), BRIGHT_AUTONOMY_VERSION, true );

	// Video JS is registered, not enqueued — bright_autonomy_render_video() pulls in only
	// what a rendered video needs (behaviors always; popup for onclick-popup; the
	// Vimeo player only for a vimeo source), so video-free pages ship none.
	wp_register_script( 'jquery-vimeo-player',         get_template_directory_uri() . '/assets/js/jquery.mb.vimeo_player.min.js', array( 'jquery' ), BRIGHT_AUTONOMY_VERSION, true );
	wp_register_script( 'bright-autonomy-video-behaviors', get_template_directory_uri() . '/assets/js/video-behaviors.js',           array( 'jquery' ), BRIGHT_AUTONOMY_VERSION, true );
	wp_register_script( 'bright-autonomy-video-popup',     get_template_directory_uri() . '/assets/js/video-popup.js',               array( 'jquery' ), BRIGHT_AUTONOMY_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'bright_autonomy_scripts' );


// ─────────────────────────────────────────────────────────────────
// Move jQuery to the footer so it stops blocking the first paint.
// WordPress loads jQuery render-blocking in <head> by default; every
// jQuery-dependent script here (scripts.js, slick, CF7) already loads in the
// footer, so dependency order is preserved. Skips admin.
// ─────────────────────────────────────────────────────────────────

function bright_autonomy_jquery_to_footer() {
	if ( is_admin() ) {
		return;
	}

	$scripts = wp_scripts();
	foreach ( array( 'jquery', 'jquery-core', 'jquery-migrate' ) as $handle ) {
		if ( isset( $scripts->registered[ $handle ] ) ) {
			$scripts->add_data( $handle, 'group', 1 );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'bright_autonomy_jquery_to_footer', 100 );


// ─────────────────────────────────────────────────────────────────
// CONTACT FORM 7 — load its CSS/JS only where a form renders.
// CF7 enqueues site-wide by default; bright_autonomy_page_needs_contact_form()
// detects the [contact-form-7] shortcode on the queried object (and is
// filterable), so every other page ships none of CF7's CSS/JS.
// ─────────────────────────────────────────────────────────────────

function bright_autonomy_cf7_conditional_assets( $load ) {
	if ( ! function_exists( 'bright_autonomy_page_needs_contact_form' ) ) {
		return $load;
	}
	return bright_autonomy_page_needs_contact_form() ? $load : false;
}
add_filter( 'wpcf7_load_js',  'bright_autonomy_cf7_conditional_assets' );
add_filter( 'wpcf7_load_css', 'bright_autonomy_cf7_conditional_assets' );


// ─────────────────────────────────────────────────────────────────
// EDITOR — Gutenberg disabled; theme uses ACF Flexible Content
// ─────────────────────────────────────────────────────────────────

add_filter( 'use_block_editor_for_post_type', '__return_false' );
add_filter( 'use_block_editor_for_post',      '__return_false' );

add_action( 'after_setup_theme', function() {
	remove_theme_support( 'widgets-block-editor' );
} );

add_action( 'wp_enqueue_scripts', function() {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'classic-theme-styles' );
}, 100 );

add_action( 'admin_enqueue_scripts', function() {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
}, 100 );


// ─────────────────────────────────────────────────────────────────
// ACF JSON SYNC
// ─────────────────────────────────────────────────────────────────

add_filter( 'acf/settings/save_json', function( $path ) {
	return get_stylesheet_directory() . '/acf-json';
} );

add_filter( 'acf/settings/load_json', function( $paths ) {
	unset( $paths[0] );
	$paths[] = get_stylesheet_directory() . '/acf-json';
	return $paths;
} );


// ─────────────────────────────────────────────────────────────────
// CORE INCLUDES
// ─────────────────────────────────────────────────────────────────

require get_template_directory() . '/inc/image-sizes.php';

foreach ( glob( get_template_directory() . '/inc/components/*/*.php' ) as $file ) {
	require $file;
}

foreach ( glob( get_template_directory() . '/inc/helper-functions/*.php' ) as $file ) {
	require $file;
}


// ─────────────────────────────────────────────────────────────────
// WOOCOMMERCE
// Self-contained, optional module — see inc/woocommerce/woocommerce-setup.php.
// Guarded with file_exists() so projects that don't need WooCommerce can
// delete the whole module (that file, woocommerce/, assets/{css,js}/woocommerce/,
// .ai/WOOCOMMERCE.md) without touching this require.
// ─────────────────────────────────────────────────────────────────

$bright_autonomy_woocommerce_setup = get_template_directory() . '/inc/woocommerce/woocommerce-setup.php';
if ( file_exists( $bright_autonomy_woocommerce_setup ) ) {
	require $bright_autonomy_woocommerce_setup;
}


// ─────────────────────────────────────────────────────────────────
// POST CONTENT CLEANUP
// ─────────────────────────────────────────────────────────────────

add_filter( 'the_content', function( $content ) {
	if ( is_admin() || 'post' !== get_post_type() ) {
		return $content;
	}
	return preg_replace( '/(<[^>]+) style=".*?"/i', '$1', $content );
}, 20 );
