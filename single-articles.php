<?php
/**
 * תבנית להצגת פוסט מסוג 'articles'
 * כולל שיפורי ביצועים, SEO וארגון קוד.
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main has-bg" role="main">
        <div class="container">
            <div class="row">

                <div class="col-md-8 post-wrap">
                    
                    <?php if ( have_posts() ) : ?>
                        <?php while ( have_posts() ) : the_post(); ?>
                            
                            <!-- כותרת הפוסט (h1 או h2 בהתאם לאסטרטגיית SEO) -->
                            <h1 class="post-title"><?php the_title(); ?></h1>
                            
                            <?php
                            /**
                             * טעינת Template Part המתאים לפורמט הפוסט (Post Format),
                             * כולל בדיקה לסוג פוסט ומניעת שגיאות אפשריות.
                             */
                            $post_format = get_post_format();
                            $post_type   = get_post_type( get_the_ID() );
                            
                            // העדפה להשתמש ב- sanitize_title כדי למנוע בעיות רישום
                            get_template_part(
                                'post-formats/article',
                                sanitize_title( $post_type . '-' . ( $post_format ? $post_format : 'standard' ) )
                            );
                            ?>

                            <!-- הצגת אזור התגובות רק אם התגובות פעילות או קיימות תגובות -->
                            <?php if ( comments_open() || get_comments_number() ) : ?>
                                <?php comments_template(); ?>
                            <?php endif; ?>
                            
                            <!-- ניווט פוסטים באותה טקסונומיה (practice-areas) -->
                            <div id="post-navigation" class="d-sm-flex align-items-center justify-content-between">
                                <?php
                                /**
                                 * שיפור: בדיקה מוקדמת שהפוסט קיים ושהפונקציית get_the_terms לא מחזירה NULL/שגיאה.
                                 * כמו כן, יש לקחת בחשבון שיתכן והפוסט לא משויך כלל לטקסונומיה הרלוונטית.
                                 */
                                global $post;
                                $terms = get_the_terms( $post->ID, 'practice-areas' );

                                if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :
                                    // שליפת IDs של הטקסונומיה
                                    $term_ids = array_values( wp_list_pluck( $terms, 'term_id' ) );

                                    // במקרה ואין ערכים בטקסונומיה, דילוג
                                    if ( ! empty( $term_ids ) ) {
                                        $postlist_args = array(
                                            'posts_per_page' => -1,
                                            'orderby'        => 'modified',
                                            'order'          => 'DESC',
                                            'post_type'      => 'articles',
                                            'fields'         => 'ids', // שיפור ביצועים - מחזיר רק מזהים ולא אובייקטים מלאים
                                            'tax_query'      => array(
                                                array(
                                                    'taxonomy' => 'practice-areas',
                                                    'field'    => 'id',
                                                    'terms'    => end( $term_ids ),
                                                )
                                            ),
                                        );
                                        // שליפת כל הפוסטים באותה טקסונומיה
                                        $postlist = get_posts( $postlist_args );

                                        if ( ! empty( $postlist ) && ! is_wp_error( $postlist ) ) {
                                            // מערך ה-IDs
                                            $ids       = $postlist;
                                            $thisindex = array_search( $post->ID, $ids );

                                            // חישוב קודמים/באים
                                            $previd = ( isset( $ids[ $thisindex - 1 ] ) ) ? $ids[ $thisindex - 1 ] : end( $ids );
                                            $nextid = ( isset( $ids[ $thisindex + 1 ] ) ) ? $ids[ $thisindex + 1 ] : reset( $ids );

                                            // הצגת לינקים
                                            echo '<div class="post-prev col-sm-6">';
                                            echo '<a rel="prev" href="' . esc_url( get_permalink( $previd ) ) . '">';
                                            echo '<span>' . esc_html__( 'הקודם', 'textdomain' ) . '</span> ';
                                            echo '<i class="icon ion-ios-arrow-forward"></i> ';
                                            echo esc_html( get_the_title( $previd ) );
                                            echo '</a>';
                                            echo '</div>';

                                            echo '<div class="post-next col-sm-6">';
                                            echo '<a rel="next" href="' . esc_url( get_permalink( $nextid ) ) . '">';
                                            echo '<span>' . esc_html__( 'הבא', 'textdomain' ) . '</span> ';
                                            echo esc_html( get_the_title( $nextid ) );
                                            echo ' <i class="icon ion-ios-arrow-back"></i>';
                                            echo '</a>';
                                            echo '</div>';
                                        }
                                    }
                                endif;
                                ?>
                            </div>

                        <?php endwhile; // end while have_posts ?>
                    <?php endif; // end if have_posts ?>
                    
                    <?php
                    /**
                     * שליפת פוסטים מסוג 'lawyers' מאותה קטגוריה (lawyer-cat) שבה השתמשנו ב-'practice-areas'
                     * ניקוי/המרה של המונח (term) ל-slug במידה וקיים.
                     */
                    $terms = get_the_terms( get_the_ID(), 'practice-areas' );

                    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                        $term      = array_shift( $terms ); // לוקחים את הטרם הראשון
                        $term_slug = $term->slug;

                        // כדי למנוע בעיות, לבדוק אם ה-slug לא ריק
                        if ( ! empty( $term_slug ) ) {
                            
                            /**
                             * שיפור ביצועים: אפשר להשתמש ב- transient/caching אם זו שאילתה שחוזרת על עצמה לעיתים קרובות.
                             * לדוגמה: $transient_key = 'lawyers_for_' . $term_slug;
                             *         $cached_query = get_transient( $transient_key );
                             *         if ( false === $cached_query ) { ... שאילתה ... set_transient( $transient_key, $_posts, 12 * HOUR_IN_SECONDS ); }
                             */
                            
                            $_posts = new WP_Query( array(
                                'post_type'      => 'lawyers',
                                'orderby'        => 'menu_order',
                                'order'          => 'ASC',
                                'posts_per_page' => 8,
                                'tax_query'      => array(
                                    array(
                                        'taxonomy' => 'lawyer-cat',
                                        'field'    => 'slug',
                                        'terms'    => $term_slug,
                                    ),
                                ),
                            ) );

                            if ( $_posts->have_posts() ) :
                                ?>
                                <section id="lawyers">
                                    <div class="section-title full">
                                        <h2><?php esc_html_e( 'עורכי דין מומלצים בתחום', 'textdomain' ); ?></h2>
                                    </div>
                                    <div class="row">
                                        <?php
                                        while ( $_posts->have_posts() ) :
                                            $_posts->the_post();
                                            get_template_part( 'template-parts/lawyer-box' );
                                        endwhile;
                                        ?>
                                    </div>
                                </section>
                                <?php
                            endif;

                            // איפוס הגלובל של לולאת הפוסטים הנוספת
                            wp_reset_postdata();
                        }
                    }
                    ?>
                </div><!-- .col-md-8 post-wrap -->

                <?php get_sidebar( 'articles' ); ?>

            </div><!-- .row -->
        </div><!-- .container -->
    </main>
