<?php
/*
	Template Name: עמוד שאלות ותשובות
*/

get_header(); ?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main mini" role="main">
            <div class="container">
            <?php while (have_posts()) : the_post(); ?>
                  <?php the_content(); ?>
                    <?php if (have_rows('faq')):  ?>
                    <div class="accordion" id="faq">
                        <?php
                        $counter = 0;
                        while (have_rows('faq')) : the_row();
                            $quest = get_sub_field('faq_quest');
                            $answer = get_sub_field('faq_answer');
                            ?>
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h3>
                                    <a class="d-flex align-items-center" type="button" data-toggle="collapse" data-target="#collapse-<?php echo $counter; ?>" aria-expanded="true" aria-controls="collapseOne">
                                        <i class="icon ion-plus"></i>
                                        <span><?php echo $quest ?></span>
                                    </a>
                                  </h3>

                            </div>
                            <div id="collapse-<?php echo $counter; ?>" class="collapse show" aria-labelledby="headingOne" data-parent="#faqExample">
                                <div class="card-body">
                                 <?php echo $answer ?>
                                </div>
                            </div>
                        </div>
                        <?php $counter++; endwhile;?>
                    </div>
                <?php endif;?>
                <?php  endwhile; ?>
            </div>
        </main>
    </div>
<?php get_footer(); ?>
