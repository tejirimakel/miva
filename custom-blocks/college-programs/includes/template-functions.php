<?php
/**
 * Read helpers for themes and blocks.
 *
 * @package CollegePrograms
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get a program's structured details, ready to escape and print.
 *
 * Values are read with get_post_meta() rather than get_field(): ACF stores
 * these field types as plain post meta, so saved values keep displaying even
 * if ACF is later deactivated.
 *
 * @param int $post_id Program post ID.
 * @return array{credential:string,campus:string,delivery_mode:string,duration:string,application_url:string}
 */
function college_programs_get_program_data( $post_id ) {
	$post_id = (int) $post_id;

	$data = array(
		'credential'      => '',
		'campus'          => '',
		'delivery_mode'   => '',
		'duration'        => '',
		'application_url' => '',
	);

	// Details of a password-protected program stay hidden until it is unlocked.
	if ( 'program' !== get_post_type( $post_id ) || post_password_required( $post_id ) ) {
		return $data;
	}

	$credential   = (string) get_post_meta( $post_id, 'program_credential', true );
	$credentials  = college_programs_credential_choices();
	$delivery     = (string) get_post_meta( $post_id, 'program_delivery_mode', true );
	$delivery_all = college_programs_delivery_mode_choices();

	// Unknown select values are dropped instead of being printed as raw keys.
	$data['credential']    = $credentials[ $credential ] ?? '';
	$data['delivery_mode'] = $delivery_all[ $delivery ] ?? '';
	$data['campus']        = sanitize_text_field( (string) get_post_meta( $post_id, 'program_campus', true ) );
	$data['duration']      = sanitize_text_field( (string) get_post_meta( $post_id, 'program_duration', true ) );

	// esc_url_raw() returns '' for any scheme other than the two allowed here.
	$url = esc_url_raw( trim( (string) get_post_meta( $post_id, 'program_application_url', true ) ), array( 'http', 'https' ) );
	if ( $url && wp_parse_url( $url, PHP_URL_HOST ) ) {
		$data['application_url'] = $url;
	}

	return $data;
}
