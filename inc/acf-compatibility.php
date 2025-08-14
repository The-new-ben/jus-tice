<?php
/**
 * ACF compatibility helpers for PHP 7.4+ and PHP 8.
 *
 * This file hooks into `acf/init` to register fields and options,
 * ensuring that Advanced Custom Fields functions are only called after
 * the plugin has loaded. Keeping ACF logic in its own file makes
 * functions.php leaner and easier to maintain.
 *
 * @package Aero_Index
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Initialise ACF options and field groups.
 *
 * This callback runs after the ACF plugin has initialised. Only call
 * ACF functions (like acf_add_options_page) inside this function to
 * prevent fatal errors when ACF is disabled or during updates.
 */
function aero_index_acf_init() {
    // Bail early if ACF isn’t active.
    if ( ! function_exists( 'acf_add_options_page' ) ) {
        return;
    }

    // Register a global options page (example). You can remove this
    // block if your theme doesn’t need a settings page.
    acf_add_options_page( array(
        'page_title' => __( 'Theme Settings', 'aero-index' ),
        'menu_title' => __( 'Theme Settings', 'aero-index' ),
        'menu_slug'  => 'theme-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
    ) );

    // Register local field groups here when using ACF’s Local JSON feature.
    // For example:
    // acf_add_local_field_group( array(
    //     'key'    => 'group_theme_settings',
    //     'title'  => 'Theme Settings',
    //     'fields' => array(/* field definitions */),
    //     'location' => array(
    //         array(
    //             array(
    //                 'param'    => 'options_page',
    //                 'operator' => '==',
    //                 'value'    => 'theme-settings',
    //             ),
    //         ),
    //     ),
    // ) );
}
add_action( 'acf/init', 'aero_index_acf_init' );
