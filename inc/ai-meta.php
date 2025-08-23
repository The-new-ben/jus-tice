<?php
function ai_register_meta() {
    register_post_meta('post', '_ai_meta', array('single' => true, 'show_in_rest' => true, 'type' => 'object'));
}
add_action('init', 'ai_register_meta');
function ai_generate_meta($post_id, $post) {
    if (wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) return;
    if ($post->post_type !== 'post') return;
    $text = wp_strip_all_tags($post->post_content);
    $summary = mb_substr(trim($text), 0, 150);
    preg_match_all('/\b[A-Z][a-z]+\b/', $text, $m);
    $entities = array_values(array_unique($m[0]));
    $faqs = array();
    foreach ($entities as $e) {
        $faqs[] = array('q' => 'Who is ' . $e . '?', 'a' => '');
    }
    $meta = array('summary' => $summary, 'entities' => $entities, 'faqs' => $faqs);
    update_post_meta($post_id, '_ai_meta', $meta);
}
add_action('save_post', 'ai_generate_meta', 10, 2);
function ai_get_post_meta($r) {
    $id = intval($r['id']);
    $d = get_post_meta($id, '_ai_meta', true);
    return rest_ensure_response($d);
}
add_action('rest_api_init', function () {
    register_rest_route('ai/v1', '/post/(?P<id>\d+)/meta', array('methods' => 'GET', 'callback' => 'ai_get_post_meta', 'permission_callback' => '__return_true'));
});
