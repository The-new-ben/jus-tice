<?php get_header();
$category = get_queried_object();
$var = $category->term_id;
function get_all_vehicle_posts( $query ) {
    $query->set( 'posts_per_page', '-1' );
}
add_action( 'pre_get_posts', 'get_all_vehicle_posts' );
?>

<div id="main" class="site-main" role="main">	
    <?php // the_archive_description() ;?>
	<div id="articles">
        <div class="container">
            <div class="row">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/article-box'); ?>
                <?php endwhile;endif; ?>
            </div>
       </div>
    </div>
</div>

<?php get_footer(); ?>
