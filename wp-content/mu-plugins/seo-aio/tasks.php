<?php
if (function_exists('add_action')) {
    if (!wp_next_scheduled('seo_aio_daily')) {
        wp_schedule_event(time(), 'daily', 'seo_aio_daily');
    }
    add_action('seo_aio_daily', function() {
        $count = get_option('seo_aio_count', 0);
        update_option('seo_aio_count', $count + 1);
    });
}
