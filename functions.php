<?php
/*
 * Author: Eddie Machado
 * URL: http://themble.com/bones/
 *
 * זהו קובץ ה-functions.php של התבנית, המכיל הגדרות ופעולות ליבה.
 * חלק מהפונקציות (bones.php) נטענות דרך require_once למטה.
 */

/* ---------------------------------------------------------------------------
 * 1. REQUIRE או INCLUDE לקבצים נוספים
 * --------------------------------------------------------------------------- */

require_once get_template_directory() . '/theme-parts/custom-post-types.php'; // CPTs מותאמים
require_once get_template_directory() . '/library/bones.php';                 // ליבת Bones

// אם תרצו לאפשר התאמות פאנל אדמין בהמשך
// require_once get_template_directory() . '/library/admin.php';

require_once get_template_directory() . '/inc/acf-compatibility.php';
require_once get_template_directory() . '/inc/helpers.php';
/* ---------------------------------------------------------------------------
 * 2. הפעלת התבנית (after_setup_theme)
 * --------------------------------------------------------------------------- */

function bones_ahoy() {

  // תמיכה בתרגומים
  load_theme_textdomain( 'bonestheme', get_template_directory() . '/library/translation' );

  // הרצות Cleanup ופעולות ראשוניות
  add_action( 'init', 'bones_head_cleanup' );
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  add_filter( 'the_generator', 'bones_rss_version' );
  add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
  add_action( 'wp_head', 'bones_remove_recent_comments_style', 1 );
  add_filter( 'gallery_style', 'bones_gallery_style' );

  // טעינת סקריפטים וסגנונות
  add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 999 );

  // תמיכה בפיצ'רים של וורדפרס (תמונות פיצ'ר, פורמטים וכו')
  bones_theme_support();

  // רישום סיידבארים
  add_action( 'widgets_init', 'bones_register_sidebars' );

  // ניקוי תגיות <p> מיותרות ב-Images
  add_filter( 'the_content', 'bones_filter_ptags_on_images' );

  // עריכת excerpt
  add_filter( 'excerpt_more', 'bones_excerpt_more' );
}
add_action( 'after_setup_theme', 'bones_ahoy' );

/* ---------------------------------------------------------------------------
 * 3. הגדרת content_width
 * --------------------------------------------------------------------------- */
if ( ! isset( $content_width ) ) {
  $content_width = 680; // ערך ברירת מחדל
}

/* ---------------------------------------------------------------------------
 * 4. גדלי תמונות מותאמים
 * --------------------------------------------------------------------------- */
// רישום גדלי תמונות
add_image_size( 'profile-thumb', 250, 250, true );
add_image_size( 'profile-pic',   350, 350, true );
add_image_size( 'article-thumb', 160, 120, true );

// שילוב ל-Dropdown לבחירת גדלים
add_filter( 'image_size_names_choose', 'bones_custom_image_sizes' );
function bones_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'profile-thumb' => __( '250px by 250px', 'bonestheme' ),
        'article-thumb' => __( '160px by 120px', 'bonestheme' ),
    ) );
}


/* ---------------------------------------------------------------------------
 * 5. Theme Customizer (ניתן להרחבה)
 * --------------------------------------------------------------------------- */
function bones_theme_customizer( $wp_customize ) {
  // להוספת הגדרות/בקרות בהתאמה אישית
  // $wp_customize->remove_section('title_tagline'); // דוגמה להסרה
}
add_action( 'customize_register', 'bones_theme_customizer' );

/* ---------------------------------------------------------------------------
 * 6. Sidebars & Widget Areas
 * --------------------------------------------------------------------------- */
