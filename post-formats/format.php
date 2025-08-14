
              <article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article" itemscope itemprop="blogPost" itemtype="http://schema.org/BlogPosting">

                  <?php if (has_post_thumbnail()) {?>
                    <div class="image-container">
                        <?php    the_post_thumbnail('full');?>
                    </div>
                 <?php }?>

                <section class="entry-content no-padding-top" itemprop="articleBody">
                      <?php  the_content();       ?>
                </section>

              </article> <?php // end article ?>
