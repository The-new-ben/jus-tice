<article id="post-<?php the_ID(); ?>" <?php post_class('col-auto col-md-4'); ?>
         role="article">
    <div class="lawyer-card">
            <?php the_post_thumbnail('profile-thumb') ?>

        <div class="caption">
            <h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
            <p class="meta"><?php echo get_the_term_list(get_the_ID(), 'lawyer-cat', '<span>', '</span>, <span>', '</span>'); ?></p>
            <?php
            $enable_ai = false;
            if ( isset( $block ) && isset( $block['attrs']['enableAi'] ) ) {
                $enable_ai = (bool) $block['attrs']['enableAi'];
            }
            if ( $enable_ai ) :
            ?>
                <button type="button" class="ask-lawyer" data-lawyer="<?php the_ID(); ?>"><?php esc_html_e('Ask this lawyer', 'bonestheme'); ?></button>
            <?php endif; ?>

        </div>

    </div>
</article>
