<footer id="site-footer">
    <?php get_template_part('template-parts/search-bar'); ?>
    <div id="footer-content">
        <div class="container">
            <div class="row">
                <div id="footer-about" class="col-md-4">
                    <h3 class="widget-title">מי אנחנו</h3>
 codex/create-acf-wrapper-functions
                    <p><?= theme_get_field('footer_about', 'option'); ?></p>

                    <p><?= function_exists('get_field') ? get_field('footer_about', 'option') : '' ?></p>
 main
                    <a class="readmore" href="<?php echo get_page_link(28); ?>">קראו עוד עלינו<i class="aero-arrow-left-thin"></i></a>
                </div>
                <div id="footer-site-info" class="col-md-4">
                    <h3 class="widget-title">פרטי התקשרות</h3>
 codex/create-acf-wrapper-functions
                    <p><strong>כתובת</strong><span><?php echo theme_get_field('site_address1', 'option'); ?></span></p>

                    <p><strong>כתובת</strong><span><?php echo function_exists('get_field') ? get_field('site_address1', 'option') : '' ?></span></p>
 main
                    <p><strong>טלפון</strong><span><?php get_template_part('template-parts/site-phone'); ?></span></p>
                    <p><strong>אימייל</strong><span><?php get_template_part('template-parts/site-email'); ?></span></p>
                </div>
                <div id="footer-contact" class="col-auto col-md-4">
                    <h3 class="widget-title">צרו קשר</h3>
                    <?php if ( class_exists( 'GFForms' ) || function_exists( 'gravity_form' ) ) {
                        echo do_shortcode('[gravityform id="2" title="false" description="true" ajax="true"]');
                    } else {
                        echo '<p>Form could not be loaded.</p>';
                    } ?>
                </div>
            </div>
        </div>
    </div>
    <div id="footer-menus">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-sm-4">
                    <h3 class="widget-title">אינדקס עורכי דין</h3>
                    <?php aero_wp_nav_menu('footer-links-1', 'd-sm-flex flex-wrap', 'Footer Links 1', 'footer-menu', ''); ?>
                </div>
                <div class="col-xs-6 col-sm-4">
                    <h3 class="widget-title">תחומי עניין בדיני נזיקין ופיצויים</h3>
                    <ul>
                        <?php aero_wp_nav_menu('footer-links-2', 'd-sm-flex flex-wrap', 'Footer Links 2', 'footer-menu', ''); ?>
                    </ul>
                </div>
                <div class="col-xs-6 col-sm-4">
                    <h3 class="widget-title">תחומי עניין בדיני גירושין ומשפחה</h3>
                    <ul>
                        <?php aero_wp_nav_menu('footer-links-3', 'd-sm-flex flex-wrap', 'Footer Links 3', 'footer-menu', ''); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="footer-bottom-bar">
        <div class="container">
            <div class="footer-credits d-sm-flex justify-content-center">
                <div class="col-sm-4 copyrights">&copy; <?php echo date('Y'); ?> כל הזכויות שמורות <?php bloginfo('name'); ?></div>
                <div class="col-sm-3"><?php aero_wp_nav_menu('bottom-links', '', 'Bottom Links', '', 'credits-menu'); ?></div>
                <div class="col-sm-4"><a class="darolink" href="#" target="_blank">Daronet בניית אתרים</a></div>
            </div>
        </div>
    </div>

    <!-- Dynamic Lawyer Message -->
    <div class="container">
        <div class="footer-dynamic-message">
            <?php
            // Get the current hour of the day
            $hourOfDay = date("G");
            
            // Define messages for four parts of the day
            $messages = [
                "לווי משפטי מעורך דין מומלץ", // Early Morning (00:00 - 05:59)
"שרותי עורכי דין הטובים ביותר", // Morning to Noon (06:00 - 11:59)
"חיפוש עורך דין לפי תחומי התמחות", // Noon to Evening (12:00 - 17:59)
"איתור עורך דין הכי טוב", // Evening (18:00 - 23:59)
"עזרה משפטית 24/7", // Late Night (00:00 - 05:59)
"דירוג עורכי דין ומשרדים" // Early Morning (04:00 - 05:59)
];

// Determine which message to display based on the current hour
if ($hourOfDay < 6) {
    $message = $messages[3]; // "עזרה משפטית 24/7"
} elseif ($hourOfDay < 12) {
    $message = $messages[0]; // "לווי משפטי מעורך דין מומלץ"
} elseif ($hourOfDay < 18) {
    $message = $messages[1]; // "שרותי עורכי דין הטובים ביותר"
} else {
    $message = $messages[2]; // "איתור עורך דין הכי טוב"
}

// Display the message
echo $message;
?>
        </div>
    </div>
</footer>
</div> <!-- Assuming this closes a div opened before the footer -->
<?php wp_footer(); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujslafgnoy1s6s4QF0J6Gajs/r456/7M9z9z3T0TgyI" crossorigin="anonymous"></script>

</body>
</html>


