<?php
/**
 * Block registration.
 *
 * @package CollegePrograms
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


function college_programs_register_blocks() {
	register_block_type( COLLEGE_PROGRAMS_DIR . 'blocks/program-card' );
	register_block_type( COLLEGE_PROGRAMS_DIR . 'blocks/cta' );
}
add_action( 'init', 'college_programs_register_blocks' );
