<?php
/*
Plugin Name: SEO AIO
Description: Loads tasks, REST routes, and helpers.
*/
if (defined('ABSPATH')) {
    $dir = __DIR__ . '/seo-aio';
    foreach (['tasks.php','rest.php','helpers.php'] as $part) {
        $file = $dir . '/' . $part;
        if (is_file($file)) {
            include $file;
        }
    }
}
