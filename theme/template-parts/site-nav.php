<?php
/**
 * Site header navigation.
 *
 * @package Miva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$miva_assets = get_template_directory_uri() . '/assets';

$miva_portals = array(
	array( 'board.svg', __( 'Adjunct Faculty', 'miva' ) ),
	array( 'board1.svg', __( 'E-courseware', 'miva' ) ),
	array( 'board2.svg', __( 'E-library', 'miva' ) ),
	array( 'board3.svg', __( 'Classroom', 'miva' ) ),
	array( 'board4.svg', __( 'Student Portal', 'miva' ) ),
);
?>
<header>
    <nav class="navbar navbg utility-nav d-none d-lg-block">
        <div class="container justify-content-end">
            <ul class="navbar-nav tnav flex-row">
                <?php foreach ( $miva_portals as $portal ) : ?>
                    <li class="nav-item bod">
                        <a class="nav-link" href="#">
                            <img class="portal-icon" src="<?php echo esc_url( "$miva_assets/{$portal[0]}" ); ?>" alt="" aria-hidden="true">
                            <?php echo esc_html( $portal[1] ); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </nav>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <img src="<?php echo esc_url( "$miva_assets/logo-w.svg" ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#primaryNav" aria-controls="primaryNav" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'miva' ); ?>">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="primaryNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 navtext">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php esc_html_e( 'About Miva', 'miva' ); ?></a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><?php esc_html_e( 'Overview', 'miva' ); ?></a></li>
                            <li><a class="dropdown-item" href="#"><?php esc_html_e( 'Leadership', 'miva' ); ?></a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php esc_html_e( 'Faculties', 'miva' ); ?></a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><?php esc_html_e( 'School of Computing', 'miva' ); ?></a></li>
                            <li><a class="dropdown-item" href="#"><?php esc_html_e( 'School of Management and Social Sciences', 'miva' ); ?></a></li>
                        </ul>
                    </li>
                    <?php // The `program` post type is registered by the College Programs plugin. ?>
                    <?php if ( post_type_exists( 'program' ) ) : ?>
                        <?php $miva_on_programs = is_post_type_archive( 'program' ) || is_singular( 'program' ); ?>
                        <li class="nav-item">
                            <a class="nav-link<?php echo $miva_on_programs ? ' active' : ''; ?>" href="<?php echo esc_url( get_post_type_archive_link( 'program' ) ); ?>"<?php echo is_post_type_archive( 'program' ) ? ' aria-current="page"' : ''; ?>><?php esc_html_e( 'Programs', 'miva' ); ?></a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="#"><?php esc_html_e( 'Admission', 'miva' ); ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><?php esc_html_e( 'Tuition', 'miva' ); ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><?php esc_html_e( 'Contact Us', 'miva' ); ?></a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="tel:+2349132300000">
                            <img class="portal-icon" src="<?php echo esc_url( "$miva_assets/logos_whatsapp-icon.svg" ); ?>" alt="" aria-hidden="true">+234 9132300000
                        </a>
                    </li>
                </ul>
                <div class="d-flex flex-column flex-lg-row gap-2">
                    <button class="btn btn-outline-danger btn-cta" type="button"><?php esc_html_e( 'Request Information', 'miva' ); ?></button>
                    <button class="btn btn-danger btn-cta" type="button"><?php esc_html_e( 'Apply Now', 'miva' ); ?></button>
                </div>
            </div>
        </div>
    </nav>
</header>
