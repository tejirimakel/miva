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
 * `extra` holds any other ACF fields on the program (for example ones added
 * in the ACF admin), as label/value pairs. See college_programs_get_extra_fields().
 *
 * @param int $post_id Program post ID.
 * @return array{credential:string,campus:string,delivery_mode:string,duration:string,application_url:string,extra:array<int,array{label:string,value:string}>}
 */
function college_programs_get_program_data( $post_id ) {
	$post_id = (int) $post_id;

	$data = array(
		'credential'      => '',
		'campus'          => '',
		'delivery_mode'   => '',
		'duration'        => '',
		'application_url' => '',
		'extra'           => array(),
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

	$url = esc_url_raw( trim( (string) get_post_meta( $post_id, 'program_application_url', true ) ), array( 'http', 'https' ) );
	if ( $url && wp_parse_url( $url, PHP_URL_HOST ) ) {
		$data['application_url'] = $url;
	}

	$data['extra'] = college_programs_get_extra_fields( $post_id );

	return $data;
}

/**
 *
 * Lets editors add fields in the ACF admin (location: Post Type is Program)
 * and have them shown without code changes. Only field types that read as a
 * single line of text are included; images, relationships, repeaters and the
 * like are skipped. To keep a field off the site, give it the wrapper class
 * `program-private` in ACF, or use the `college_programs_extra_fields` filter.
 *
 * @param int $post_id Program post ID.
 * @return array<int, array{label:string,value:string}>
 */
function college_programs_get_extra_fields( $post_id ) {
	if ( ! function_exists( 'get_field_objects' ) ) {
		return array();
	}

	$builtin = array( 'program_credential', 'program_campus', 'program_delivery_mode', 'program_duration', 'program_application_url' );
	$types   = array( 'text', 'textarea', 'number', 'range', 'email', 'url', 'select', 'radio', 'button_group', 'checkbox', 'true_false', 'date_picker', 'date_time_picker', 'time_picker' );
	$extra   = array();

	foreach ( (array) get_field_objects( $post_id ) as $field ) {
		$classes = preg_split( '/\s+/', (string) ( $field['wrapper']['class'] ?? '' ) );

		if ( in_array( $field['name'], $builtin, true )
			|| ! in_array( $field['type'], $types, true )
			|| in_array( 'program-private', $classes, true ) ) {
			continue;
		}

		$value = college_programs_field_value_to_text( $field['value'], $field['type'] );
		$label = sanitize_text_field( (string) $field['label'] );

		if ( '' !== $value && '' !== $label ) {
			$extra[] = array(
				'label' => $label,
				'value' => $value,
			);
		}
	}

	/**
	 * Filter the extra program fields shown on cards and the program page.
	 *
	 * @param array<int, array{label:string,value:string}> $extra   Label/value pairs.
	 * @param int                                          $post_id Program post ID.
	 */
	return (array) apply_filters( 'college_programs_extra_fields', $extra, $post_id );
}

/**
 * Flatten a formatted ACF value into plain text.
 *
 * Choice fields may return a value, a label or a value/label array depending
 * on their return format; the label is preferred when present.
 *
 * @param mixed  $value Formatted field value.
 * @param string $type  ACF field type.
 * @return string
 */
function college_programs_field_value_to_text( $value, $type ) {
	if ( 'true_false' === $type ) {
		return $value ? __( 'Yes', 'college-programs' ) : '';
	}

	if ( is_array( $value ) ) {
		if ( isset( $value['label'] ) ) {
			$value = $value['label'];
		} else {
			$parts = array();
			foreach ( $value as $item ) {
				$parts[] = college_programs_field_value_to_text( $item, '' );
			}
			return implode( ', ', array_filter( $parts, 'strlen' ) );
		}
	}

	if ( ! is_scalar( $value ) ) {
		return '';
	}

	return sanitize_text_field( wp_strip_all_tags( (string) $value ) );
}
