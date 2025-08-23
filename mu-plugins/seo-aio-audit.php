<?php
if (!wp_next_scheduled('seo_aio_audit_cron')) {
    wp_schedule_event(time(), 'daily', 'seo_aio_audit_cron');
}
add_action('seo_aio_audit_cron', 'seo_aio_run_audit');
function seo_aio_run_audit() {
    $sitemap_url = home_url('/sitemap.xml');
    $sitemap_head = wp_remote_head($sitemap_url);
    $sitemap_code = is_wp_error($sitemap_head) ? 0 : wp_remote_retrieve_response_code($sitemap_head);
    $urls = [home_url(), home_url('/robots.txt'), home_url('/favicon.ico')];
    $errors = [];
    foreach ($urls as $url) {
        $response = wp_remote_head($url);
        $code = is_wp_error($response) ? 0 : wp_remote_retrieve_response_code($response);
        if ($code >= 400 || $code === 0) {
            $errors[$url] = $code;
        }
    }
    $metrics = [
        'posts' => (int) wp_count_posts('post')->publish,
        'pages' => (int) wp_count_posts('page')->publish,
        'users' => (int) count_users()['total_users']
    ];
    $audit = [
        'checked' => current_time('mysql'),
        'sitemap_status' => $sitemap_code,
        'http_errors' => $errors,
        'metrics' => $metrics
    ];
    update_option('seo_aio_last_audit', $audit);
}
