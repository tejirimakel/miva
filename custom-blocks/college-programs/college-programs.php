<?php
/**
 * Plugin Name:       College Programs
 * Description:       Registers the Program post type, its ACF field group, and the Program Card and Call to Action blocks. Content lives here so it survives a theme change.
 * Version:           1.0.0
 * Requires at least: 6.3
 * Requires PHP:      7.4
 * Author:            Tejiri Makele
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       college-programs
 *
 * @package CollegePrograms
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'COLLEGE_PROGRAMS_VERSION', '1.0.0' );
define( 'COLLEGE_PROGRAMS_DIR', plugin_dir_path( __FILE__ ) );

require_once COLLEGE_PROGRAMS_DIR . 'includes/post-types.php';
require_once COLLEGE_PROGRAMS_DIR . 'includes/fields.php';
require_once COLLEGE_PROGRAMS_DIR . 'includes/template-functions.php';
require_once COLLEGE_PROGRAMS_DIR . 'includes/blocks.php';

function college_programs_activate() {
	college_programs_register_post_type();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'college_programs_activate' );


function college_programs_deactivate() {
	unregister_post_type( 'program' );
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'college_programs_deactivate' );
