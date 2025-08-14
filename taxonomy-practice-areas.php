<?php get_header();
?>
<div id="main" class="site-main" role="main">
    <div id="articles">
        <div class="container">
            <?php $description = term_description(); ?>
            <?php if($description) ?>
            <div class="term-desc text-center">
                <?= $description?>
            </div>
            <div class="row">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/article-box'); ?>
                <?php endwhile;endif; ?>
            </div>

        </div>
    </div>
</div>
<?php if (function_exists('bones_page_navi')) { ?>
    <?php bones_page_navi(); ?>
<?php } else { ?>
    <nav class="wp-prev-next">
        <ul class="clearfix">
            <li class="prev-link"><?php next_posts_link(__('&laquo; Older Entries', 'bonestheme')) ?></li>
            <li class="next-link"><?php previous_posts_link(__('Newer Entries &raquo;', 'bonestheme')) ?></li>
        </ul>
    </nav>
<?php } ?>
<?php
$tax = $wp_query->get_queried_object();
$_posts = new WP_Query(array(
    'post_type' => 'lawyers',
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'posts_per_page' => 10,
    'tax_query' => array(
        array(
            'taxonomy' => 'lawyer-cat',
            'field' => 'slug',
            'terms' => $tax->name,
        ),
    ),
));

if ($_posts->have_posts()) :?>
<div id="lawyers" class="related">
    <div class="container">
        <div class="section-title accent">
            <h2>עורכי דין מומלצים בתחום</h2>
        </div>
        <div class="row">
            <?php
            while ($_posts->have_posts()) : $_posts->the_post();
                get_template_part('template-parts/lawyer-box');
            endwhile;
            ?>
        </div>
    </div>
</div>
<?php endif;  ?>
<?php get_footer(); ?>