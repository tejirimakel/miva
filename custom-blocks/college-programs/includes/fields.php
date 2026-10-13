<?php
/**
 * ACF field group for programs.
 *
 * Fields are registered in PHP so they are version-controlled and need no
 * import step. Only field types available in ACF Free are used.
 *
 * @package CollegePrograms
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Credential choices, shared by the field definition and the display helper.
 *
 * @return array<string, string>
 */
function college_programs_credential_choices() {
	return array(
		'certificate' => __( 'Certificate', 'college-programs' ),
		'diploma'     => __( 'Diploma', 'college-programs' ),
		'degree'      => __( 'Degree', 'college-programs' ),
	);
}

/**
 * Delivery mode choices.
 *
 * @return array<string, string>
 */
function college_programs_delivery_mode_choices() {
	return array(
		'on-campus' => __( 'On-campus', 'college-programs' ),
		'online'    => __( 'Online', 'college-programs' ),
		'hybrid'    => __( 'Hybrid', 'college-programs' ),
	);
}

/**
 * Register the field group. `acf/init` only fires when ACF is active, so this
 * never runs (and never fatals) without it.
 */
function college_programs_register_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'          => 'group_college_programs_details',
			'title'        => __( 'Program details', 'college-programs' ),
			'show_in_rest' => 1,
			'position'     => 'normal',
			'location'     => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'program',
					),
				),
			),
			'fields'       => array(
				array(
					'key'           => 'field_college_programs_credential',
					'label'         => __( 'Credential', 'college-programs' ),
					'name'          => 'program_credential',
					'type'          => 'select',
					'choices'       => college_programs_credential_choices(),
					'allow_null'    => 1,
					'return_format' => 'value',
				),
				array(
					'key'   => 'field_college_programs_campus',
					'label' => __( 'Campus', 'college-programs' ),
					'name'  => 'program_campus',
					'type'  => 'text',
				),
				array(
					'key'           => 'field_college_programs_delivery_mode',
					'label'         => __( 'Delivery mode', 'college-programs' ),
					'name'          => 'program_delivery_mode',
					'type'          => 'select',
					'choices'       => college_programs_delivery_mode_choices(),
					'allow_null'    => 1,
					'return_format' => 'value',
				),
				array(
					'key'          => 'field_college_programs_duration',
					'label'        => __( 'Duration', 'college-programs' ),
					'name'         => 'program_duration',
					'type'         => 'text',
					'instructions' => __( 'For example: 2 years full-time.', 'college-programs' ),
				),
				array(
					'key'          => 'field_college_programs_application_url',
					'label'        => __( 'Application URL', 'college-programs' ),
					'name'         => 'program_application_url',
					'type'         => 'url',
					'instructions' => __( 'Optional. Leave empty to hide the apply link.', 'college-programs' ),
				),
			),
		)
	);
}
add_action( 'acf/init', 'college_programs_register_fields' );

/**
 * Tell administrators why the program fields are missing when ACF is off.
 */
function college_programs_acf_missing_notice() {
	if ( function_exists( 'acf_add_local_field_group' ) || ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	$screen = get_current_screen();
	if ( ! $screen || ( 'plugins' !== $screen->id && 'program' !== $screen->post_type ) ) {
		return;
	}

	printf(
		'<div class="notice notice-warning"><p>%s</p></div>',
		esc_html__( 'College Programs: install and activate Advanced Custom Fields to edit program details (credential, campus, delivery mode, duration, application URL). Programs still work without it.', 'college-programs' )
	);
}
add_action( 'admin_notices', 'college_programs_acf_missing_notice' );