</div>

<?php
/**
 * חלק זה מציג קטגוריות/תת-קטגוריות/פוסטים באותה טקסונומיה (practice-areas).
 * אם הוא לא חייב להיות בטמפלייט, מומלץ לשקול להעביר אותו לקובץ נפרד או ליצור Widget/Shortcode.
 */
global $post;
$categories = get_the_terms( $post->ID, 'practice-areas' );

if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {

    // נוטלים את ID של הקטגוריה הראשונה
    $category_id = $categories[0]->term_id;

    // שליפת קטגוריות בנות
    $child_categories = get_categories( array(
        'taxonomy' => 'practice-areas',
        'parent'   => $category_id,
        'orderby'  => 'name',
        'order'    => 'ASC',
        'hide_empty' => false, // בהתאם לצורך שלכם
    ) );

    // הצגת תת-הקטגוריות, הפוסטים שלהן, ותת-תת-קטגוריות
    if ( ! empty( $child_categories ) ) {
        foreach ( $child_categories as $child_category ) :
            echo '<h3> ' . esc_html__( 'עו"ד מומלץ : ', 'textdomain' ) . esc_html( $child_category->name ) . '</h3>';
            
            // שליפת פוסטים מהקטגוריה הבת
            $subcat_posts = new WP_Query( array(
                'post_type'      => 'articles',
                'posts_per_page' => -1,
                'post__not_in'   => array( get_the_ID() ),
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'practice-areas',
                        'field'    => 'term_id',
                        'terms'    => $child_category->term_id,
                    ),
                ),
            ) );

            echo '<ul>';
            while ( $subcat_posts->have_posts() ) :
                $subcat_posts->the_post();
                echo '<li><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></li>';
            endwhile;
            echo '</ul>';

            wp_reset_postdata();

            // שליפת קטגוריות נוספות (נכדים)
            $other_subcategories = get_categories( array(
                'taxonomy' => 'practice-areas',
                'parent'   => $child_category->term_id,
                'orderby'  => 'name',
                'order'    => 'ASC',
                'hide_empty' => false,
            ) );

            if ( ! empty( $other_subcategories ) ) {
                echo '<h4>' . esc_html__( 'עו"ד מומלץ ', 'textdomain' ) . esc_html( $child_category->name ) . ':</h4>';
                echo '<ul>';
                foreach ( $other_subcategories as $other_subcategory ) :
                    echo '<li><a href="' . esc_url( get_term_link( $other_subcategory ) ) . '">' . esc_html( $other_subcategory->name ) . '</a></li>';
                endforeach;
                echo '</ul>';
            }
        endforeach;
    }

    // הצגת הפוסטים בקטגוריית האב עצמה
    echo '<h3>' . esc_html__( 'עו"ד מומלץ :', 'textdomain' ) . '</h3>';
    echo '<ul>';
    $parent_cat_posts = new WP_Query( array(
        'post_type'      => 'articles',
        'posts_per_page' => -1,
        'post__not_in'   => array( get_the_ID() ),
        'tax_query'      => array(
            array(
                'taxonomy' => 'practice-areas',
                'field'    => 'term_id',
                'terms'    => $category_id,
            ),
        ),
    ) );

    while ( $parent_cat_posts->have_posts() ) :
        $parent_cat_posts->the_post();
        echo '<li><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></li>';
    endwhile;
    echo '</ul>';

    wp_reset_postdata();
}
?>

<?php get_footer(); ?>

<?php 
// קריאה לשורטקוד (למשל: [category-trail]) — במידה ואתם צריכים אותו כאן:
echo do_shortcode( '[category-trail]' );