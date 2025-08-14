<?php
/*
	Template Name: עמוד הרשמה
*/

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main mini has-bg-foggy" role="main">

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <?php
                    while (have_posts()) : the_post();
                        the_content();
                    endwhile;
                    ?>
                    <div class="user-form register">
                        <?php echo do_shortcode('[wppb-register]') ?>
                    </div>
                </div>
            </div>
        </div>

    </main>
</div>

<?php get_footer(); ?>
‫‫‫<h3>ברוכים הבאים ל {{site_name}}!</h3>
