<div id="sidebar-articles" class="sidebar col-md-4" role="complementary">
    <div class="widget search">
        <form role="search" method="get" class="search-form d-flex" action="<?php echo home_url('/'); ?>">
            <span class="screen-reader-text"><?php echo _x('חפש מאמרים:', 'label') ?></span>
            <input type="search" class="search-field"
                   placeholder="<?php echo esc_attr_x('חפש מאמרים…', 'placeholder') ?>"
                   value="<?php echo get_search_query() ?>" name="s"
                   title="<?php echo esc_attr_x('Search for:', 'label') ?>"/>
            <input type="hidden" name="post_type" value="articles"/>

            <input type="submit" class="search-submit" value="חפש"/>
        </form>
    </div>

<?php
    $recent_articles = new WP_Query(array(
        'post_type' => 'articles',
        'orderby' => 'post__in',
        'order' => 'relevance',
        'posts_per_page' =>5,
    ));
    if ($recent_articles->have_posts()) :
        ?>
        <div class="widget articles">
            <h4 class="widgettitle">המלצות</h4>
            <ul>
                                <?php
                                while ($recent_articles->have_posts()) : $recent_articles->the_post();
                                get_template_part('template-parts/article-mini-box');
                                endwhile;
                                wp_reset_postdata();
                                ?>
                        </ul>
        </div>
	<div class="widget">
		<h4 class="widgettitle">צרו קשר</h4>
		<?php echo do_shortcode('[gravityform id=1 title=false description=true ajax=true]'); ?>
	</div>
	
	<div>
		<?php  
	
    
		   $terms = get_the_terms($post->ID, 'practice-areas');
	                    if (!empty($terms)) {
                    // get the first term
                    $term = array_shift($terms);
                    $term_slug = $term->slug;

		$_posts = new WP_Query(array(
			'post_type' => 'lawyers',
			'orderby' => 'parent',
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
                    <section id="lawyers">
                        <div class="section-title full">
                            <h2>עורכי דין מומלצים בתחום</h2>
                        </div>
                        <div class="row">

                            <?php
                            while ($_posts->have_posts()) : $_posts->the_post();
                                get_template_part('template-parts/lawyer-box');
                            endwhile;
                            ?>
                        </div>
                    </section>
                        <?php
                        endif;

                        wp_reset_query();
                        }
                        ?>
	</div>
	<?php
         if ( null /*is_singular('articles') */) { ?>
            <div class="widget articles">
            <h4 class="widgettitle">קטגוריות מאמרים</h4>
            <ul>
            <?php

            $taxonomy = 'practice-areas';
            $orderby = 'name';
            $show_count = 0;      // 1 for yes, 0 for no
            $pad_counts = 0;      // 1 for yes, 0 for no
            $hierarchical = 1;      // 1 for yes, 0 for no
            $title = '';
            $empty = 0;
            $args = array(
                'taxonomy' => $taxonomy,
                'orderby' => $orderby,
                'show_count' => $show_count,
                'pad_counts' => $pad_counts,
                'hierarchical' => $hierarchical,
                'title_li' => $title,
                'hide_empty' => $empty,
            );
            $all_categories = get_categories($args);
            $curTerm = $wp_query->queried_object;
            $counter = 1;
            foreach ($all_categories as $cat) {
                $current = '';
                if ($cat->name == $curTerm->name) {
                    $current = 'current';
                }
                if ($cat->category_parent === 0) {
                    $category_id = $cat->term_id;
                    $args2 = array(
                        'taxonomy' => $taxonomy,
                        'child_of' => 0,
                        'parent' => $category_id,
                        'orderby' => $orderby,
                        'show_count' => $show_count,
                        'pad_counts' => $pad_counts,
                        'hierarchical' => $hierarchical,
                        'title_li' => $title,
                        'hide_empty' => $empty
                    );
                    $sub_cats = get_categories($args2); ?>

                    <li id="<?= $category_id ?>" class="<?= $current; ?> b-table-header" data-accordion-itm>
                        <!-- table data header-->

                        <?php if ($sub_cats) {
                            echo '<a class="collapse-link collapsed" data-toggle="collapse" href="#collapse-' . $counter . '"  aria-expanded="true" aria-controls="collapse-' . $counter . '">' . $cat->name . '<i class="icon ion-ios-arrow-down"></i></a>';
                        } else {
                            echo '<a href="' . get_term_link($cat->slug, 'practice-areas') . '">' . $cat->name . '</a>';
                        }
                        ?>
                        <?php if ($sub_cats) { ?>
                            <div class="b-table__body collapse" id="collapse-<?= $counter ?>" c role="tabpanel"
                                 data-parent="#accordion">
                                <ul class="b-box-aside__nav">
                                    <?php foreach ($sub_cats as $sub_category) {
                                        $current = '';
                                        if ($sub_category->name == $curTerm->name) {
                                            $current = 'current-cat';
                                        }
                                        echo '<li class="' . $current . '"><a href="' . get_term_link($sub_category->slug, 'practice-areas') . '">' . $sub_category->name . '</a></li>';
                                    } ?>
                                </ul>
                            </div>

                            <?php
                        } ?>
                    </li>
                <?php }
                $counter++;
            }

        } 
        ?>
        </ul>
        </div>
    <?php endif;  ?>
   
    <?php $side_banner = get_field('side_banner', 'option');
    $side_banner_link = get_field('side_banner_link', 'option');
    if($side_banner):
    ?>

    <div class="widget banner">
        <a href="<?= esc_url( $side_banner_link['url'] ) ?>">
            <img src="<?php echo $side_banner['url']; ?>" alt="<?php echo $side_banner['alt']; ?>"/>
        </a>
    </div>
    <?php endif;?>
</div>
