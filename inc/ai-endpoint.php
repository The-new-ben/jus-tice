<?php
defined('ABSPATH') || exit;

function aero_ai_lawyerfaq() {
    check_ajax_referer('aero_ai_nonce', 'nonce');
    wp_send_json_success('This is a placeholder response.');
}
add_action('wp_ajax_aero_ai_lawyerfaq', 'aero_ai_lawyerfaq');
add_action('wp_ajax_nopriv_aero_ai_lawyerfaq', 'aero_ai_lawyerfaq');
