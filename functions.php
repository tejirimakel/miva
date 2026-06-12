<?php
/**
 * Miva theme functions and definitions.
 *
 * @package Miva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access.
}

if ( ! defined( 'MIVA_VERSION' ) ) {
	$miva_theme = wp_get_theme();
	define( 'MIVA_VERSION', $miva_theme->get( 'Version' ) ?: '1.0' );
}

/**
 * Theme supports and nav menus.
 */
function miva_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'navigation-widgets', 'search-form', 'gallery', 'caption', 'style', 'script' ) );

	register_nav_menus(
		array(
			'primary-menu' => __( 'Primary Menu', 'miva' ),
		)
	);
}
add_action( 'after_setup_theme', 'miva_setup' );

/**
 * Front-end styles and scripts.
 *
 * Bootstrap and animate.css are pinned and loaded with Subresource Integrity.
 * No jQuery dependency: Bootstrap 5 and main.js are vanilla.
 */
function miva_enqueue_assets() {
	// Third-party CSS (CDN, version-pinned).
	wp_enqueue_style( 'bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css', array(), '5.3.1' );
	wp_enqueue_style( 'animate-css', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css', array(), '4.1.1' );

	// Theme stylesheet (depends on the above so it can override).
	wp_enqueue_style( 'miva-style', get_stylesheet_uri(), array( 'bootstrap-css' ), MIVA_VERSION );

	// Third-party JS (CDN, version-pinned, in footer).
	wp_enqueue_script( 'bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js', array(), '5.3.1', true );

	// Theme script (vanilla, in footer).
	wp_enqueue_script( 'miva-main', get_template_directory_uri() . '/main.js', array(), MIVA_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'miva_enqueue_assets' );

/**
 * Add Subresource Integrity attributes to the CDN assets.
 */
function miva_sri_attributes( $handle, $integrity ) {
	return sprintf( ' integrity="%s" crossorigin="anonymous"', esc_attr( $integrity ) );
}

add_filter(
	'style_loader_tag',
	function ( $tag, $handle ) {
		$map = array(
			'bootstrap-css' => 'sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9',
			'animate-css'   => 'sha384-Gu3KVV2H9d+yA4QDpVB7VcOyhJlAVrcXd0thEjr4KznfaFPLe0xQJyonVxONa4ZC',
		);
		if ( isset( $map[ $handle ] ) ) {
			$tag = str_replace( ' href=', miva_sri_attributes( $handle, $map[ $handle ] ) . ' href=', $tag );
		}
		return $tag;
	},
	10,
	2
);

add_filter(
	'script_loader_tag',
	function ( $tag, $handle ) {
		if ( 'bootstrap-js' === $handle ) {
			$integrity = 'sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm';
			$tag       = str_replace( ' src=', miva_sri_attributes( $handle, $integrity ) . ' src=', $tag );
		}
		return $tag;
	},
	10,
	2
);

// Data-driven content: custom post types and their meta boxes.
require get_template_directory() . '/inc/post-types.php';
require get_template_directory() . '/inc/meta-boxes.php';