function bones_register_sidebars() {

  register_sidebar(array(
    'id'            => 'sidebar1',
    'name'          => __( 'Sidebar 1', 'bonestheme' ),
    'description'   => __( 'The first (primary) sidebar.', 'bonestheme' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h4 class="widgettitle">',
    'after_title'   => '</h4>',
  ));

  // דוגמה ליצירת Sidebar נוסף
  // register_sidebar(array( ... ));
}

/* ---------------------------------------------------------------------------
 * 7. טעינת גופנים
 * --------------------------------------------------------------------------- */
function bones_fonts() {
  // מומלץ: לקרוא ל- wp_enqueue_style פעם אחת להקטנת התנגשויות
  // ולבדוק אם לא "דורסים" את אותו handle פעמיים
  wp_enqueue_style( 
    'bones-google-fonts', 
    'https://fonts.googleapis.com/css?family=Assistant:300,400,600,700,800&display=swap&subset=hebrew', 
    array(), 
    null 
  );

  // במקרה שרוצים להוסיף פונט נוסף, אפשר לרשום handle נפרד או לאחד לרשימה אחת
  wp_enqueue_style(
    'bones-google-fonts-secondary',
    'https://fonts.googleapis.com/css?family=Montserrat&display=swap',
    array(),
    null
  );
}
add_action( 'wp_enqueue_scripts', 'bones_fonts' );

/* ---------------------------------------------------------------------------
 * 8. ACF Options Page (במידה ומשתמשים ב-ACF Pro)
 * --------------------------------------------------------------------------- */
if( function_exists('acf_add_options_page') ) {
  acf_add_options_page(array(
    'page_title'  => __( 'הגדרות אתר', 'bonestheme' ),
    'menu_title'  => __( 'הגדרות אתר', 'bonestheme' ),
    'menu_slug'   => 'theme-general-settings',
    'capability'  => 'edit_theme_options',
    'redirect'    => false
  ));
}

/* ---------------------------------------------------------------------------
 * 9. עיטוף embed ב-div רספונסיבי (Bootstrap-like)
 * --------------------------------------------------------------------------- */
function div_wrapper($content) {
    // match iframes או embed
    $pattern = '~<iframe.*</iframe>|<embed.*</embed>~';
    preg_match_all($pattern, $content, $matches);

    foreach ($matches[0] as $match) {
        $wrapped = '<div class="embed-responsive embed-responsive-16by9">' . $match . '</div>';
        $content = str_replace($match, $wrapped, $content);
    }
    return $content;    
}
add_filter( 'the_content', 'div_wrapper' );
add_filter( 'the_excerpt', 'div_wrapper' );

/* ---------------------------------------------------------------------------
 * 10. הגדרת נראות לתוויות בשדות Gravity Forms
 * --------------------------------------------------------------------------- */
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );

/* ---------------------------------------------------------------------------
 * 11. פונקציית excerpt מותאמת
 * --------------------------------------------------------------------------- */
function excerpt($limit) {
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt) >= $limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
    } else {
        $excerpt = implode(" ",$excerpt);
    }
    // הסרה של Shortcodes (סינון נוסף לסניטציה/אבטחה לפי צורך)
    $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
    return $excerpt;
}

/* ---------------------------------------------------------------------------
 * 12. תמיכה בהעלאת SVG (הוספה ל-MIME Types)
 * --------------------------------------------------------------------------- */
function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

/* ---------------------------------------------------------------------------
 * 13. הוספת אייקונים מה-ACF בשורת התפריט (למשל ב-main-nav)
 * --------------------------------------------------------------------------- */
add_filter('wp_nav_menu_objects', 'my_wp_nav_menu_objects', 10, 2);
function my_wp_nav_menu_objects( $items, $args ) {
    // וידוא שה-Menu location הוא main-nav
    if( $args->theme_location === 'main-nav' ) {
        foreach( $items as &$item ) {
            $icon = get_field('menu_icon', $item);
            if( $icon ) {
                // סניטציה לאובייקט התמונה
                $icon_url = esc_url( $icon['url'] );
                $item->title = '<img src="'. $icon_url .'" alt="" /> ' . $item->title;
            }
        }
    }
    return $items;
}

/* ---------------------------------------------------------------------------
 * 14. תיקון סיווגי תפריט למניעת בחירה של Blog בפוסט-טייפ אחר
 * --------------------------------------------------------------------------- */
