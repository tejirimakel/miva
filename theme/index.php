<?php
/**
 * Main fallback template.
 *
 *
 * @package Miva
 */

get_header(); ?>

<main id="main">
    <div class="container py-5">
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <article <?php post_class(); ?>>
                    <h2 class="card-title">
                        <a href="<?php the_permalink(); ?>"><?php echo wp_kses_post( get_the_title() ); ?></a>
                    </h2>
                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php endwhile; ?>

            <div class="py-4">
                <?php the_posts_pagination(); ?>
            </div>
        <?php else : ?>
            <p><?php esc_html_e( 'Nothing found.', 'miva' ); ?></p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
