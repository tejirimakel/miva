<?php
/**
 * The Program post type.
 *
 * @package CollegePrograms
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the `program` post type.
 */
function college_programs_register_post_type() {
	$labels = array(
		'name'                  => _x( 'Programs', 'post type general name', 'college-programs' ),
		'singular_name'         => _x( 'Program', 'post type singular name', 'college-programs' ),
		'menu_name'             => __( 'Programs', 'college-programs' ),
		'add_new'               => __( 'Add New', 'college-programs' ),
		'add_new_item'          => __( 'Add New Program', 'college-programs' ),
		'edit_item'             => __( 'Edit Program', 'college-programs' ),
		'new_item'              => __( 'New Program', 'college-programs' ),
		'view_item'             => __( 'View Program', 'college-programs' ),
		'view_items'            => __( 'View Programs', 'college-programs' ),
		'search_items'          => __( 'Search Programs', 'college-programs' ),
		'not_found'             => __( 'No programs found.', 'college-programs' ),
		'not_found_in_trash'    => __( 'No programs found in Trash.', 'college-programs' ),
		'all_items'             => __( 'All Programs', 'college-programs' ),
		'archives'              => __( 'Program Archives', 'college-programs' ),
		'featured_image'        => __( 'Program image', 'college-programs' ),
		'set_featured_image'    => __( 'Set program image', 'college-programs' ),
		'remove_featured_image' => __( 'Remove program image', 'college-programs' ),
		'use_featured_image'    => __( 'Use as program image', 'college-programs' ),
		'item_published'        => __( 'Program published.', 'college-programs' ),
		'item_updated'          => __( 'Program updated.', 'college-programs' ),
	);

	register_post_type(
		'program',
		array(
			'labels'       => $labels,
			'description'  => __( 'Academic programs offered by the college.', 'college-programs' ),
			'public'       => true,
			'has_archive'  => true,
			'menu_icon'    => 'dashicons-welcome-learn-more',
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
			'show_in_rest' => true,
			'rest_base'    => 'programs',
			'rewrite'      => array(
				'slug'       => 'programs',
				'with_front' => false,
			),
		)
	);
}
add_action( 'init', 'college_programs_register_post_type' );
