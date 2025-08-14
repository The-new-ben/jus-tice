<article id="post-<?php the_ID(); ?>" <?php post_class('col-sm-6 item d-flex'); ?>
         role="article">
    <?php if(has_post_thumbnail()){
        the_post_thumbnail('article-thumb');
    } else{?>
        <img src="<?php echo get_template_directory_uri() ?>/library/images/article_thumb.jpg"/>
    <?php
    }?>
    <div class="caption">
        <h3><a href="<?php the_permalink()?>"><?php the_title()?></a></h3>
        <p><?php echo excerpt(15)?></p>
    </div>
    <a class="readmore" href="<?php the_permalink()?>"><i class="icon ion-ios-arrow-back"></i></a>
</article>