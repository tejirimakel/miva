<?php
/**
 * Single scholarship card (used inside the scholarships loop).
 *
 * Optional $args: 'column_class' (grid column classes), 'heading' (title tag)
 * and 'placeholder' (show a branded panel when there is no featured image).
 *
 * @package Miva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$miva_assets   = get_template_directory_uri() . '/assets';
$miva_funder   = get_post_meta( get_the_ID(), '_miva_funder', true );
$miva_logo_id  = (int) get_post_meta( get_the_ID(), '_miva_funder_logo', true );
$miva_amount   = get_post_meta( get_the_ID(), '_miva_amount', true );
$miva_deadline = get_post_meta( get_the_ID(), '_miva_deadline', true );

$miva_column      = $args['column_class'] ?? 'col-lg-4 col-sm-12 mb-3 mb-sm-0';
$miva_heading     = 'h2' === ( $args['heading'] ?? '' ) ? 'h2' : 'h3';
$miva_placeholder = ! empty( $args['placeholder'] );

if ( $miva_deadline ) {
	$miva_ts       = strtotime( $miva_deadline );
	$miva_deadline = $miva_ts ? wp_date( get_option( 'date_format' ), $miva_ts ) : $miva_deadline;
}
?>
<div class="<?php echo esc_attr( $miva_column ); ?>" data-animate="animate__fadeInDown">
    <div class="card scholarship-card h-100">
        <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail( 'large', array( 'class' => 'card-img-top scholarship-card__img' ) ); ?>
        <?php elseif ( $miva_placeholder ) : ?>
            <div class="card-img-top scholarship-card__img scholarship-card__placeholder">
                <img src="<?php echo esc_url( "$miva_assets/logo.svg" ); ?>" alt="">
            </div>
        <?php endif; ?>
        <div class="card-body">
            <?php if ( $miva_logo_id ) : ?>
                <?php echo wp_get_attachment_image( $miva_logo_id, 'medium', false, array( 'class' => 'img-fluid scholarship-card__logo' ) ); ?>
            <?php endif; ?>
            <?php if ( $miva_funder ) : ?>
                <p class="card-text"><?php echo esc_html( $miva_funder ); ?></p>
            <?php endif; ?>
            <<?php echo esc_html( $miva_heading ); ?> class="card-title"><a class="stretched-link" href="<?php the_permalink(); ?>"><?php echo wp_kses_post( get_the_title() ); ?></a></<?php echo esc_html( $miva_heading ); ?>>
            <?php if ( $miva_amount ) : ?>
                <div class="d-flex align-items-center scholarship-card__meta">
                    <img class="img-fluid meta-icon" src="<?php echo esc_url( "$miva_assets/uil_money-stack.svg" ); ?>" alt="" aria-hidden="true">
                    <span><?php echo esc_html( $miva_amount ); ?></span>
                </div>
            <?php endif; ?>
            <?php if ( $miva_deadline ) : ?>
                <div class="d-flex align-items-center scholarship-card__meta">
                    <img class="img-fluid meta-icon" src="<?php echo esc_url( "$miva_assets/mdi_stopwatch-outline.svg" ); ?>" alt="" aria-hidden="true">
                    <span><?php echo esc_html( $miva_deadline ); ?></span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
