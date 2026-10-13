<?php
/**
 * Scholarship archive: all scholarships in a card grid.
 *
 * @package Miva
 */

get_header(); ?>

<main id="main">
    <div class="container py-5">
        <header class="program-archive__header">
            <h1 class="htext"><?php post_type_archive_title(); ?></h1>
            <p class="hero-lead"><?php esc_html_e( 'Find a scholarship that fits your profile, then check its amount and deadline.', 'miva' ); ?></p>
        </header>

        <?php if ( have_posts() ) : ?>
            <div class="row g-4">
                <?php
                while ( have_posts() ) :
                    the_post();
                    get_template_part(
                        'template-parts/scholarship',
                        'card',
                        array(
                            'column_class' => 'col-12 col-md-6 col-lg-4',
                            'heading'      => 'h2',
                            'placeholder'  => true,
                        )
                    );
                endwhile;
                ?>
            </div>

            <div class="py-4">
                <?php the_posts_pagination(); ?>
            </div>
        <?php else : ?>
            <div class="program-empty">
                <h2 class="section-subheading"><?php esc_html_e( 'No scholarships yet', 'miva' ); ?></h2>
                <p class="mb-0"><?php esc_html_e( 'Scholarships will be listed here as soon as they are published.', 'miva' ); ?></p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
