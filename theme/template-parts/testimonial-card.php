<?php
/**
 * Single testimonial card (used inside the testimonials loop).
 *
 * @package Miva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$miva_assets = get_template_directory_uri() . '/assets';
$miva_person = get_post_meta( get_the_ID(), '_miva_person', true );
$miva_role   = get_post_meta( get_the_ID(), '_miva_role', true );
$miva_quote  = get_the_content();
?>
<div class="col-lg-6 col-sm-12 mb-3 mb-sm-0">
    <div class="card">
        <div class="card-body">
            <p class="ttext"><?php echo esc_html( wp_strip_all_tags( $miva_quote ) ); ?></p>
            <div class="d-flex align-items-center">
                <?php if ( has_post_thumbnail() ) : ?>
                    <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'img-fluid testimonial-avatar' ) ); ?>
                <?php else : ?>
                    <img class="img-fluid testimonial-avatar" src="<?php echo esc_url( "$miva_assets/simg.png" ); ?>" alt="">
                <?php endif; ?>
                <div class="d-block">
                    <p class="fs5"><?php echo esc_html( $miva_person ); ?></p>
                    <p class="fs6"><?php echo esc_html( $miva_role ); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
