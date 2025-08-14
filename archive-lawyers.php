<?php get_header();
?>
<div id="main" class="site-main  no-padding" role="main">
    <div class="container">
        <?php
        //Get the search term
        global $searchandfilter;
        $sf_current_query = $searchandfilter->get(335)->current_query();
        echo $sf_current_query->get_search_term();
        ?>
    </div>
    <div id="lawyers">
        <div class="container">
            <div class="row">
                <div class="col-auto col-lg-9">
                    <div class="row">
                        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                            <?php get_template_part('template-parts/lawyer-box'); ?>
                        <?php endwhile;endif; ?>
                    </div>
                </div>
                <div class="col-auto col-lg-3">
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
        </div>
    </div>

</div>

<?php get_footer(); ?>
