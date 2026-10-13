<?php
/**
 * Custom post types: Scholarships and Testimonials.
 *
 * @package Miva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the `scholarship` and `testimonial` post types.
 */
function miva_register_post_types() {
	register_post_type(
		'scholarship',
		array(
			'labels'       => array(
				'name'          => __( 'Scholarships', 'miva' ),
				'singular_name' => __( 'Scholarship', 'miva' ),
				'add_new_item'  => __( 'Add New Scholarship', 'miva' ),
				'edit_item'     => __( 'Edit Scholarship', 'miva' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'menu_icon'    => 'dashicons-awards',
			'supports'     => array( 'title', 'editor', 'thumbnail' ),
			'show_in_rest' => true,
			'rewrite'      => array( 'slug' => 'scholarships' ),
		)
	);

	register_post_type(
		'testimonial',
		array(
			'labels'       => array(
				'name'          => __( 'Testimonials', 'miva' ),
				'singular_name' => __( 'Testimonial', 'miva' ),
				'add_new_item'  => __( 'Add New Testimonial', 'miva' ),
				'edit_item'     => __( 'Edit Testimonial', 'miva' ),
			),
			'public'       => true,
			'has_archive'  => false,
			'menu_icon'    => 'dashicons-format-quote',
			'supports'     => array( 'title', 'editor', 'thumbnail' ),
			'show_in_rest' => true,
			'rewrite'      => array( 'slug' => 'testimonials' ),
		)
	);
}
add_action( 'init', 'miva_register_post_types' );
