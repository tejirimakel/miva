<?php
/**
 * Template for displaying single pages.
 *
 * @package Miva
 */

get_header(); ?>

<main>
    <div class="container py-5">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                ?>
                <article <?php post_class(); ?>>
                    <h1><?php the_title(); ?></h1>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>
                <?php
            endwhile;
        else :
            ?>
            <p><?php esc_html_e( 'Nothing found.', 'miva' ); ?></p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
