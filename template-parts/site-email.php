<?php $site_email = function_exists('get_field') ? get_field('site_email', 'option') : ''; ?>

<a href="mailto:<?php echo $site_email; ?>" class="site-email"><?php echo $site_email; ?></a>