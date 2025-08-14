<?php
/* Template Name: Columns
*/
get_header();
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php if (have_rows('new_section')):
            $i = 1;
            while (have_rows('new_section')) : the_row();
                $section_title = get_sub_field('section_title');
                $section_class = get_sub_field('section_class');
                $section_layout = get_sub_field('section_layout');
                $section_direction = get_sub_field('section_direction');
                echo '<section class="' . $section_class . '">';
                echo '<div class="' . $section_layout . '">';
                if ($section_title)echo '<div class="section-title"><h2 class="title">' . $section_title . '</h2></div>';
                echo '<div class="row d-md-flex flex-wrap flex-md-'.$section_direction.'">';
                    if (have_rows('new_column')):

                      while (have_rows('new_column')): the_row();
                         $column_num = get_sub_field('column_num');
                         $col = 12 / $column_num;
                          $column_type =  get_sub_field('column_type');
                          $column_text =  get_sub_field('column_text');
                          $column_img =  get_sub_field('column_img');
                        echo '<div class="item col-md-' . $col . '">';
                         if ($column_type == 'img'):
                        echo '<div class="image-container"><img src="' . $column_img['url'] . '" alt="' . $column_img['alt'] . '"/></div>';
                        elseif ($column_type == 'video') :
                            // get iframe HTML
                            $iframe = get_sub_field('column_video');
                        // use preg_match to find iframe src
                            preg_match('/src="(.+?)"/', $iframe, $matches);
                            $src = $matches[1];

                            // add extra params to iframe src
                            $params = array(
                                'controls'    => 0,
                                'hd'        => 1,
                                'autohide'    => 1
                            );

                            $new_src = add_query_arg($params, $src);

                            $iframe = str_replace($src, $new_src, $iframe);


                            // add extra attributes to iframe html
                            $attributes = 'frameborder="0"';

                            $iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);
                        echo '<div class="embed-responsive embed-responsive-16by9">';
                        echo $iframe;;
                        echo '</div>';
                         else :
                        echo ' <div class="caption desc entry-content"   data-index="'.$i.'">' . $column_text . '</div>';
                        endif;
                        echo '</div>';
                      endwhile;endif;
                  echo '</div></section>';
                  $i++;
            endwhile;
        endif ?>
    </main>
</div>

<?php get_footer(); ?>