add_filter('nav_menu_css_class', 'mytheme_custom_type_nav_class', 10, 2);
function mytheme_custom_type_nav_class($classes, $item) {
    $post_type = get_post_type();

    // אם זה לא post, מסירים current_page_parent מעמוד הבלוג
    if ( $post_type !== 'post' && (int) $item->object_id === (int) get_option('page_for_posts') ) {
        $classes = array_diff($classes, array('current_page_parent'));
    }

    // מוסיפים מחלקה עבור post-type ספציפי
    $this_type_class = 'post-type-' . $post_type;
    if ( in_array( $this_type_class, $classes ) ) {
        $classes[] = 'current_page_parent';
    }
    return $classes;
}

/* ---------------------------------------------------------------------------
 * 15. התאמות עיצוב בממשק Admin עבור ACF
 * --------------------------------------------------------------------------- */
add_action('acf/input/admin_head', 'my_acf_admin_head');
function my_acf_admin_head() {
    ?>
    <style type="text/css">
        .acf-flexible-content .layout .acf-fc-layout-handle {
            background-color: #202428;
            color: #eee;
        }
        .acf-repeater.-row > table > tbody > tr > td,
        .acf-repeater.-block > table > tbody > tr > td {
            border-top: 2px solid #202428;
        }
        .acf-repeater .acf-row-handle span {
            font-size: 16px;
        }
        .imageUpload img {
            width: 75px;
        }
    </style>
    <?php
}

/* ---------------------------------------------------------------------------
 * 16. החלפת ה-Label "Posts" ל"חדשות" (דוגמה)
 * --------------------------------------------------------------------------- */
function change_post_menu_label() {
    global $menu, $submenu;
    $menu[5][0]                = __( 'חדשות', 'bonestheme' );
    $submenu['edit.php'][5][0] = __( 'חדשות', 'bonestheme' );
    $submenu['edit.php'][10][0] = __( 'הוסף חדשה', 'bonestheme' );
}
function change_post_object_label() {
    global $wp_post_types;
    $labels                     = &$wp_post_types['post']->labels;
    $labels->name              = __( 'חדשות', 'bonestheme' );
    $labels->singular_name     = __( 'פרסום', 'bonestheme' );
    $labels->add_new           = __( 'הוסף פרסום חדש', 'bonestheme' );
    $labels->add_new_item      = __( 'הוסף פרסום', 'bonestheme' );
    $labels->edit_item         = __( 'ערוך פרסום', 'bonestheme' );
    $labels->new_item          = __( 'פרסום', 'bonestheme' );
    $labels->view_item         = __( 'צפה בפרסום', 'bonestheme' );
    $labels->search_items      = __( 'חפש פרסומים', 'bonestheme' );
    $labels->not_found         = __( 'לא נמצאו פרסומים', 'bonestheme' );
    $labels->not_found_in_trash= __( 'לא נמצאו פרסומים בפח', 'bonestheme' );
}
add_action( 'init', 'change_post_object_label' );
add_action( 'admin_menu', 'change_post_menu_label' );

function jus_tice_scripts() {
    wp_deregister_script('jquery');
    wp_register_script('jquery','https://code.jquery.com/jquery-3.6.0.min.js',array(),null,true);
    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap','https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js',array('jquery'),null,true);
    wp_enqueue_script('theme-main',get_template_directory_uri().'/script.js',array('jquery'),null,true);
}
add_action('wp_enqueue_scripts','jus_tice_scripts');

function category_trail_shortcode() {
    $categories = get_the_category();
    $output = '';
    if ( ! empty( $categories ) ) {
        $output .= '<ul class="category-trail">';
        foreach ( $categories as $category ) {
            $output .= '<li><a href="' 
                . esc_url( get_category_link( $category->term_id ) ) . '">'
                . esc_html( $category->name ) 
                . '</a></li>';
        }
        $output .= '</ul>';
    }
    return $output;
}
add_shortcode( 'category-trail', 'category_trail_shortcode' );
