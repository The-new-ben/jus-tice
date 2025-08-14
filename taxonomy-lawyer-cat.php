<?php
get_header();
?>

<div id="main" class="site-main" role="main">
    <div id="articles">
        <div class="container">

            <?php
            // קבלת התיאור של הטקסונומיה
            $description = term_description();
            
            // בדיקה אם התיאור לא ריק
            if ( ! empty( $description ) ) : ?>
                <div class="term-desc text-center">
                    <?php // הצגת התיאור באבטחה בסיסית
                    echo wp_kses_post( $description ); ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <?php 
                // הצגת פוסטים של הטקסונומיה הראשית (למשל, "practice-areas")
                if ( have_posts() ) :
                    while ( have_posts() ) : the_post();
                        get_template_part( 'template-parts/lawyer-box' );
                    endwhile;
                endif;
                ?>
            </div>
        </div>
    </div>
</div>

<?php 
// ניווט עמודים (עצמאי או באמצעות פונקציית העזר bones_page_navi אם קיימת)
if ( function_exists( 'bones_page_navi' ) ) :
    bones_page_navi();
else : ?>
    <nav class="wp-prev-next">
        <ul class="clearfix">
            <li class="prev-link">
                <?php next_posts_link( __( '&laquo; Older Entries', 'bonestheme' ) ); ?>
            </li>
            <li class="next-link">
                <?php previous_posts_link( __( 'Newer Entries &raquo;', 'bonestheme' ) ); ?>
            </li>
        </ul>
    </nav>
<?php endif; ?>

<?php
// שאילתה נוספת עבור מאמרים מומלצים בתחום
$tax = get_queried_object();
$_posts = new WP_Query( array(
    'post_type'      => 'articles',
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'posts_per_page' => 6,
    'tax_query'      => array(
        array(
            'taxonomy' => 'practice-areas',
            'field'    => 'slug',
            'terms'    => $tax->name,
        ),
    ),
) );

if ( $_posts->have_posts() ) : ?>
    <div id="articles" class="related">
        <div class="container">
            <div class="section-title accent">
                <h2><?php esc_html_e( 'מאמרים מומלצים בתחום', 'textdomain' ); ?></h2>
            </div>
            <div class="row">
                <?php
                while ( $_posts->have_posts() ) :
                    $_posts->the_post();
                    get_template_part( 'template-parts/article-box' );
                endwhile;
                // איפוס הנתונים הגלובליים לאחר השאילתה הנוספת
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php get_footer(); ?>