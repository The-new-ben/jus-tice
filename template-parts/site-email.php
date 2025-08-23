 codex/create-acf-wrapper-functions
<?php $site_email = theme_get_field('site_email', 'option'); ?>

<?php $site_email = function_exists('get_field') ? get_field('site_email', 'option') : ''; ?>
 main

<a href="mailto:<?php echo $site_email; ?>" class="site-email"><?php echo $site_email; ?></a>