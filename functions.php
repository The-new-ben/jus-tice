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
require_once get_template_directory() . '/inc/custom-post-types.php';
require_once get_template_directory() . '/inc/blocks-loader.php';
 codex/register-_ai_meta-post-meta-with-rest-exposure
require_once get_template_directory() . '/inc/ai-meta.php';

 codex/log-404-requests-in-custom-table
require_once get_template_directory() . '/inc/redirects.php';

require_once get_template_directory() . '/inc/structured-data.php';
 main
 main
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
  $wp_customize->add_section('business_info', array(
    'title' => __( 'Business Info', 'bonestheme' ),
    'priority' => 30
  ));
  $wp_customize->add_setting('business_name', array('sanitize_callback' => 'sanitize_text_field'));
  $wp_customize->add_control('business_name', array(
    'label' => __( 'Business Name', 'bonestheme' ),
    'section' => 'business_info',
    'type' => 'text'
  ));
  $wp_customize->add_setting('business_address', array('sanitize_callback' => 'sanitize_text_field'));
  $wp_customize->add_control('business_address', array(
    'label' => __( 'Address', 'bonestheme' ),
    'section' => 'business_info',
    'type' => 'text'
  ));
  $wp_customize->add_setting('business_phone', array('sanitize_callback' => 'sanitize_text_field'));
  $wp_customize->add_control('business_phone', array(
    'label' => __( 'Phone', 'bonestheme' ),
    'section' => 'business_info',
    'type' => 'text'
  ));
  $wp_customize->add_setting('business_email', array('sanitize_callback' => 'sanitize_text_field'));
  $wp_customize->add_control('business_email', array(
    'label' => __( 'Email', 'bonestheme' ),
    'section' => 'business_info',
    'type' => 'text'
  ));
  $wp_customize->add_setting('business_hours', array('sanitize_callback' => 'sanitize_textarea_field'));
  $wp_customize->add_control('business_hours', array(
    'label' => __( 'Opening Hours', 'bonestheme' ),
    'section' => 'business_info',
    'type' => 'textarea'
  ));
  $wp_customize->add_setting('business_lat', array('sanitize_callback' => 'sanitize_text_field'));
  $wp_customize->add_control('business_lat', array(
    'label' => __( 'Latitude', 'bonestheme' ),
    'section' => 'business_info',
    'type' => 'text'
  ));
  $wp_customize->add_setting('business_lng', array('sanitize_callback' => 'sanitize_text_field'));
  $wp_customize->add_control('business_lng', array(
    'label' => __( 'Longitude', 'bonestheme' ),
    'section' => 'business_info',
    'type' => 'text'
  ));
}
add_action( 'customize_register', 'bones_theme_customizer' );

function bones_local_business_schema() {
  $name = get_theme_mod('business_name');
  $address = get_theme_mod('business_address');
  $phone = get_theme_mod('business_phone');
  $email = get_theme_mod('business_email');
  $hours = get_theme_mod('business_hours');
  $lat = get_theme_mod('business_lat');
  $lng = get_theme_mod('business_lng');
  if ($name || $address || $phone || $email || $hours || ($lat && $lng)) {
    $data = array(
      '@context' => 'https://schema.org',
      '@type' => 'LocalBusiness'
    );
    if ($name) {
      $data['name'] = $name;
    }
    if ($address) {
      $data['address'] = $address;
    }
    if ($phone) {
      $data['telephone'] = $phone;
    }
    if ($email) {
      $data['email'] = $email;
    }
    if ($hours) {
      $data['openingHours'] = $hours;
    }
    if ($lat && $lng) {
      $data['geo'] = array(
        '@type' => 'GeoCoordinates',
        'latitude' => $lat,
        'longitude' => $lng
      );
    }
    echo '<script type="application/ld+json">' . wp_json_encode($data) . '</script>';
  }
}
add_action('wp_head', 'bones_local_business_schema');

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
    'https://fonts.googleapis.com/css?family=Assistant:300,400,600,700,800|Montserrat&display=swap&subset=hebrew',
    array(),
    null
  );
}
add_action( 'wp_enqueue_scripts', 'bones_fonts' );

