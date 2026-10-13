<?php
/**
 * Site footer.
 *
 * @package Miva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$miva_assets = get_template_directory_uri() . '/assets';

$miva_footer_cols = array(
	__( 'Faculties', 'miva' )      => array(
		__( 'School of Computing', 'miva' ),
		__( 'School of Management and Social Sciences', 'miva' ),
	),
	__( 'Studying', 'miva' )       => array(
		__( 'Admission Requirements', 'miva' ),
		__( 'Tuition', 'miva' ),
		__( 'Digital Learning Tools', 'miva' ),
	),
	__( 'The University', 'miva' ) => array(
		__( 'About Us', 'miva' ),
		__( 'Leadership', 'miva' ),
		__( 'Student Life', 'miva' ),
		__( 'Adjunct Faculty Application', 'miva' ),
		__( 'Blog', 'miva' ),
	),
);

$miva_socials = array(
	array( 'f.svg', __( 'Facebook', 'miva' ) ),
	array( 't.svg', __( 'Twitter', 'miva' ) ),
	array( 'i.svg', __( 'Instagram', 'miva' ) ),
	array( 'l.svg', __( 'LinkedIn', 'miva' ) ),
	array( 'tk.svg', __( 'TikTok', 'miva' ) ),
	array( 'y.svg', __( 'YouTube', 'miva' ) ),
);
?>
    </div><!-- #content -->

<footer class="hw py-4 mt-3">
    <div class="container">
        <div class="row pt-4 text-white">
            <div class="col-lg-3 col-md-6 col-sm-12 widget">
                <div class="footer-widget logo-widget pb-4">
                    <img src="<?php echo esc_url( "$miva_assets/logo.svg" ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                </div>
                <p class="footer-about">
                    <?php esc_html_e( 'Miva Open University is a premier online university designed to empower individuals with the skills they need to thrive in today\'s world.', 'miva' ); ?>
                </p>
                <ul class="navbar-nav footer-contact">
                    <li class="pb-1"><img class="portal-icon" src="<?php echo esc_url( "$miva_assets/logos_whatsapp-icon.svg" ); ?>" alt="" aria-hidden="true"><a class="text-reset text-decoration-none" href="tel:+2349132300000">+234 9132300000</a></li>
                    <li class="pb-1"><img class="portal-icon" src="<?php echo esc_url( "$miva_assets/p.svg" ); ?>" alt="" aria-hidden="true"><a class="text-reset text-decoration-none" href="tel:+23413300666">01 3300 666</a></li>
                    <li><img class="portal-icon" src="<?php echo esc_url( "$miva_assets/m.svg" ); ?>" alt="" aria-hidden="true"><a class="text-reset text-decoration-none" href="mailto:help@miva.university">help@miva.university</a></li>
                </ul>
            </div>
            <?php foreach ( $miva_footer_cols as $heading => $links ) : ?>
                <div class="col-lg-3 col-md-6 col-sm-12 widget">
                    <h2 class="footer-heading"><?php echo esc_html( $heading ); ?></h2>
                    <ul class="navbar-nav footer-links">
                        <?php foreach ( $links as $link ) : ?>
                            <li><a class="nav-link" href="#"><?php echo esc_html( $link ); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
        <hr class="footer-rule">
    </div>
    <div class="container">
        <div class="row text-white align-items-center">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <p class="footer-about">
                    <?php

                    printf( esc_html__( '© %s Miva Open University. All rights reserved.', 'miva' ), esc_html( wp_date( 'Y' ) ) );
                    ?>
                </p>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <ul class="footer-info">
                    <li class="nav-item"><a class="nav-link" href="#"><?php esc_html_e( 'Terms & Conditions', 'miva' ); ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><?php esc_html_e( 'Privacy Policy', 'miva' ); ?></a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <ul class="footer-info">
                    <?php foreach ( $miva_socials as $social ) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#" aria-label="<?php echo esc_attr( $social[1] ); ?>">
                                <img class="social-icon" src="<?php echo esc_url( "$miva_assets/{$social[0]}" ); ?>" alt="">
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
