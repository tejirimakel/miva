<?php
/**
 * Program Card block: server-side render.
 *
 * WordPress provides $attributes, $content and $block.
 *
 * @package CollegePrograms
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$college_programs_id   = isset( $attributes['programId'] ) ? absint( $attributes['programId'] ) : 0;
$college_programs_post = $college_programs_id ? get_post( $college_programs_id ) : null;

$college_programs_ok = $college_programs_post
	&& 'program' === $college_programs_post->post_type
	&& 'publish' === $college_programs_post->post_status
	&& '' === $college_programs_post->post_password;

if ( ! $college_programs_ok ) {
	// The editor preview is fetched over REST; visitors get no output at all.
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST && current_user_can( 'edit_posts' ) ) {
		printf(
			'<p class="college-program-card__notice">%s</p>',
			esc_html(
				$college_programs_id
					? __( 'This program is no longer published, so this card is hidden from visitors. Choose another program or remove the block.', 'college-programs' )
					: __( 'No program selected.', 'college-programs' )
			)
		);
	}
	return;
}

$college_programs_data  = college_programs_get_program_data( $college_programs_id );
$college_programs_title = get_the_title( $college_programs_post );
$college_programs_link  = get_permalink( $college_programs_post );
$college_programs_text  = wp_strip_all_tags( get_the_excerpt( $college_programs_post ) );
$college_programs_tags  = array_filter( array( $college_programs_data['credential'], $college_programs_data['delivery_mode'] ) );
?>
<article <?php echo get_block_wrapper_attributes( array( 'class' => 'college-program-card' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Core escapes the attributes. ?>>
	<?php if ( has_post_thumbnail( $college_programs_post ) ) : ?>
		<?php echo get_the_post_thumbnail( $college_programs_post, 'medium_large', array( 'class' => 'college-program-card__image' ) ); ?>
	<?php endif; ?>
	<div class="college-program-card__body">
		<?php if ( $college_programs_tags ) : ?>
			<ul class="college-program-card__tags">
				<?php foreach ( $college_programs_tags as $college_programs_tag ) : ?>
					<li><?php echo esc_html( $college_programs_tag ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<h3 class="college-program-card__title">
			<a href="<?php echo esc_url( $college_programs_link ); ?>"><?php echo esc_html( $college_programs_title ); ?></a>
		</h3>
		<?php if ( '' !== $college_programs_text ) : ?>
			<p class="college-program-card__summary"><?php echo esc_html( $college_programs_text ); ?></p>
		<?php endif; ?>
		<?php if ( $college_programs_data['application_url'] ) : ?>
			<p class="college-program-card__actions">
				<a class="college-program-card__apply" href="<?php echo esc_url( $college_programs_data['application_url'] ); ?>">
					<?php esc_html_e( 'Apply now', 'college-programs' ); ?><span class="college-program-card__sr">: <?php echo esc_html( $college_programs_title ); ?></span>
				</a>
			</p>
		<?php endif; ?>
	</div>
</article>