function bones_preconnect_fonts($urls, $relation_type) {
  if (in_array($relation_type, array('preconnect'), true)) {
    $urls[] = array('href' => 'https://fonts.googleapis.com', 'crossorigin' => true);
    $urls[] = array('href' => 'https://fonts.gstatic.com', 'crossorigin' => true);
  }
  return $urls;
}
add_filter('wp_resource_hints', 'bones_preconnect_fonts', 10, 2);

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
            $icon = function_exists('get_field') ? get_field('menu_icon', $item) : '';
            if( $icon ) {
                // סניטציה לאובייקט התמונה
                $icon_url = esc_url( $icon['url'] ?? '' );
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

/* ---------------------------------------------------------------------------
 * 17. דוגמה לטעינת סקריפטים משלכם
 * --------------------------------------------------------------------------- */
function my_theme_scripts() {
    // Enqueue jQuery (נטען בדפדפן אוטומטית בוורדפרס, אך אם צריך ידנית, זהו המקום)
    wp_enqueue_script('jquery');

    // Enqueue custom script (ודאו שהנתיב קיים)
    // פרמטר אחרון true -> הטעינה תתרחש לפני סגירת </body> (מומלץ)
    wp_enqueue_script(
      'my-script',
      get_template_directory_uri() . '/path/to/your/script.js',
      array('jquery'),
      '1.0.0',
      true
    );
}
add_action('wp_enqueue_scripts', 'my_theme_scripts');

/* ---------------------------------------------------------------------------
 * 18. שורטקוד category-trail (דוגמה)
 * --------------------------------------------------------------------------- */
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

 codex/add-frontend-script-for-vitals-reporting
 codex/add-frontend-script-for-vitals-reporting
add_action('init', function(){
    add_rewrite_rule('^ai/v1/vitals/?','index.php?rest_route=/ai/v1/vitals','top');
});

add_action('rest_api_init', function(){
    register_rest_route('ai/v1','/vitals',array(
        'methods'=>'POST',
        'callback'=>'ai_store_vitals',
        'permission_callback'=>'__return_true'
    ));
});

function ai_store_vitals(WP_REST_Request $r){
    global $wpdb;
    $t=$wpdb->prefix.'ai_vitals';
    $c=$wpdb->get_charset_collate();
    $s="CREATE TABLE IF NOT EXISTS $t (id bigint(20) unsigned NOT NULL auto_increment,url text NOT NULL,ttfb float,lcp float,recorded_at datetime DEFAULT CURRENT_TIMESTAMP,PRIMARY KEY (id)) $c;";
    require_once ABSPATH.'wp-admin/includes/upgrade.php';
    dbDelta($s);
    $wpdb->insert($t,array(
        'url'=>$r->get_param('url'),
        'ttfb'=>$r->get_param('ttfb'),
        'lcp'=>$r->get_param('lcp')
    ));
    return rest_ensure_response(array('ok'=>true));
}

=======
 codex/add-canonical-and-alternate-tags
function justice_rel_links() {
    if (is_singular()) {
        $u = get_permalink();
        echo '<link rel="canonical" href="' . esc_url($u) . '">';
        $langs = function_exists('pll_languages_list') ? pll_languages_list() : (function_exists('icl_get_languages') ? array_keys(icl_get_languages()) : get_available_languages());
        if (is_array($langs) && count($langs) > 1) {
            foreach ($langs as $code) {
                $link = $u;
                if (function_exists('pll_get_post')) {
                    $p = pll_get_post(get_the_ID(), $code);
                    if ($p) {
                        $link = get_permalink($p);
                    }
                } elseif (function_exists('icl_object_id')) {
                    $link = apply_filters('wpml_permalink', $u, $code);
                } else {
                    $link = add_query_arg('lang', $code, $u);
                }
                echo '<link rel="alternate" hreflang="' . esc_attr($code) . '" href="' . esc_url($link) . '">';
            }
        }
    }
}
add_action('wp_head','justice_rel_links');

 codex/register-post-meta-for-variant-titles
add_action('init',function(){
    register_post_meta('', '_ab_h1', ['show_in_rest'=>true,'single'=>true,'type'=>'string','auth_callback'=>function(){return current_user_can('edit_posts');}]);
});

add_action('wp',function(){
    if(!is_singular())return;
    $id=get_queried_object_id();
    $meta=get_post_meta($id,'_ab_h1',true);
    if(!$meta)return;
    $variants=array_map('trim',preg_split("/\r\n|\r|\n/",$meta));
    if(count($variants)<2)return;
    $key='ab_h1_'.$id;
    if(!isset($_COOKIE[$key])){
        $index=array_rand($variants);
        setcookie($key,$index,time()+2592000,COOKIEPATH,COOKIE_DOMAIN);
        $_COOKIE[$key]=$index;
    }
    $GLOBALS['ab_h1_variant']=$variants[$_COOKIE[$key]];
});

add_filter('the_title',function($title,$post_id){
    if(!is_singular()||$post_id!==get_the_ID())return $title;
    if(!empty($GLOBALS['ab_h1_variant']))return $GLOBALS['ab_h1_variant'];
    return $title;
},10,2);

 codex/add-alt-text-for-images-without-description
add_action('add_attachment', 'jt_populate_image_alt');
function jt_populate_image_alt($post_id) {
    $post = get_post($post_id);
    if (!$post) {
        return;
    }
    if (strpos($post->post_mime_type, 'image/') !== 0) {
        return;
    }
    $alt = get_post_meta($post_id, '_wp_attachment_image_alt', true);
    if ($alt) {
        return;
    }
    $title = get_the_title($post_id);
    if ($title) {
        update_post_meta($post_id, '_wp_attachment_image_alt', sanitize_text_field($title));
        return;
    }
    $description = jt_generate_image_description($post_id);
    if ($description) {
        update_post_meta($post_id, '_wp_attachment_image_alt', $description);
    }
}

function jt_generate_image_description($post_id) {
    $path = get_attached_file($post_id);
    if (!$path || !file_exists($path)) {
        return '';
    }
    $data = file_get_contents($path);
    if (!$data) {
        return '';
    }
    $body = [
        'model' => 'gpt-4o-mini',
        'input' => [[
            'role' => 'user',
            'content' => [
                ['type' => 'input_text', 'text' => 'Describe this image for alt text'],
                ['type' => 'input_image', 'image_base64' => base64_encode($data)]
            ]
        ]],
        'max_output_tokens' => 150
    ];
    $response = wp_remote_post('https://api.openai.com/v1/responses', [
        'headers' => [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . getenv('OPENAI_API_KEY')
        ],
        'body' => wp_json_encode($body),
        'timeout' => 60
    ]);
    if (is_wp_error($response)) {
        return '';
    }
    $body = wp_remote_retrieve_body($response);
    if (!$body) {
        return '';
    }
    $data = json_decode($body, true);
    $text = $data['output'][0]['content'][0]['text'] ?? '';
    return sanitize_text_field($text);
}

 codex/extend-wp-core-sitemaps-with-custom-post-types
add_filter('wp_sitemaps_post_types', function($post_types){
    $post_types['articles'] = 'articles';
    $post_types['lawyers'] = 'lawyers';
    return $post_types;
});

add_action('init', function(){
    add_rewrite_rule('feed/json/?$', 'index.php?json_feed=1', 'top');
});

add_filter('query_vars', function($vars){
    $vars[] = 'json_feed';
    return $vars;
});

add_action('template_redirect', function(){
    if (get_query_var('json_feed')) {
        $posts = get_posts(['numberposts' => 10, 'post_status' => 'publish']);
        $items = [];
        foreach ($posts as $p) {
            $items[] = [
                'id' => $p->ID,
                'title' => get_the_title($p),
                'link' => get_permalink($p),
                'date' => get_the_date('c', $p),
            ];
        }
        wp_send_json(['items' => $items]);
    }
});

 main
 codex/define-root-level-variables-in-style.css
function theme_styles(){
  wp_enqueue_style('theme-root', get_stylesheet_uri());
  wp_enqueue_style('theme-base', get_template_directory_uri().'/base.css', array('theme-root'));
  wp_enqueue_style('theme-layout', get_template_directory_uri().'/layout.css', array('theme-base'));
  wp_enqueue_style('theme-components', get_template_directory_uri().'/components.css', array('theme-layout'));
}
add_action('wp_enqueue_scripts','theme_styles');

 codex/add-related-posts-block-after-first-h2
function related_links_block($content) {
    if (!is_singular('post')) {
        return $content;
    }
    global $post;
    $related = get_posts(array(
        's' => $post->post_title,
        'post__not_in' => array($post->ID),
        'posts_per_page' => 5
    ));
    if (!$related) {
        return $content;
    }
    $html = '<div class="related-links"><h2>Related Posts</h2><ul>';
    foreach ($related as $p) {
        $html .= '<li><a href="' . get_permalink($p) . '">' . esc_html(get_the_title($p)) . '</a></li>';
    }
    $html .= '</ul></div>';
    if (strpos($content, '<h2') !== false) {
        $content = preg_replace('/(<h2[^>]*>.*?<\/h2>)/i', '$1' . $html, $content, 1);
    } else {
        $content .= $html;
    }
    return $content;
}
add_filter('the_content', 'related_links_block');

codex/filter-pre_get_document_title-for-singular-views
function aero_index_document_title($title) {
    if (is_singular()) {
        $title = get_the_title(get_queried_object_id());
    }
    return $title;
}
add_filter('pre_get_document_title','aero_index_document_title');

function aero_index_meta_tags() {
    if (is_singular()) {
        $post_obj = get_queried_object();
        $description = '';
        if ($post_obj) {
            $description = wp_strip_all_tags(get_the_excerpt($post_obj));
        }
        $description = esc_attr($description);
        $title = esc_attr(get_the_title($post_obj));
        $url = esc_url(get_permalink($post_obj));
        $site = esc_attr(get_bloginfo('name'));
        echo '<meta name="description" content="' . $description . '">';
        echo '<meta property="og:title" content="' . $title . '">';
        echo '<meta property="og:description" content="' . $description . '">';
        echo '<meta property="og:url" content="' . $url . '">';
        echo '<meta property="og:site_name" content="' . $site . '">';
        $image = get_the_post_thumbnail_url($post_obj, 'full');
        if ($image) {
            echo '<meta property="og:image" content="' . esc_url($image) . '">';
        }
    }
}
add_action('wp_head','aero_index_meta_tags');

function jus_indexnow_register_settings() {
    register_setting('jus_indexnow', 'indexnow_api_key');
    register_setting('jus_indexnow', 'indexnow_host');
}
add_action('admin_init', 'jus_indexnow_register_settings');

function jus_indexnow_add_options_page() {
    add_options_page('IndexNow', 'IndexNow', 'manage_options', 'jus-indexnow', 'jus_indexnow_render_settings');
}
add_action('admin_menu', 'jus_indexnow_add_options_page');

function jus_indexnow_render_settings() {
    ?>
    <div class="wrap">
        <h1>IndexNow</h1>
        <form method="post" action="options.php">
            <?php settings_fields('jus_indexnow'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="indexnow_api_key">API Key</label></th>
                    <td><input name="indexnow_api_key" type="text" id="indexnow_api_key" value="<?php echo esc_attr(get_option('indexnow_api_key')); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="indexnow_host">Host</label></th>
                    <td><input name="indexnow_host" type="text" id="indexnow_host" value="<?php echo esc_attr(get_option('indexnow_host')); ?>" class="regular-text" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function jus_indexnow_submit_url($post_id, $post, $update) {
    if (wp_is_post_revision($post_id)) {
        return;
    }
    if ($post->post_status !== 'publish') {
        return;
    }
    $key = get_option('indexnow_api_key');
    $host = get_option('indexnow_host');
    if (!$key || !$host) {
        return;
    }
    $url = get_permalink($post_id);
    $body = array(
        'host' => $host,
        'key' => $key,
        'urlList' => array($url)
    );
    wp_remote_post('https://www.bing.com/indexnow', array(
        'headers' => array('Content-Type' => 'application/json'),
        'body' => wp_json_encode($body),
        'timeout' => 10
    ));
}
add_action('save_post', 'jus_indexnow_submit_url', 10, 3);
 main
 main
 main
 main
 codex/add-frontend-script-for-vitals-reporting

 main
 main
 main
 main
