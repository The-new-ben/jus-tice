<?php
/**
 * Template Name: Single Post Template (Optimized)
 *
 * תבנית לתצוגת פוסט בודד, עם שיפורים ואופטימיזציה
 */

global $open;
$open = ' open'; // במידה ולא נחוץ בשום מקום – מומלץ להסיר

get_header(); 
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main no-padding-top has-bg" role="main">
        <div class="container">
            <div class="row">

                <div class="col-md-8 col-lg-9 post-wrap">
                
                    <?php if ( have_posts() ) : ?>
                        
                        <?php while ( have_posts() ) : the_post(); ?>
                            
                            <?php
                            // טעינת template-part לפוסט בהתאם לפורמט שלו
                            get_template_part( 'post-formats/format', get_post_format() );
                            ?>

                            <div id="post-navigation" class="d-sm-flex align-items-center justify-content-between">
                                <?php
                                // בדיקה אם קיימים פוסטים קודמים/באים
                                $prev_post = get_previous_post();
                                $next_post = get_next_post();
                                ?>

                                <?php if ( $prev_post && ! empty( $prev_post->post_title ) ) : ?>
                                    <div class="post-prev">
                                        <i class="aero-arrow-right-thin"></i>
                                        <strong><?php esc_html_e( 'הפוסט הקודם', 'textdomain' ); ?></strong>
                                        <?php previous_post_link( '%link', '%title' ); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ( $next_post && ! empty( $next_post->post_title ) ) : ?>
                                    <div class="post-next">
                                        <strong><?php esc_html_e( 'הפוסט הבא', 'textdomain' ); ?></strong>
                                        <?php next_post_link( '%link', '%title' ); ?>
                                        <i class="aero-arrow-left-thin"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <?php
                            // תבנית תגובות (אם אין צורך או אין תגובות, אפשר להתנות זאת)
                            comments_template();
                            ?>
                        
                        <?php endwhile; // end while have_posts ?>

                    <?php else : ?>
                        <!-- פוסט לא נמצא -->
                        <article id="post-not-found" class="hentry cf">
                            <header class="article-header">
                                <h1><?php esc_html_e( 'Oops, Post Not Found!', 'textdomain' ); ?></h1>
                            </header>
                            <section class="entry-content">
                                <p><?php esc_html_e( 'Uh Oh. Something is missing. Try double checking things.', 'textdomain' ); ?></p>
                            </section>
                            <footer class="article-footer">
                                <p><?php esc_html_e( 'This is the error message in the single.php template.', 'textdomain' ); ?></p>
                            </footer>
                        </article>
                    <?php endif; ?>

                </div><!-- .col-md-8 col-lg-9 -->

                <!-- סרגל צד (Sidebar) -->
                <?php get_sidebar(); ?>

            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- #main -->
</div><!-- #primary -->

<?php
/**
 * הגדרת שורטקוד לדוגמה
 * מומלץ להעביר קוד כזה ל-functions.php,
 * אך במקרה שיש צורך להישאר כאן, נשאיר אותו:
 */
if ( ! shortcode_exists( 'category-trail' ) ) {
    add_shortcode( 'category-trail', 'category_trail_shortcode' );
}

get_footer(); 
?>