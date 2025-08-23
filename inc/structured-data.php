<?php
add_action('init', function () {
    $faq = '<!-- wp:group {"className":"faq-block"} --><div class="wp-block-group faq-block"><!-- wp:heading --><h2>Question?</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Answer.</p><!-- /wp:paragraph --><script type="application/ld+json">{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[{"@type":"Question","name":"Question?","acceptedAnswer":{"@type":"Answer","text":"Answer."}}]}</script></div><!-- /wp:group -->';
    register_block_pattern('jus/faq', ['title'=>'FAQ','description'=>'FAQ schema','content'=>$faq]);
    $howto = '<!-- wp:group {"className":"howto-block"} --><div class="wp-block-group howto-block"><!-- wp:heading --><h2>How to do something</h2><!-- /wp:heading --><!-- wp:list {"ordered":true} --><ol><!-- wp:list-item --><li>First step</li><!-- /wp:list-item --><!-- wp:list-item --><li>Second step</li><!-- /wp:list-item --></ol><!-- /wp:list --><script type="application/ld+json">{"@context":"https://schema.org","@type":"HowTo","name":"How to do something","step":[{"@type":"HowToStep","text":"First step"},{"@type":"HowToStep","text":"Second step"}]}</script></div><!-- /wp:group -->';
    register_block_pattern('jus/howto', ['title'=>'HowTo','description'=>'HowTo schema','content'=>$howto]);
    $job = '<!-- wp:group {"className":"jobposting-block"} --><div class="wp-block-group jobposting-block"><!-- wp:heading --><h2>Job Title</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Job description.</p><!-- /wp:paragraph --><script type="application/ld+json">{"@context":"https://schema.org","@type":"JobPosting","title":"Job Title","description":"Job description."}</script></div><!-- /wp:group -->';
    register_block_pattern('jus/jobposting', ['title'=>'Job Posting','description'=>'JobPosting schema','content'=>$job]);
});
add_action('save_post', function ($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (wp_is_post_revision($post_id)) return;
    $post = get_post($post_id);
    $matches = [];
    preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s', $post->post_content, $matches);
    $faqs = [];
    foreach ($matches[1] as $json) {
        $data = json_decode($json, true);
        if (isset($data['@type']) && $data['@type'] === 'FAQPage') {
            foreach ($data['mainEntity'] as $entity) {
                $faqs[] = ['question'=>$entity['name'],'answer'=>$entity['acceptedAnswer']['text']];
            }
        }
    }
    $meta = get_post_meta($post_id, '_ai_meta', true);
    if (!is_array($meta)) $meta = [];
    $meta['faqs'] = $faqs;
    update_post_meta($post_id, '_ai_meta', $meta);
});
