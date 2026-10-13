<?php
/**
 * Program directory: archive for the `program` post type.
 *
 * The post type is registered by the College Programs plugin, so WordPress
 * only loads this template while that plugin is active.
 *
 * @package Miva
 */

get_header(); ?>

<main id="main">
    <div class="container py-5">
        <header class="program-archive__header">
            <h1 class="htext"><?php post_type_archive_title(); ?></h1>
            <p class="hero-lead"><?php esc_html_e( 'Browse our programs by credential and delivery mode, then open one for full details.', 'miva' ); ?></p>
        </header>

        <?php if ( have_posts() ) : ?>
            <ul class="program-grid">
                <?php
                while ( have_posts() ) :
                    the_post();
                    get_template_part( 'template-parts/program', 'card' );
                endwhile;
                ?>
            </ul>

            <div class="py-4">
                <?php the_posts_pagination(); ?>
            </div>
        <?php else : ?>
            <div class="program-empty">
                <h2 class="section-subheading"><?php esc_html_e( 'No programs yet', 'miva' ); ?></h2>
                <p class="mb-0"><?php esc_html_e( 'Programs will be listed here as soon as they are published.', 'miva' ); ?></p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
