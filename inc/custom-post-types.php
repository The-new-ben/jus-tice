<?php
function register_theme_post_types() {
    register_post_type('articles', array(
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'articles'),
        'supports' => array('title','editor','thumbnail','excerpt','author','comments'),
    ));
    register_post_type('lawyer', array(
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'lawyer'),
        'supports' => array('title','editor','thumbnail','excerpt','author','comments'),
    ));
    register_taxonomy('practice-area', 'lawyer', array(
        'public' => true,
        'hierarchical' => true,
        'rewrite' => array('slug' => 'practice-area'),
        'show_admin_column' => true,
    ));
}
add_action('init','register_theme_post_types');
function theme_flush_rewrite() {
    register_theme_post_types();
    flush_rewrite_rules();
}
add_action('after_switch_theme','theme_flush_rewrite');
