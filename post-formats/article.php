<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article" itemscope itemprop="blogPost"
         itemtype="http://schema.org/BlogPosting">

    <?php if (has_post_thumbnail()) { ?>
        <div class="image-container">
            <?php the_post_thumbnail('full'); ?>
        </div>
    <?php } ?>

    <section class="entry-content  no-padding-top" itemprop="articleBody">
        <?php the_content(); ?>
    </section>

    <footer class="article-footer">
		<?php if(get_field('show_extra')):?>
		<div class="related-posts-wrapper">
			<h2>
				לכתבות נוספות
			</h2>
			<?php
			$featured_posts = get_field('related_posts');
			if( $featured_posts ): ?>
			<div class="inner-wrapper">
				<?php foreach( $featured_posts as $post ): 

				// Setup this post for WP functions (variable must be named $post).
				setup_postdata($post); ?>
				<div class="single-relate-post">
					<div class="image-holder">
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium');
						?></a>
					</div>
					<div class="text-holder">
						<a href="<?php the_permalink(); ?>"><?php the_title('<h3>','</h3>'); ?>	</a>
                                                <p><?php echo wp_trim_words(get_the_excerpt(), 40, '...'); ?></p>
					</div>
						
					
				</div>
				<?php endforeach; ?>
			</div>
			<?php 
			// Reset the global post object so that the rest of the page works correctly.
			wp_reset_postdata(); ?>
			<?php endif; ?>					
		</div>
		<?php endif; ?>
        <p class="categories"><?php echo get_the_term_list(get_the_ID(), 'practice-areas', '<strong class="tags-title">' . __('קטגוריות:', 'bonestheme') . '</strong> ', ', ') ?></p>
    </footer>


</article> <?php // end article ?>
