<article id="post-<?php the_ID(); ?>" <?php post_class('col-auto col-md-4'); ?>
         role="article">
    <div class="lawyer-card">
            <?php the_post_thumbnail('profile-thumb') ?>

        <div class="caption">
            <h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
            <p class="meta"><?php echo get_the_term_list(get_the_ID(), 'lawyer-cat', '<span>', '</span>, <span>', '</span>') ?></p>

        </div>

    </div>
</article>
