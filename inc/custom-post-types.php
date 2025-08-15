<?php
add_action('init', function () {
    $lawyer_meta = ['phone', 'email', 'website', 'linkedin', 'office_location'];
    foreach ($lawyer_meta as $key) {
        register_post_meta('lawyers', $key, [
            'type' => 'string',
            'single' => true,
            'show_in_rest' => true,
            'sanitize_callback' => 'sanitize_text_field',
        ]);
    }
});
