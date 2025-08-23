<?php get_header();
$term = get_queried_object();
?>
<div id="primary" class="content-area">
    <div id="main" class="site-main has-bg" role="main">
        <div id="blog-grid">
            <div class="container">
                <div class="row item-container d-sm-flex flex-sm-wrap">
                    <?php if (have_posts()) :
                        $i =0;
                        while (have_posts()) : the_post();
                            $i++;
                            if ($i == 1) {
                                $column = 'col-lg-8 main-post';
                                $words = 25;
                            }else{
                                $column = 'col-lg-4';
                                $words = 15;
                            }?>

                            <div class="news-item col-md-6 <?php echo $column ?>">
                                <article
                                        id="post-<?php the_ID(); ?>" <?php post_class(); ?>
                                        role="article">
                                    <span class="date"><?php echo get_the_time('d.m.y')?></span>
                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h3>
                                    <p><?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?></p>
                                    <a class="more" href="<?php the_permalink(); ?>"><i
                                                class="ion-ios-arrow-thin-left"></i></a>
                                </article>
                            </div>

                        <?php endwhile;endif;?>
                </div>
                <?php bones_page_navi()?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>