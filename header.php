<!doctype html>
<!--[if lt IE 7]>
<html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]>
<html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]>
<html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
												
<head>
    <meta charset="utf-8">

    <?php // Google Chrome Frame for IE ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	
    <title><?php wp_title(''); ?></title>

	
	
    <?php // mobile meta (hooray!) ?>
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <?php // icons & favicons ?>
<!-- <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/library/images/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/library/images/favicon.ico" type="image/x-icon"> -->
  
    <meta name="msapplication-TileColor" content="#f01d4f">
    <meta name="msapplication-TileImage"
          content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <meta name="google-site-verification" content=""/>
    <?php // wordpress head functions ?>
    <?php wp_head(); ?>
    <?php // end of wordpress head ?>

    <?php // drop Google Analytics Here ?>
    <?php // end analytics ?>
  
</head>
<body <?php body_class(); ?>>
<div class="content-wrapper row-offcanvas row-offcanvas-left">
    <?php

    $header_style = 'default'; ?>
    <div id="header-wrap" class="<?php echo $header_style ?>">
        <header>
            <div id="header-top-bar">
                <div class="container">
                    <div class="d-sm-flex justify-content-end align-items-center">
                       <!--ul class="contact-details d-none d-md-flex">
 codex/create-acf-wrapper-functions
                           <li><?php echo theme_get_field('site_address1', 'option'); ?></li>

                           <li><?php echo function_exists('get_field') ? get_field('site_address1', 'option') : '' ?></li>
 main
                           <li><?php get_template_part('template-parts/site-email'); ?></li>
                           <li><?php get_template_part('template-parts/site-phone'); ?></li>
                       </ul-->
                        <div id="header-slogan"><?php echo bloginfo('description'); ?></div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="d-flex justify-content-sm-between flex-column-reverse d-sm-row flex-sm-row">
 codex/create-acf-wrapper-functions
                    <?php $site_logo = theme_get_field('site_logo', 'option'); ?>

                    <?php
                    $site_logo_url = '';
                    $logo_field = function_exists('get_field') ? get_field('site_logo', 'option') : '';
                    if (!empty($logo_field['url'])) {
                        $site_logo_url = $logo_field['url'];
                    }
                    if (!$site_logo_url) {
                        $site_logo_url = get_template_directory_uri() . '/library/images/logo.png';
                    }
                    ?>
 main

                    <div class="logo-container">
                        <a class="logo" href="<?php echo home_url(); ?>">
                            <img src="<?php echo esc_url($site_logo_url); ?>" width="86" height="86" alt="<?php bloginfo('name'); ?>" />
                        </a>

                        <button class="navbar-toggler d-lg-none" type="button" data-toggle="offcanvas"
                                aria-controls="navbar-header">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="header-main">
                            <?php aero_wp_nav_menu('main-nav', 'main-menu', 'Main Menu', '', 'main-menu') ?>

                    </div>
                </div>
            </div>
        </header>
        <div id="header-tools">
            <div class="sidebar-offcanvas">
                <div id="top-cat-menu">
                    <div class="container">
                        <?php aero_wp_nav_menu('cat-nav', 'main-menu d-lg-flex align-items-lg-center justify-content-lg-between', 'Categories Menu', '', 'category') ?>
                    </div>

                </div>
            </div>
            <?php //get_template_part('template-parts/search-bar'); ?>
        </div>
		
        <?php if (!is_front_page() && !is_singular('lawyers')): ?>
        <div id="page-title">
            <div class="container d-flex flex-column align-items-center justify-content-center">
                <div class="caption">
                    <h1 class="title">

                        <?php
                        if (is_home()):
                            _e('חדשות', 'bonestheme');
                        elseif (is_post_type_archive('lawyers')):
                            _e('עורכי דין', 'bonestheme');
                        elseif (is_post_type_archive()):
                            post_type_archive_title();
                        elseif (is_tax() || is_category()):
                            single_cat_title();
                        elseif (is_404()):
                            _e('Epic 404 - Article Not Found', 'bonestheme');
                        elseif(is_singular('articles')):
                         $terms = get_the_terms( $post->ID , 'practice-areas' );
                           foreach( $terms as $term ) {
                               $title = $term->name;
                           }
                           echo $title;
                       else:
                            the_title();
                        endif; ?>
                  
				     </h1>
 codex/create-acf-wrapper-functions
                                                        <?php if (theme_get_field('subtitle')) {
                        echo '<p class="subtitle">' . theme_get_field('subtitle') . '</p>';

<?php if (function_exists('get_field') && get_field('subtitle')) {
                        echo '<p class="subtitle">' . (function_exists('get_field') ? get_field('subtitle') : '') . '</p>';
 main
                    } ?>
															
                    <?php if (is_home()) echo '<p class="subtitle">עורכי הדין המומלצים </p>'; ?>
                </div>
            </div>
				
        </div>
<?php endif;
echo '</div>';
?>