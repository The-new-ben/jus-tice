<?php
if (!function_exists('seo_aio_format')) {
    function seo_aio_format($text) {
        $text = trim($text);
        return sanitize_text_field($text);
    }
}
