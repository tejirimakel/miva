<?php
/**
 * Front page: hero section.
 *
 * @package Miva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$miva_assets = get_template_directory_uri() . '/assets';
?>
<section class="container">
    <div class="row align-items-center py-5">
        <div class="col-lg-6 col-sm-12" data-animate="animate__slideInUp">
            <h1 class="htext pb-1"><?php esc_html_e( 'Maximize Your Education with Scholarship Opportunities', 'miva' ); ?></h1>
            <p class="hero-lead">
                <?php esc_html_e( 'We provide flexible, accessible and personalized learning experiences, enabling students to strike a balance between their studies and other commitments.', 'miva' ); ?>
            </p>
            <a class="btn btnnew btn-danger" href="<?php echo esc_url( get_post_type_archive_link( 'scholarship' ) ); ?>"><?php esc_html_e( 'View Scholarship', 'miva' ); ?></a>
        </div>
        <div class="col-lg-6 col-sm-12" data-animate="animate__fadeIn">
            <img class="img-fluid" src="<?php echo esc_url( "$miva_assets/hero.png" ); ?>" alt="<?php esc_attr_e( 'Students celebrating a scholarship award', 'miva' ); ?>">
        </div>
    </div>
</section>
