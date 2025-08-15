<article id="post-<?php the_ID(); ?>" <?php post_class('item d-flex'); ?>
         role="article">
      <?php the_post_thumbnail('article-thumb');?>
    <div class="caption">
        <h3><a href="<?php the_permalink()?>"><?php the_title()?></a></h3>
        <p><?php echo wp_trim_words(get_the_excerpt(), 8, '...'); ?></p>
    </div>
    <a class="readmore" href="<?php the_permalink()?>"><i class="icon ion-ios-arrow-back"></i></a>
</article>