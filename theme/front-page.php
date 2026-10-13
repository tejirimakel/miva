<?php
/**
 * Front page template: the Miva scholarships landing page.
 *
 * @package Miva
 */

get_header();

$miva_assets = get_template_directory_uri() . '/assets';
?>

<main id="main">
    <?php
    get_template_part( 'template-parts/hero' );
    get_template_part( 'template-parts/how-it-works' );
    ?>

    <section class="container">
        <h2 class="section-heading text-center"><?php esc_html_e( 'Available Scholarships', 'miva' ); ?></h2>
        <div class="row mx-auto py-5">
            <?php
            $miva_scholarships = new WP_Query(
                array(
                    'post_type'      => 'scholarship',
                    'posts_per_page' => 3,
                    'no_found_rows'  => true,
                )
            );

            if ( $miva_scholarships->have_posts() ) :
                while ( $miva_scholarships->have_posts() ) :
                    $miva_scholarships->the_post();
                    get_template_part( 'template-parts/scholarship-card' );
                endwhile;
                wp_reset_postdata();
            else :
                // Fallback sample so a fresh install still renders.
                for ( $i = 1; $i <= 3; $i++ ) :
                    ?>
                    <div class="col-lg-4 col-sm-12 mb-3 mb-sm-0" data-animate="animate__fadeInDown">
                        <div class="card scholarship-card">
                            <img src="<?php echo esc_url( "$miva_assets/$i.png" ); ?>" class="card-img-top scholarship-card__img" alt="">
                            <div class="card-body">
                                <img class="img-fluid scholarship-card__logo" src="<?php echo esc_url( "$miva_assets/mv$i.svg" ); ?>" alt="">
                                <p class="card-text"><?php esc_html_e( 'Miva Open University', 'miva' ); ?></p>
                                <h3 class="card-title"><?php esc_html_e( 'Miva Open University Scholarship for Outstanding Students', 'miva' ); ?></h3>
                                <div class="d-flex align-items-center scholarship-card__meta">
                                    <img class="img-fluid meta-icon" src="<?php echo esc_url( "$miva_assets/uil_money-stack.svg" ); ?>" alt="" aria-hidden="true">
                                    <span>₦500,000</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                endfor;
            endif;
            ?>
        </div>
        <div class="text-center py-5">
            <a class="btn btnnew btn-danger" href="<?php echo esc_url( get_post_type_archive_link( 'scholarship' ) ); ?>"><?php esc_html_e( 'View all Scholarships', 'miva' ); ?></a>
        </div>
    </section>

    <section class="container testimonials">
        <p class="eyebrow mb-2"><?php esc_html_e( 'TESTIMONIALS', 'miva' ); ?></p>
        <h2 class="section-subheading"><?php esc_html_e( 'Hear what others have to say', 'miva' ); ?></h2>
        <div class="row mx-auto my-5">
            <?php
            $miva_testimonials = new WP_Query(
                array(
                    'post_type'      => 'testimonial',
                    'posts_per_page' => 2,
                    'no_found_rows'  => true,
                )
            );

            if ( $miva_testimonials->have_posts() ) :
                while ( $miva_testimonials->have_posts() ) :
                    $miva_testimonials->the_post();
                    get_template_part( 'template-parts/testimonial-card' );
                endwhile;
                wp_reset_postdata();
            else :
                for ( $i = 0; $i < 2; $i++ ) :
                    ?>
                    <div class="col-lg-6 col-sm-12 mb-3 mb-sm-0">
                        <div class="card">
                            <div class="card-body">
                                <p class="ttext"><?php esc_html_e( 'I was skeptical about online universities at first, but Miva exceeded my expectations. The professors were highly qualified and engaged, and the coursework was challenging and stimulating.', 'miva' ); ?></p>
                                <div class="d-flex align-items-center">
                                    <img class="img-fluid testimonial-avatar" src="<?php echo esc_url( "$miva_assets/simg.png" ); ?>" alt="">
                                    <div class="d-block">
                                        <p class="fs5"><?php echo $i ? esc_html__( 'Sophie Moore', 'miva' ) : esc_html__( 'Paul Darius', 'miva' ); ?></p>
                                        <p class="fs6"><?php echo $i ? esc_html__( 'Product Developer', 'miva' ) : esc_html__( 'NUC Program Manager', 'miva' ); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                endfor;
            endif;
            ?>
        </div>
    </section>

    <?php
    // When a static page is set as the front page, show what the editor put
    // in it (for example a Call to Action block) below the fixed sections.
    if ( is_page() ) :
        while ( have_posts() ) :
            the_post();
            if ( '' !== trim( get_the_content() ) ) :
                ?>
                <section class="container front-page-content">
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </section>
                <?php
            endif;
        endwhile;
    endif;
    ?>
</main>

<?php get_footer(); ?>
