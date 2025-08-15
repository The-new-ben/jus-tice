<?php

get_header();
?>
<div id="primary" class="content-area">
    <div id="main" class="site-main" role="main">
        <div class="container">

            <?php if (have_posts()) : while (have_posts()) :
                the_post(); ?>
                <div class="row">
                    <div class="col-auto col-md-4">
                        <?php if (has_post_thumbnail()) the_post_thumbnail('profile-pic'); ?>
                        <?php echo do_shortcode('[gravityform id=1 title=false description=true ajax=true]'); ?>
                    </div>
                    <div class="col-auto col-md-8">
                        <header class="lawyer-header">
                            <h2 class="title small"><?php the_title(); ?></h2>
                            <?php
                            $phone = get_field('profile_phone');
                            $whatsapp = get_field('profile_whatsapp');
                            $facebook = get_field('profile_facebook');
                            $linkedin = get_field('profile_linkedin');
                            $twitter = get_field('profile_twitter');
                            $availability = get_field('availability');
                            $iframe = get_field('profile_video');
                            if ($phone) { ?>
                                <div class="phone d-flex align-items-center">
                                    <a class="tel" href="tel:<?php echo $phone ?>"><?php echo $phone ?></a>
                                    <?php if ($whatsapp)?><a href="<?= $whatsapp ?>"><i class="icon-whatsapp"></i></a>
                                </div>
                            <?php } ?>
                            <ul class="meta d-flex">
                                <li>
                                    <strong>תחום</strong><?php echo get_the_term_list(get_the_ID(), 'lawyer-cat', '<span>', '</span> | <span>', '</span>') ?>
                                </li>
                                <?php if ($availability) { ?>
                                    <li><strong>זמינות</strong><span><?= $availability ?></span></li>
                                <?php } ?>
                                                           </ul>
                        </header>
                        <article class="entry-content">
                            <?php the_content(); ?>
                            <div class="profile-social d-sm-flex align-items-sm-center">
                                    <strong>קישורים ברשת</strong>
                                    <?php if ($facebook)?> <a class="social" href="#"><i class="ion-social-facebook"></i></a>
                                    <?php if ($linkedin)?><a class="social" href="<?= $linkedin ?>"><i class="ion-social-linkedin"></i></a>
                                    <?php if ($twitter)?><a class="social" href="<?= $twitter ?>"><i class="ion-social-twitter"></i></a>
                            </div>
                        </article>
                        <section class="info">
                            <div class="row">

                                <?php
                                $post_objects = get_field('profile_articles');
                                if ($post_objects): ?>
                                    <div class="col-auto col-md-6 related">
                                        <div class="section-title small">
                                            <h2>כתבות ומאמרים</h2>
                                        </div>
                                        <?php foreach ($post_objects as $post): // variable must be called $post (IMPORTANT) ?>
                                            <?php setup_postdata($post); ?>
                                            <article
                                                    id="post-<?php the_ID(); ?>" <?php post_class(); ?>
                                                    role="article">
                                                <h3><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h3>
                                                <p><?php echo wp_trim_words(get_the_excerpt(), 8, '...'); ?></p>
                                                <a class="more" href="<?php the_permalink(); ?>"><i
                                                            class="ion-ios-arrow-back"></i></a>
                                            </article>
                                        <?php endforeach; ?>

                                        <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
                                    </div>
                                <?php endif; ?>


                                <?php
                                if ($iframe):
                                    preg_match('/src="(.+?)"/', $iframe, $matches);
                                    $src = $matches[1];


                                    $params = array(
                                        'controls' => 0,
                                        'hd' => 1,
                                        'autohide' => 1
                                    );

                                    $new_src = add_query_arg($params, $src);

                                    $iframe = str_replace($src, $new_src, $iframe);


                                    $attributes = 'frameborder="0"';

                                    $iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);


                                    ?>
                                    <div class="col-auto col-md-6 gallery">
                                        <div class="section-title small accent">
                                            <h2>גלריית וידאו</h2>
                                        </div>
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <?= $iframe ?>
                                        </div>

                                    </div>
                                <?php endif; ?>
                            </div>
                        </section>
                        <section class="testimonials">
                            <div class="section-title small">
                                <h2>המלצות</h2>
                            </div>
                            <div id="testimonial-slider" style="display: none">
                                <div class="testimonial">
                                    <blockquote>
                                        <i class="ion-quote"></i>
                                        ולורס מונפרד אדנדום סילקוף, מרגשי ומרגשח. עמחליף נולום ארווס סאפיאן - פוסיליס
                                        קוויס, אקווזמן קוואזי במר מודוף. אודיפו בלאסטיק מונופץ קליר, בנפת נפקט למסון
                                        בלרק - וענוף ושבעגט ליבם סולגק. בראיט ולחת צורק מונחף, בגורמי מגמש. תרבנך וסתעד
                                        לכנו סתשם השמה - לתכי מורגם בורק? לתיג ישבעס.
                                    </blockquote>
                                    <div class="person">יוסי כהן</div>
                                </div>
                                <div class="testimonial">
                                    <blockquote>
                                        <i class="ion-quote"></i>
                                        ולורס מונפרד אדנדום סילקוף, מרגשי ומרגשח. עמחליף נולום ארווס סאפיאן - פוסיליס
                                        קוויס, אקווזמן קוואזי במר מודוף. אודיפו בלאסטיק מונופץ קליר, בנפת נפקט למסון
                                        בלרק - וענוף ושבעגט ליבם סולגק. בראיט ולחת צורק מונחף, בגורמי מגמש. תרבנך וסתעד
                                        לכנו סתשם השמה - לתכי מורגם בורק? לתיג ישבעס.
                                    </blockquote>
                                    <div class="person">יוסי כהן</div>
                                </div>
                            </div>
                        </section>

                    </div>

                </div>

            <?php endwhile; ?>

            <?php else : ?>

                <article id="post-not-found" class="hentry cf">
                    <header class="article-header">
                        <h1><?php _e('Oops, Post Not Found!', 'bonestheme'); ?></h1>
                    </header>
                    <section class="entry-content">
                        <p><?php _e('Uh Oh. Something is missing. Try double checking things.', 'bonestheme'); ?></p>
                    </section>
                    <footer class="article-footer">
                        <p><?php _e('This is the error message in the single.php template.', 'bonestheme'); ?></p>
                    </footer>
                </article>

            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
