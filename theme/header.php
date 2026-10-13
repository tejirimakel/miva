<?php
/**
 * Site header.
 *
 * @package Miva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
    <a class="skip-link visually-hidden-focusable" href="#main"><?php esc_html_e( 'Skip to content', 'miva' ); ?></a>
    <?php get_template_part( 'template-parts/site', 'nav' ); ?>
    <div id="content" class="site-content">
