<?php
/*
	Template Name: עמוד הבית
*/

get_header(); ?>

<div id="home-page">
    <main id="main" class="site-main no-padding" role="main">
        <?php
        if (theme_have_rows('home_features')): ?>
            <section id="home-features" class="no-padding clearfix">
                <div class="container">
                    <?php if(theme_get_field('home_features_title')):?>
                    <div class="section-title">
                        <h2><?= theme_get_field('home_features_title')?></h2>
                    </div>
                    <?php endif;?>
                </div>

                <div class="row no-gutters">
                    <div class="col-md-6">
                        <?php
                        $i = 1;
                        while (theme_have_rows('home_features')): theme_the_row();
                            $image = theme_get_sub_field('slide_image');
                            $title = theme_get_sub_field('slide_title');
                            $caption = theme_get_sub_field('slide_caption');
                            $btn_link = theme_get_sub_field('slide_link');
                            if ($i == 1) {
                                $col = 'main-feature';
                                $justify = 'justify-content-center';
                            } else {
                                $col = "col-md-6";
                                $justify = 'justify-content-end';
                            }
                            ?>
                            <div class="feature-box <?php echo $col ?>">
                                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"/>
                                <div class="caption d-flex flex-column align-items-center <?php echo $justify ?>">
                                    <a class="view all" href="<?php echo $btn_link ?>">view all</a>
                                    <div class="container">
                                        <h3><?php echo $title ?></h3>
                                        <div class="caption-text">
                                            <span class="hidden-xs-down"><?php echo $caption ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if ($i == 1) echo '</div><div class="col-md-6"><div class="row no-gutters">'; ?>
                            <?php $i++; endwhile; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <section id="home-about">
            <div class="container">
                <div class="row">
                    <div class="col-auto col-lg-6 caption">
                        <?php if (theme_get_field('about_title')){?>
                        <h2 class="title"><?= theme_get_field('about_title')?></h2>
                        <?php }?>
                        <div class="desc">
                            <?php the_content() ?>
                        </div>
                        <a class="btn outline round with-icon primary-light">קראו עוד אלינו <i
                                    class="icon ion-ios-arrow-back"></i></a>
                    </div>
                    <div class="coli-auto col-lg-6 video">
                        <div class="break-grid">
                            <div id="play-video">
                            </div>
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe id="video" width="560" height="315"
                                        src="https://www.youtube-nocookie.com/embed/<?= theme_get_field('about_video')?>?rel=0" frameborder="0"
                                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
       </section>
        <section id="articles">
            <div class="container">
                <div class="section-title">
                    <h2>כתבות ומאמרים</h2>
                </div>
				
				<?php 
                                $article_category = theme_get_field('article_category', 'option');
				//echo "<pre>"; print_r($article_category); echo "</pre>";
				?>
				
                <ul class="nav nav-tabs  d-flex" role="tablist">
                    <?php
                    

                  
                    $count = 1;
                    foreach ($article_category as $categoryt):
                        ?>
                        <li class="nav-item  <?= ($count == 1 ? "active" : ""); ?>">
                            <a class="nav-link " href="#cat-<?= $count; ?>"
                               role="tab" data-toggle="tab">
                                <?= $categoryt->name; ?>
                            </a>
                        </li>
                        <?php
                        $count++;
                    endforeach;
                    ?>
                </ul>
                <div class="tab-content">
                    <?php
                   

                    
                    $count = 1;
                      foreach ($article_category as $category):
                        $term_link = get_term_link($category);
                        $term_slug = $category->slug;
                        $_posts = new WP_Query(array(
                            'post_types' => 'articles',
                            'orderby' => 'meta_value_num',
                            'order' => 'ASC',
                            'posts_per_page' => 8,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'practice-areas',
                                    'field' => 'slug',
                                    'terms' => $term_slug,
                                ),
                            ),
                        ));

                        if ($_posts->have_posts()) :
                            ?>
                            <div role="tabpanel" class="tab-pane fade <?= ($count == 1 ? "active show" : ""); ?>"
                                 role="tabpanel" id="cat-<?= $count; ?>">
                                <div class="row">
                                    <?php
                                    while ($_posts->have_posts()) : $_posts->the_post();
                                        get_template_part('template-parts/article-box');
                                    endwhile;
                                    ?>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-auto text-center">
                                        <a class="btn outline round with-icon primary-light center"
                                           href="<?= $term_link ?>">עוד מאמרים ב<?= $category->name; ?> <i
                                                    class="icon ion-ios-arrow-back"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php
                        endif;
                        $count++;

                        wp_reset_query();
                    endforeach;

                    ?>
                </div>

            </div>
        </section>
        <?php  $feat_terms = theme_get_field('lawyer_cats');
         if ( $feat_terms) : ?>
             <section id="law-cats">
                <div class="container">
                    <div class="section-title">
                        <h2><?= theme_get_field('categories_title')?></h2>
                    </div>
                </div>
                <div class="container wide">
                    <div class="row">
                      <?php foreach($feat_terms as $term ):

                            $cat_image = theme_get_field('cat_icon',$term);
                            ?>
                          <div class="col-auto item">
                            <div class="cat-box">
                                <div class="caption">
                                    <img src="<?php echo $cat_image['url']?>"/>
                                    <h3><?php echo $term->name; ?></h3>
                                    <p><?php echo $term->description; ?></p>
                                </div>
                                <a class="readmore" href="<?php echo get_term_link( $term ); ?>">לפרטים <i class="icon ion-ios-arrow-back"></i></a>
                            </div>
                        </div>
                        <?php endforeach;?>
                </div>
            </section>
        <?php endif; ?>

        <section id="lawyers">
            <div class="container">
                <div class="section-title accent">
                    <h2><?= theme_get_field('featured_lawyers_title') ?></h2>
                </div>

                <ul class="nav nav-tabs  d-flex" role="tablist">
                    <?php
                    $categories = get_terms('lawyer-cat', array('post_types' => array('lawyers'), 'hide_empty' => 1, 'parent' => 0, 'number' => 6));
                    $count = 1;
                    foreach ($categories as $category):
                        ?>
                        <li class="nav-item <?= ($count == 1 ? "active" : ""); ?>">
                            <a class="nav-link" href="#category-<?= $count; ?>"
                               role="tab" data-toggle="tab">
                                <?= $category->name; ?>
                            </a>
                        </li>
                        <?php
                        $count++;
                    endforeach;
                    ?>
                </ul>
                <div class="tab-content">
                    <?php
                    $categories = get_terms('lawyer-cat', array('post_types' => array('lawyers'), 'hide_empty' => 1, 'parent' => 0, 'number' => 6));
                    $count = 1;
                    foreach ($categories as $category):
                        $term_link = get_term_link($category);
                        $term_slug = $category->slug;
                        $_posts = new WP_Query(array(
                            'post_type' => 'lawyers',
                            'orderby' => 'menu_order',
                            'order' => 'ASC',
                            'posts_per_page' => 8,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'lawyer-cat',
                                    'field' => 'slug',
                                    'terms' => $term_slug,
                                ),
                            ),
                        ));

                        if ($_posts->have_posts()) :
                            ?>
                            <div role="tabpanel" class="tab-pane fade <?= ($count == 1 ? "active show" : ""); ?>"
                                 role="tabpanel" id="category-<?= $count; ?>">
                                    <div class="row">
                                        <?php
                                        while ($_posts->have_posts()) : $_posts->the_post();
                                            get_template_part('template-parts/lawyer-box');
                                        endwhile;
                                        ?>
                                    </div>

                            </div>
                        <?php
                        endif;
                        $count++;

                        wp_reset_query();
                    endforeach;

                    ?>
                </div>
            </div>