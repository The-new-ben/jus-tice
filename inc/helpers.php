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
