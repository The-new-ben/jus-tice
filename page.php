<?php get_header(); ?>
<?php $content_width = function_exists('get_field') ? get_field('content_width') : '';?>
<div id="primary" class="content-area">
    <main id="main" class="site-main <?php echo $content_width ?>" role="main">
        <div class="container">

            <?php
            while (have_posts()) : the_post();?>
               <div class="entry-content">
                   <?php the_content() ;?>
            <?php endwhile;?>

        </div>

    </main>
</div>

<?php get_footer(); ?>
