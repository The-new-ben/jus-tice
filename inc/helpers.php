<?php
// Helper functions for Aero Index theme.
// This file provides compatibility helpers for PHP 8+ and other utility functions.

defined( 'ABSPATH' ) || exit;

/**
 * Safe count helper to avoid warnings on null values in PHP 8.
 *
 * @param mixed $var Variable to count.
 * @return int Number of elements or 0 if not countable.
 */
function aero_index_safe_count( $var ) {
    return is_countable( $var ) ? count( $var ) : 0;
}

 codex/create-acf-wrapper-functions
function theme_get_field($selector, $post_id = false, $format_value = true) {
    return function_exists('get_field') ? get_field($selector, $post_id, $format_value) : null;
}

function theme_have_rows($selector, $post_id = false) {
    return function_exists('have_rows') ? have_rows($selector, $post_id) : false;
}

function theme_get_sub_field($selector, $format_value = true) {
    return function_exists('get_sub_field') ? get_sub_field($selector, $format_value) : null;
}

function theme_the_row() {
    if (function_exists('the_row')) {
        the_row();
    }

function bones_head_cleanup() {
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
    remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
    remove_action( 'wp_head', 'wp_generator' );
    add_filter( 'style_loader_src', 'bones_remove_wp_ver_css_js', 9999 );
    add_filter( 'script_loader_src', 'bones_remove_wp_ver_css_js', 9999 );
}

function rw_title( $title, $sep, $seplocation ) {
    global $page, $paged;

    if ( is_feed() ) {
        return $title;
    }

    if ( 'right' === $seplocation ) {
        $title .= get_bloginfo( 'name' );
    } else {
        $title = get_bloginfo( 'name' ) . $title;
    }

    $site_description = get_bloginfo( 'description', 'display' );

    if ( $site_description && ( is_home() || is_front_page() ) ) {
        $title .= " {$sep} {$site_description}";
    }

    if ( $paged >= 2 || $page >= 2 ) {
        $title .= " {$sep} " . sprintf( __( 'Page %s', 'dbt' ), max( $paged, $page ) );
    }

    return $title;
}

function bones_rss_version() {
    return '';
}

function bones_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) ) {
        $src = remove_query_arg( 'ver', $src );
    }
    return $src;
}

function bones_remove_wp_widget_recent_comments_style() {
    if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
        remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
    }
}

function bones_remove_recent_comments_style() {
    global $wp_widget_factory;
    if ( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) ) {
        remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
    }
}

function bones_gallery_style( $css ) {
    return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}

function bones_theme_support() {
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 125, 125, true );
    add_theme_support( 'custom-background', array(
        'default-image'          => '',
        'default-color'          => '',
        'wp-head-callback'       => '_custom_background_cb',
        'admin-head-callback'    => '',
        'admin-preview-callback' => '',
    ) );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );
    add_theme_support( 'menus' );
    register_nav_menus( array(
        'main-nav'       => __( 'The Main Menu', 'bonestheme' ),
        'top-nav'        => __( 'The top Menu', 'bonestheme' ),
        'cat-nav'        => __( 'Practice Areas Menu', 'bonestheme' ),
        'footer-links-1' => __( 'Footer Links 1', 'bonestheme' ),
        'footer-links-2' => __( 'Footer Links 2', 'bonestheme' ),
        'footer-links-3' => __( 'Footer Links 3', 'bonestheme' ),
    ) );
    add_theme_support( 'html5', array( 'comment-list', 'search-form', 'comment-form' ) );
}

function bones_page_navi() {
    global $wp_query;
    $bignum = 999999999;
    if ( $wp_query->max_num_pages <= 1 ) {
        return;
    }
    echo '<nav class="pagination">';
    echo paginate_links( array(
        'base'      => str_replace( $bignum, '%#%', esc_url( get_pagenum_link( $bignum ) ) ),
        'format'    => '',
        'current'   => max( 1, get_query_var( 'paged' ) ),
        'total'     => $wp_query->max_num_pages,
        'prev_text' => '<i class="fa fa-angle-left"></i>',
        'next_text' => '<i class="fa fa-angle-right"></i>',
        'type'      => '',
        'end_size'  => 3,
        'mid_size'  => 3,
    ) );
    echo '</nav>';
}

function bones_filter_ptags_on_images( $content ) {
    return preg_replace( '/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content );
}

function bones_excerpt_more( $more ) {
    global $post;
    return '...  <a class="excerpt-read-more" href="' . get_permalink( $post->ID ) . '" title="' . __( 'Read ', 'bonestheme' ) . esc_attr( get_the_title( $post->ID ) ) . '">' . __( 'Read more &raquo;', 'bonestheme' ) . '</a>';
 main
}
