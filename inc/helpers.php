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
}
