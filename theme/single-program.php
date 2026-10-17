<?php
/**
 * Single program detail page.
 *
 * @package Miva
 */

get_header(); ?>

<main id="main">
    <div class="container py-5">
        <?php
        while ( have_posts() ) :
            the_post();

            $miva_program = function_exists( 'college_programs_get_program_data' ) ? college_programs_get_program_data( get_the_ID() ) : array();

            // Label => value; empty values are dropped so no bare labels are printed.
            $miva_details = array_filter(
                array(
                    __( 'Credential', 'miva' )    => $miva_program['credential'] ?? '',
                    __( 'Campus', 'miva' )        => $miva_program['campus'] ?? '',
                    __( 'Delivery mode', 'miva' ) => $miva_program['delivery_mode'] ?? '',
                    __( 'Duration', 'miva' )      => $miva_program['duration'] ?? '',
                )
            );

            // Extra ACF fields are label/value pairs; append them after the built-in ones.
            foreach ( $miva_program['extra'] ?? array() as $miva_field ) {
                $miva_details[ $miva_field['label'] ] = $miva_field['value'];
            }
            ?>
            <article <?php post_class( 'program-single' ); ?>>
                <p class="program-single__back">
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'program' ) ); ?>">&larr; <?php esc_html_e( 'All programs', 'miva' ); ?></a>
                </p>

                <h1 class="htext"><?php echo wp_kses_post( get_the_title() ); ?></h1>

                <?php if ( has_excerpt() ) : ?>
                    <p class="hero-lead"><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></p>
                <?php endif; ?>

                <div class="program-single__layout">
                    <div class="program-single__main">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid program-single__img' ) ); ?>
                        <?php endif; ?>
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <?php if ( $miva_details || ! empty( $miva_program['application_url'] ) ) : ?>
                        <aside class="program-single__aside" aria-labelledby="program-details-heading">
                            <h2 id="program-details-heading" class="footer-heading"><?php esc_html_e( 'Program details', 'miva' ); ?></h2>
                            <?php if ( $miva_details ) : ?>
                                <dl class="program-details">
                                    <?php foreach ( $miva_details as $miva_label => $miva_value ) : ?>
                                        <div>
                                            <dt><?php echo esc_html( $miva_label ); ?></dt>
                                            <dd><?php echo esc_html( $miva_value ); ?></dd>
                                        </div>
                                    <?php endforeach; ?>
                                </dl>
                            <?php endif; ?>
                            <?php if ( ! empty( $miva_program['application_url'] ) ) : ?>
                                <a class="btn btnnew btn-danger w-100" href="<?php echo esc_url( $miva_program['application_url'] ); ?>"><?php esc_html_e( 'Apply now', 'miva' ); ?></a>
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
