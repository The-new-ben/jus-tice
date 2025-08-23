 codex/create-acf-wrapper-functions
<?php $site_phone = theme_get_field('site_phone1', 'option'); ?>

<?php $site_phone = function_exists('get_field') ? get_field('site_phone1', 'option') : ''; ?>
 main

<a href="tel:<?php echo $site_phone; ?>" class="site-phone"><?php echo $site_phone; ?></a>