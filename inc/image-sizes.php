<?php
/**
 * @package bright-autonomy
 */

add_action( 'after_setup_theme', 'bright_autonomy_register_image_sizes' );
function bright_autonomy_register_image_sizes() {
	add_image_size( 'bright-300',  300,  9999, false );
	add_image_size( 'bright-600',  600,  9999, false );
	add_image_size( 'bright-900',  900,  9999, false );
	add_image_size( 'bright-1200', 1200, 9999, false );
	add_image_size( 'bright-1600', 1600, 9999, false );
}

// ─────────────────────────────────────────────────────────────────
// DISABLE WORDPRESS DEFAULT SIZES
// ─────────────────────────────────────────────────────────────────

add_filter( 'intermediate_image_sizes_advanced', function( $sizes ) {
	unset( $sizes['medium'] );
	unset( $sizes['medium_large'] );
	unset( $sizes['large'] );
	unset( $sizes['1536x1536'] );
	unset( $sizes['2048x2048'] );
	return $sizes;
} );

// ─────────────────────────────────────────────────────────────────
// SRCSET + WEBP
// ─────────────────────────────────────────────────────────────────

add_filter( 'max_srcset_image_width', function() {
	return 3840;
} );

add_filter( 'mime_types', function( $mimes ) {
	$mimes['webp'] = 'image/webp';
	$mimes['svg']  = 'image/svg+xml';
	return $mimes;
} );

add_filter( 'upload_mimes', function( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
} );
