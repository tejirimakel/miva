<?php

function enqueue_custom_scripts() {
    // Enqueue your custom JavaScript file
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/main.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


function enqueue_bootstrap() {
    
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css');

    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.3.1', true);
}

add_action('wp_enqueue_scripts', 'enqueue_bootstrap');

function register_custom_menus() {
    register_nav_menus(array(
        'primary-menu' => __('Primary Menu', 'miva'),
    ));
}

add_action('after_setup_theme', 'register_custom_menus');

function enqueue_animate_css() {
  wp_enqueue_style('animate-css', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');
}
add_action('wp_enqueue_scripts', 'enqueue_animate_css');

?>