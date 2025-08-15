<?php
/*
	Template Name: עמוד כלים
*/

get_header(); ?>
<?php $content_width = theme_get_field('content_width'); ?>
<div id="primary" class="content-area">
    <main id="main" class="site-main  has-bg <?php echo $content_width ?>" role="main">

        <?php while (have_posts()) :
        the_post(); ?>

        <div class="container">
            <?php the_content(); ?>
            <div class="section-tools">
                <div class="row d-md-flex">
                    <div class="col-md-5">
                        <div class="section-title small">
                            <h2>שערי המרה <span>נפוצים</span></h2>
                        </div>
                        <iframe src="https://il.widgets.investing.com/live-currency-cross-rates?theme=darkTheme"
                                width="100%" height="300" frameborder="0" allowtransparency="true" marginwidth="0"
                                marginheight="0"></iframe>
                    </div>
                    <div class="col-md-2 align-self-md-center">
                        <img src="<?php echo get_template_directory_uri() ?>/library/images/icon-calculator.svg"/>
                    </div>
                    <div class="col-md-5">
                        <div class="section-title small">
                            <h2>מחשבון <span>המרה</span></h2>
                        </div>
                        <iframe allowtransparency="true" frameborder="no" src="https://www.hamara.co.il/iframe.php"
                                width="100%" height="300px"></iframe>
                    </div>
                </div>
            </div>
                <?php endwhile; ?>

    </main>
</div>
<?php get_footer(); ?>