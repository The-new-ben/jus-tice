<?php
if (function_exists('add_action')) {
    add_action('rest_api_init', function() {
        register_rest_route('seo-aio/v1', '/count', [
            'methods' => 'GET',
            'callback' => function() {
                return ['count' => get_option('seo_aio_count', 0)];
            }
        ]);
    });
}
