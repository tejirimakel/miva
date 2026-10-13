<?php
/**
 * Custom meta boxes for the Scholarship and Testimonial post types.
 *
 * Each field is registered with a sanitize callback and saved behind a nonce
 * and capability check.
 *
 * @package Miva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Field definitions, keyed by post type.
 *
 * @return array<string, array<string, array>>
 */
function miva_meta_fields() {
	return array(
		'scholarship' => array(
			'_miva_funder'      => array(
				'label'    => __( 'Funder name', 'miva' ),
				'type'     => 'text',
				'sanitize' => 'sanitize_text_field',
			),
			'_miva_funder_logo' => array(
				'label'    => __( 'Funder logo', 'miva' ),
				'type'     => 'media',
				'sanitize' => 'absint',
			),
			'_miva_amount'      => array(
				'label'    => __( 'Amount (e.g. ₦500,000)', 'miva' ),
				'type'     => 'text',
				'sanitize' => 'sanitize_text_field',
			),
			'_miva_deadline'    => array(
				'label'    => __( 'Deadline', 'miva' ),
				'type'     => 'date',
				'sanitize' => 'sanitize_text_field',
			),
		),
		'testimonial' => array(
			'_miva_person' => array(
				'label'    => __( 'Person name', 'miva' ),
				'type'     => 'text',
				'sanitize' => 'sanitize_text_field',
			),
			'_miva_role'   => array(
				'label'    => __( 'Role / title', 'miva' ),
				'type'     => 'text',
				'sanitize' => 'sanitize_text_field',
			),
		),
	);
}

/**
 * Register the meta keys with REST + sanitize callbacks.
 */
function miva_register_meta() {
	foreach ( miva_meta_fields() as $post_type => $fields ) {
		foreach ( $fields as $key => $field ) {
			register_post_meta(
				$post_type,
				$key,
				array(
					'type'              => ( 'media' === $field['type'] ) ? 'integer' : 'string',
					'single'            => true,
					'show_in_rest'      => true,
					'sanitize_callback' => $field['sanitize'],
					'auth_callback'     => function () {
						return current_user_can( 'edit_posts' );
					},
				)
			);
		}
	}
}
add_action( 'init', 'miva_register_meta' );

/**
 * Add the meta boxes.
 */
function miva_add_meta_boxes() {
	add_meta_box( 'miva_scholarship_details', __( 'Scholarship details', 'miva' ), 'miva_render_meta_box', 'scholarship', 'normal', 'high' );
	add_meta_box( 'miva_testimonial_details', __( 'Testimonial details', 'miva' ), 'miva_render_meta_box', 'testimonial', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'miva_add_meta_boxes' );

/**
 * Render a meta box from the field definitions.
 *
 * @param WP_Post $post Current post.
 */
function miva_render_meta_box( $post ) {
	$fields = miva_meta_fields()[ $post->post_type ] ?? array();
	wp_nonce_field( 'miva_save_meta', 'miva_meta_nonce' );

	echo '<div style="display:grid;gap:12px;">';
	foreach ( $fields as $key => $field ) {
		$value = get_post_meta( $post->ID, $key, true );
		$id    = esc_attr( $key );
		printf( '<p style="margin:0;"><label for="%s"><strong>%s</strong></label><br>', $id, esc_html( $field['label'] ) );

		switch ( $field['type'] ) {
			case 'date':
				printf( '<input type="date" id="%s" name="%s" value="%s" class="widefat">', $id, $id, esc_attr( $value ) );
				break;

			case 'media':
				$preview = $value ? wp_get_attachment_image( (int) $value, 'thumbnail' ) : '';
				printf(
					'<span class="miva-media-preview">%s</span><br>
					<input type="hidden" id="%s" name="%s" value="%s">
					<button type="button" class="button miva-media-select">%s</button>
					<button type="button" class="button miva-media-clear">%s</button>',
					$preview, // wp_get_attachment_image returns escaped markup.
					$id,
					$id,
					esc_attr( $value ),
					esc_html__( 'Select image', 'miva' ),
					esc_html__( 'Clear', 'miva' )
				);
				break;

			default:
				printf( '<input type="text" id="%s" name="%s" value="%s" class="widefat">', $id, $id, esc_attr( $value ) );
		}
		echo '</p>';
	}
	echo '</div>';
}

/**
 * Save the meta values.
 *
 * @param int $post_id Post ID.
 */
function miva_save_meta( $post_id ) {
	if ( ! isset( $_POST['miva_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['miva_meta_nonce'] ) ), 'miva_save_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$post_type = get_post_type( $post_id );
	$fields    = miva_meta_fields()[ $post_type ] ?? array();

	foreach ( $fields as $key => $field ) {
		if ( ! isset( $_POST[ $key ] ) ) {
			continue;
		}
		$raw       = wp_unslash( $_POST[ $key ] );
		$sanitized = call_user_func( $field['sanitize'], $raw );
		if ( '' === $sanitized || 0 === $sanitized ) {
			delete_post_meta( $post_id, $key );
		} else {
			update_post_meta( $post_id, $key, $sanitized );
		}
	}
}
add_action( 'save_post_scholarship', 'miva_save_meta' );
add_action( 'save_post_testimonial', 'miva_save_meta' );

/**
 * Enqueue the WP media picker on the relevant edit screens.
 *
 * @param string $hook Current admin page.
 */
function miva_admin_media_assets( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}
	$screen = get_current_screen();
	if ( ! $screen || ! in_array( $screen->post_type, array( 'scholarship', 'testimonial' ), true ) ) {
		return;
	}
	wp_enqueue_media();
	wp_add_inline_script(
		'media-editor',
		"document.addEventListener('click', function (e) {
			var wrap = e.target.closest('p');
			if (e.target.classList.contains('miva-media-select')) {
				e.preventDefault();
				var frame = wp.media({ multiple: false });
				frame.on('select', function () {
					var att = frame.state().get('selection').first().toJSON();
					wrap.querySelector('input[type=hidden]').value = att.id;
					var url = (att.sizes && att.sizes.thumbnail) ? att.sizes.thumbnail.url : att.url;
					wrap.querySelector('.miva-media-preview').innerHTML = '<img src=\"' + url + '\" style=\"max-width:120px;height:auto;\">';
				});
				frame.open();
			}
			if (e.target.classList.contains('miva-media-clear')) {
				e.preventDefault();
				wrap.querySelector('input[type=hidden]').value = '';
				wrap.querySelector('.miva-media-preview').innerHTML = '';
			}
		});"
	);
}
add_action( 'admin_enqueue_scripts', 'miva_admin_media_assets' );
