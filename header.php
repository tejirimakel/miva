<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="all" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header>
        <nav class="navbar navbar-expand-lg navbg" style="height: 46px; font-weight: 600; font-size:12px; font-family:'Manrope', sans-serif;">
            <div class="container justify-content-end">
                <div class="tnav">
             <ul class="navbar-nav me-auto mb-lg-0">
             <li class="nav-item bod">
          <a class="nav-link" href="#"><img style="padding:0 10px" src="<?php echo get_template_directory_uri(); ?>/assets/board.svg">Adjunct Faculty</a>
        </li>    
            <li class="nav-item bod">
          <a class="nav-link" href="#"><img style="padding:0 10px" src="<?php echo get_template_directory_uri(); ?>/assets/board1.svg">E-courseware</a>
        </li>
        <li class="nav-item bod">
          <a class="nav-link" href="#"><img style="padding:0 10px" src="<?php echo get_template_directory_uri(); ?>/assets/board2.svg">E-library</a>
        </li>
        <li class="nav-item bod">
          <a class="nav-link" href="#"><img style="padding:0 10px" src="<?php echo get_template_directory_uri(); ?>/assets/board3.svg">Classroom</a>
        </li>
        <li class="nav-item bod">
          <a class="nav-link" href="#"><img style="padding:0 10px" src="<?php echo get_template_directory_uri(); ?>/assets/board4.svg">Student Portal</a>
        </li>
    </ul></div>
</div>
        </nav>
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container">
    <a class="navbar-brand" style="padding-right:62px" href="/">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/logo-w.svg"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 gx-3 navtext">
        <li class="nav-item dropdown">
          <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            About Miva
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Faculties
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Admission</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Tution</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><img style="padding:0 5px" src="<?php echo get_template_directory_uri(); ?>/assets/logos_whatsapp-icon.svg">+234 0800023445</a>
        </li>

        </ul>        
                <form class="d-flex">
    <button class="btn btn-outline-danger me-2" style="font-weight: 600; font-size:12px; font-family:'Manrope', sans-serif;" type="button">Request Information</button>
    <button class="btn btn-danger me-2" style="font-weight: 600; font-size:12px; font-family:'Manrope', sans-serif;" type="button">Apply Now</button>
  </form>
</div>
            </nav>
           </header>
    <div id="content" class="site-content">
