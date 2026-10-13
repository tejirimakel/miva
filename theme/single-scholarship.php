<?php
/**
 * Single scholarship detail page.
 *
 * Shares its layout classes with single-program.php.
 *
 * @package Miva
 */

get_header(); ?>

<main id="main">
    <div class="container py-5">
        <?php
        while ( have_posts() ) :
            the_post();

            $miva_funder   = get_post_meta( get_the_ID(), '_miva_funder', true );
            $miva_logo_id  = (int) get_post_meta( get_the_ID(), '_miva_funder_logo', true );
            $miva_amount   = get_post_meta( get_the_ID(), '_miva_amount', true );
            $miva_deadline = get_post_meta( get_the_ID(), '_miva_deadline', true );

            if ( $miva_deadline ) {
                $miva_ts       = strtotime( $miva_deadline );
                $miva_deadline = $miva_ts ? wp_date( get_option( 'date_format' ), $miva_ts ) : $miva_deadline;
            }

            // Label => value; empty values are dropped so no bare labels are printed.
            $miva_details = array_filter(
                array(
                    __( 'Amount', 'miva' )   => $miva_amount,
                    __( 'Deadline', 'miva' ) => $miva_deadline,
                )
            );
            ?>
            <article <?php post_class( 'program-single' ); ?>>
                <p class="program-single__back">
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'scholarship' ) ); ?>">&larr; <?php esc_html_e( 'All scholarships', 'miva' ); ?></a>
                </p>

                <h1 class="htext"><?php echo wp_kses_post( get_the_title() ); ?></h1>

                <div class="program-single__layout">
                    <div class="program-single__main">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid program-single__img' ) ); ?>
                        <?php endif; ?>
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <?php if ( $miva_details || $miva_funder || $miva_logo_id ) : ?>
                        <aside class="program-single__aside" aria-labelledby="scholarship-details-heading">
                            <h2 id="scholarship-details-heading" class="footer-heading"><?php esc_html_e( 'Scholarship details', 'miva' ); ?></h2>
                            <?php if ( $miva_funder || $miva_logo_id ) : ?>
                                <p class="program-single__funder">
                                    <?php if ( $miva_logo_id ) : ?>
                                        <?php echo wp_get_attachment_image( $miva_logo_id, 'thumbnail', false, array( 'alt' => '' ) ); ?>
                                    <?php endif; ?>
                                    <?php if ( $miva_funder ) : ?>
                                        <span>
                                            <?php
                                            /* translators: %s: funder name. */
                                            printf( esc_html__( 'Funded by %s', 'miva' ), esc_html( $miva_funder ) );
                                            ?>
                                        </span>
                                    <?php endif; ?>
                                </p>
                            <?php endif; ?>
                            <?php if ( $miva_details ) : ?>
                                <dl class="program-details mb-0">
                                    <?php foreach ( $miva_details as $miva_label => $miva_value ) : ?>
                                        <div>
                                            <dt><?php echo esc_html( $miva_label ); ?></dt>
                                            <dd><?php echo esc_html( $miva_value ); ?></dd>
                                        </div>
                                    <?php endforeach; ?>
                                </dl>
                            <?php endif; ?>
                        </aside>
                    <?php endif; ?>
                </div>
            </article>
            <?php
        endwhile;
        ?>
    </div>
</main>

<?php get_footer(); ?>
