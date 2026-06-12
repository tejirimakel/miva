<?php
/**
 * Front page: "How it Works" section with the scholarship preview card.
 *
 * @package Miva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$miva_assets = get_template_directory_uri() . '/assets';

$miva_steps = array(
	array(
		'title' => __( 'Find a scholarship that fits your profile', 'miva' ),
		'body'  => __( 'Look through our list of scholarships to find the one that best applies to your situation. You can find the requirements of each scholarship.', 'miva' ),
	),
	array(
		'title' => __( 'Apply to scholarship', 'miva' ),
		'body'  => __( 'Apply to a scholarship of your choice by filling a form with your details and submitting the necessary requirements. You must be currently admitted into Miva Open University.', 'miva' ),
	),
);
?>
<div class="container hw">
    <div class="svg-container" aria-hidden="true">
        <svg class="deco-svg deco-svg--gold" xmlns="http://www.w3.org/2000/svg" width="575" height="259" viewBox="0 0 575 259" fill="none">
            <mask id="path-1-inside-1_6208_16488" fill="white">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M573.871 253.933L0 -225L576.812 55.9555L1153.62 -225L579.754 253.933V258.843L576.812 256.388L573.871 258.843V253.933Z"/>
            </mask>
            <path d="M0 -225L8.75799 -242.98L-12.8149 -209.645L0 -225ZM573.871 253.933H593.871V244.575L586.686 238.578L573.871 253.933ZM576.812 55.9555L568.054 73.936L576.812 78.2018L585.57 73.936L576.812 55.9555ZM1153.62 -225L1166.44 -209.645L1144.87 -242.98L1153.62 -225ZM579.754 253.933L566.939 238.578L559.754 244.575V253.933H579.754ZM579.754 258.843L566.939 274.198L599.754 301.584V258.843H579.754ZM576.812 256.388L589.627 241.033L576.812 230.338L563.998 241.033L576.812 256.388ZM573.871 258.843H553.871V301.584L586.686 274.198L573.871 258.843ZM-12.8149 -209.645L561.056 269.288L586.686 238.578L12.8149 -240.355L-12.8149 -209.645ZM585.57 37.975L8.75799 -242.98L-8.75799 -207.02L568.054 73.936L585.57 37.975ZM585.57 73.936L1162.38 -207.02L1144.87 -242.98L568.054 37.975L585.57 73.936ZM1140.81 -240.355L566.939 238.578L592.568 269.288L1166.44 -209.645L1140.81 -240.355ZM599.754 258.843V253.933H559.754V258.843H599.754ZM563.997 271.743L566.939 274.198L592.569 243.488L589.627 241.033L563.997 271.743ZM563.998 241.033L561.056 243.487L586.686 274.198L589.627 271.743L563.998 241.033ZM593.871 258.843V253.933H553.871V258.843H593.871Z" fill="#BB9E7F" mask="url(#path-1-inside-1_6208_16488)"/>
        </svg>
        <svg class="deco-svg deco-svg--red" xmlns="http://www.w3.org/2000/svg" width="599" height="623" viewBox="0 0 599 623" fill="none">
            <mask id="path-1-inside-1_6208_16485" fill="white">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M597.391 674.856L0 -212L600.344 303.896L1200.69 -212L603.297 674.856V683.623L600.344 679.24L597.391 683.623V674.856Z"/>
            </mask>
            <path d="M0 -212L13.035 -227.169L-16.5877 -200.826L0 -212ZM597.391 674.856H617.391V668.748L613.978 663.682L597.391 674.856ZM600.344 303.896L587.309 319.065L600.344 330.266L613.379 319.065L600.344 303.896ZM1200.69 -212L1217.28 -200.826L1187.65 -227.169L1200.69 -212ZM603.297 674.856L586.709 663.682L583.297 668.748V674.856H603.297ZM603.297 683.623L586.709 694.797L623.297 749.114V683.623H603.297ZM600.344 679.24L616.931 668.066L600.344 643.441L583.756 668.066L600.344 679.24ZM597.391 683.623H577.391V749.113L613.978 694.797L597.391 683.623ZM-16.5877 -200.826L580.803 686.029L613.978 663.682L16.5877 -223.174L-16.5877 -200.826ZM613.379 288.728L13.035 -227.169L-13.035 -196.831L587.309 319.065L613.379 288.728ZM613.379 319.065L1213.72 -196.831L1187.65 -227.169L587.309 288.728L613.379 319.065ZM1184.1 -223.174L586.709 663.682L619.884 686.029L1217.28 -200.826L1184.1 -223.174ZM623.297 683.623V674.856H583.297V683.623H623.297ZM583.756 690.413L586.709 694.797L619.884 672.45L616.931 668.066L583.756 690.413ZM583.756 668.066L580.803 672.45L613.978 694.797L616.931 690.413L583.756 668.066ZM617.391 683.623V674.856H577.391V683.623H617.391Z" fill="#E83831" mask="url(#path-1-inside-1_6208_16485)"/>
        </svg>
    </div>
    <div class="text-overlay">
        <div class="row p-5">
            <div class="col-lg-6 col-sm-12">
                <h2 class="pb-4 text-white"><?php esc_html_e( 'How it Works', 'miva' ); ?></h2>
                <?php foreach ( $miva_steps as $step ) : ?>
                    <div class="pt-3 my-3">
                        <div class="blk1" data-animate="animate__slideInRight">
                            <h5><?php echo esc_html( $step['title'] ); ?></h5>
                            <p><?php echo esc_html( $step['body'] ); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-lg-6 col-sm-12 text-white p-5">
                <div class="ovr"></div>
                <div class="bxs-box p-3" data-animate="animate__fadeInUp">
                    <div class="bxs">
                        <div class="d-flex align-items-center">
                            <img class="img-fluid" src="<?php echo esc_url( "$miva_assets/logo-s.svg" ); ?>" alt="">
                            <div class="d-block funder-meta">
                                <p class="fs6"><?php esc_html_e( 'Funded by', 'miva' ); ?></p>
                                <p class="fs5"><?php esc_html_e( 'Miva Open University', 'miva' ); ?></p>
                            </div>
                        </div>
                        <p class="my-5 preview-title"><?php esc_html_e( 'Miva Open University Scholarship for Outstanding Students', 'miva' ); ?></p>
                        <div class="text-info text-white mt-5">
                            <h6 class="preview-amount">₦500,000</h6>
                            <p class="preview-deadline"><?php esc_html_e( 'Deadline: 2 weeks', 'miva' ); ?></p>
                        </div>
                    </div>
                </div>
                <div class="popcardbox text-black-50" data-animate="animate__fadeInRight">
                    <div class="popcard">
                        <img class="img-fluid" src="<?php echo esc_url( "$miva_assets/simg.png" ); ?>" alt="">
                        <div class="d-block">
                            <p class="fs5"><?php esc_html_e( 'Congratulations', 'miva' ); ?></p>
                            <p class="fs6"><?php esc_html_e( 'You have been awarded a scholarship', 'miva' ); ?></p>
                        </div>
                        <div class="icon1">
                            <div class="ellipse"><img class="img-fluid" src="<?php echo esc_url( "$miva_assets/E23.svg" ); ?>" alt=""></div>
                            <img class="tick" src="<?php echo esc_url( "$miva_assets/fe_check.svg" ); ?>" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
