<?php
/**
 * Single program card (used inside the program archive loop).
 *
 * Program details come from the College Programs plugin. If it is inactive
 * the card still renders with the title and summary.
 *
 * @package Miva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$miva_program = function_exists( 'college_programs_get_program_data' ) ? college_programs_get_program_data( get_the_ID() ) : array();
$miva_tags    = array_filter(
	array(
		$miva_program['credential'] ?? '',
		$miva_program['delivery_mode'] ?? '',
	)
);
?>
<li class="program-grid__item">
    <article <?php post_class( 'card program-card h-100' ); ?>>
        <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail( 'medium_large', array( 'class' => 'card-img-top program-card__img' ) ); ?>
        <?php endif; ?>
        <div class="card-body d-flex flex-column">
            <?php if ( $miva_tags ) : ?>
                <ul class="program-card__tags">
                    <?php foreach ( $miva_tags as $miva_tag ) : ?>
                        <li><?php echo esc_html( $miva_tag ); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <h2 class="card-title">
                <a class="stretched-link" href="<?php the_permalink(); ?>"><?php echo wp_kses_post( get_the_title() ); ?></a>
            </h2>
            <?php if ( has_excerpt() || '' !== get_the_content() ) : ?>
                <p class="program-card__summary"><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></p>
            <?php endif; ?>
            <?php if ( ! empty( $miva_program['campus'] ) || ! empty( $miva_program['duration'] ) ) : ?>
                <p class="program-card__meta mt-auto mb-0">
                    <?php echo esc_html( implode( ' · ', array_filter( array( $miva_program['campus'] ?? '', $miva_program['duration'] ?? '' ) ) ) ); ?>
                </p>
            <?php endif; ?>
        </div>
    </article>
</li>
