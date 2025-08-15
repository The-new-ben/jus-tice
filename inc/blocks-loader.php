<?php
add_action('init', function () {
    register_block_type(__DIR__ . '/../blocks/lawyer-card', [
        'render_callback' => 'aero_render_lawyer_card',
    ]);
});
