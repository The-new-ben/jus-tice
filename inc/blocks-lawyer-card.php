<?php
function aero_render_lawyer_card($attributes = []) {
    $lawyer_id = isset($attributes['lawyerId']) ? intval($attributes['lawyerId']) : 0;
    if (!$lawyer_id) {
        return '';
    }
    $post = get_post($lawyer_id);
    if (!$post) {
        return '';
    }
    $permalink = get_permalink($post);
    $title = get_the_title($post);
    $thumb = get_the_post_thumbnail($post, 'profile-thumb');
    $terms = get_the_term_list($lawyer_id, 'lawyer-cat', '<span>', '</span>, <span>', '</span>');
    $phone = get_post_meta($lawyer_id, 'phone', true);
    $email = get_post_meta($lawyer_id, 'email', true);
    $website = get_post_meta($lawyer_id, 'website', true);
    $linkedin = get_post_meta($lawyer_id, 'linkedin', true);
    $office = get_post_meta($lawyer_id, 'office_location', true);
    ob_start();
    ?>
    <article class="lawyer-card">
        <?= $thumb ?>
        <div class="caption">
            <h3><a href="<?= esc_url($permalink) ?>"><?= esc_html($title) ?></a></h3>
            <?php if ($terms) : ?>
                <p class="meta"><?= $terms ?></p>
            <?php endif; ?>
            <ul class="contact">
                <?php if ($phone) : ?><li><?= esc_html($phone) ?></li><?php endif; ?>
                <?php if ($email) : ?><li><a href="mailto:<?= esc_attr($email) ?>"><?= esc_html($email) ?></a></li><?php endif; ?>
                <?php if ($website) : ?><li><a href="<?= esc_url($website) ?>"><?= esc_html($website) ?></a></li><?php endif; ?>
                <?php if ($linkedin) : ?><li><a href="<?= esc_url($linkedin) ?>"><?= esc_html($linkedin) ?></a></li><?php endif; ?>
                <?php if ($office) : ?><li><?= esc_html($office) ?></li><?php endif; ?>
            </ul>
        </div>
    </article>
    <?php
    return ob_get_clean();
}
