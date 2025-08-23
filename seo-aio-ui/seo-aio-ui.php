<?php
/*
Plugin Name: SEO AIO UI
*/
add_action('enqueue_block_editor_assets', function () {
    wp_enqueue_script(
        'seo-aio-ui-editor',
        plugins_url('editor.js', __FILE__),
        array('wp-edit-post', 'wp-element', 'wp-components'),
        null,
        true
    );
});
