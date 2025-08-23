<?php
 codex/create-and-enqueue-scripts-in-enqueue-scripts.php
function aero_enqueue_assets() {
    wp_enqueue_script('jquery');
    wp_enqueue_style('slick-css', get_template_directory_uri() . '/library/css/slick.css', array(), null);
    wp_enqueue_script('slick', get_template_directory_uri() . '/library/js/min/slick.min.js', array('jquery'), null, true);
    wp_enqueue_script('theme-script', get_template_directory_uri() . '/library/js/script.js', array('jquery', 'slick'), null, true);
    wp_enqueue_style('theme-style', get_template_directory_uri() . '/library/css/theme.css', array(), null);
}
add_action('wp_enqueue_scripts', 'aero_enqueue_assets');

defined( 'ABSPATH' ) || exit;

function bones_scripts_and_styles() {
    global $wp_styles;

    if ( ! is_admin() ) {
        wp_register_style( 'bootstrap-stylesheet', get_stylesheet_directory_uri() . '/library/css/bootstrap.min.css', array(), '', 'all' );
        wp_register_style( 'bones-stylesheet', get_stylesheet_directory_uri() . '/library/css/theme.css', array(), '', 'all' );
        wp_register_style( 'bones-fontAwesome', get_stylesheet_directory_uri() . '/library/css/font-awesome.min.css', array(), '', 'all' );
        wp_register_style( 'bones-ionicons', get_stylesheet_directory_uri() . '/library/css/ionicons.min.css', array(), '', 'all' );
        wp_register_script( 'tether-js', get_stylesheet_directory_uri() . '/library/js/min/tether.min.js', array( 'jquery' ), '', true );
        wp_register_script( 'bootstrap-js', get_stylesheet_directory_uri() . '/library/js/min/bootstrap.min.js', array( 'jquery' ), '', true );
        wp_register_script( 'bones-js', get_stylesheet_directory_uri() . '/library/js/script.js', array(), '', true );
        wp_script_add_data( 'bones-js', 'type', 'module' );

        wp_enqueue_style( 'bootstrap-stylesheet' );
        wp_enqueue_style( 'bones-stylesheet' );
        wp_enqueue_style( 'bones-fontAwesome' );
        wp_enqueue_style( 'bones-ionicons' );

        if ( is_rtl() ) {
            wp_register_style( 'rtlstyle', get_stylesheet_directory_uri() . '/library/css/rtl.css', array(), '' );
            wp_enqueue_style( 'rtlstyle' );
        }

        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'tether-js' );
        wp_enqueue_script( 'bootstrap-js' );

        wp_register_script( 'bootstrap-select-js', get_stylesheet_directory_uri() . '/library/js/bootstrap-select/js/bootstrap-select.js', array( 'jquery' ), '', true );
        wp_register_style( 'bootstrap-select-css', get_stylesheet_directory_uri() . '/library/js/bootstrap-select/dist/css/bootstrap-select.css', array(), '' );
        wp_register_script( 'popper', get_stylesheet_directory_uri() . '/library/js/min/popper.min.js', array( 'jquery' ), '', true );

        wp_enqueue_script( 'bootstrap-select-js' );
        wp_enqueue_script( 'popper' );
        wp_enqueue_script( 'bones-js' );
        wp_enqueue_style( 'bootstrap-select-css' );
    }
}
 main
