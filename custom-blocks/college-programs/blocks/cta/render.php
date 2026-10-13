<?php
/**
 * Call to Action block: server-side render.
 *
 * WordPress provides $attributes, $content and $block.
 *
 * @package CollegePrograms
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$college_programs_heading = isset( $attributes['heading'] ) ? trim( wp_kses( (string) $attributes['heading'], array() ) ) : '';
$college_programs_text    = isset( $attributes['text'] ) ? trim( wp_kses( (string) $attributes['text'], array( 'strong' => array(), 'em' => array() ) ) ) : '';
$college_programs_label   = isset( $attributes['buttonText'] ) ? trim( wp_strip_all_tags( (string) $attributes['buttonText'] ) ) : '';

if ( '' === $college_programs_heading && '' === $college_programs_text && '' === $college_programs_label ) {
	return;
}

// Relative addresses pass; any scheme outside this list comes back empty.
$college_programs_url = isset( $attributes['buttonUrl'] ) ? esc_url_raw( trim( (string) $attributes['buttonUrl'] ), array( 'http', 'https', 'mailto', 'tel' ) ) : '';
if ( '' === $college_programs_url ) {
	$college_programs_url = (string) get_post_type_archive_link( 'program' );
}
?>
<div <?php echo get_block_wrapper_attributes( array( 'class' => 'college-cta' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Core escapes the attributes. ?>>
	<?php if ( '' !== $college_programs_heading || '' !== $college_programs_text ) : ?>
		<div class="college-cta__text">
			<?php if ( '' !== $college_programs_heading ) : ?>
				<h2 class="college-cta__heading"><?php echo $college_programs_heading; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Passed through wp_kses() above. ?></h2>
			<?php endif; ?>
			<?php if ( '' !== $college_programs_text ) : ?>
				<p class="college-cta__body"><?php echo $college_programs_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Passed through wp_kses() above. ?></p>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	<?php if ( '' !== $college_programs_label && '' !== $college_programs_url ) : ?>
		<a class="college-cta__button" href="<?php echo esc_url( $college_programs_url ); ?>"><?php echo esc_html( $college_programs_label ); ?></a>
	<?php endif; ?>
</div>
