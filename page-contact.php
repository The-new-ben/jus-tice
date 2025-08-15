<?php
/*
	Template Name: עמוד צרו קשר
*/

get_header();
?>
<?php $content_width  = get_field('content_width');?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main  narrow has-bg <?php echo $content_width ?>" role="main">

            <?php while (have_posts()) : the_post(); ?>

                <div class="container">
                     <?php the_content(); ?>
                        <div class="row">
                            <div class="contact-us col-md-8">
                                <h3 class="widgettitle large">כתבו אלינו</h3>
                                <?php if ( class_exists( 'GFForms' ) || function_exists( 'gravity_form' ) ) {
                                    echo do_shortcode('[gravityform id=4 title=false description=true ajax=true]');
                                } else {
                                    echo '<p>Form could not be loaded.</p>';
                                } ?>
                            </div>
                            <div class="contact-details col-md-4">
                                <h3 class="widgettitle large"><span>פרטי</span> התקשרות</h3>
                                <ul class="d-sm-flex justify-content-center align-sm-center flex-wrap">
                                    <li><strong>טלפון </strong><?php get_template_part('template-parts/site-phone'); ?></li>
                                    <li><strong>אימייל  </strong><?php get_template_part('template-parts/site-email'); ?></li>
                                </ul>
                            </div>
                        </div>

                </div>

            <?php endwhile; ?>

        </main>
    </div>
<?php get_footer(); ?>
