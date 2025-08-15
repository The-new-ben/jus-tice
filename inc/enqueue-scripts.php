<?php
function aero_enqueue_assets() {
    wp_enqueue_script('jquery');
    wp_enqueue_style('slick-css', get_template_directory_uri() . '/library/css/slick.css', array(), null);
    wp_enqueue_script('slick', get_template_directory_uri() . '/library/js/min/slick.min.js', array('jquery'), null, true);
    wp_enqueue_script('theme-script', get_template_directory_uri() . '/library/js/script.js', array('jquery', 'slick'), null, true);
    wp_enqueue_style('theme-style', get_template_directory_uri() . '/library/css/theme.css', array(), null);
}
add_action('wp_enqueue_scripts', 'aero_enqueue_assets');
