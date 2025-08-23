 codex/move-custom-post-types-file-and-update-includes
<?php

add_action('init', 'register_custom_post_types');

function register_custom_post_types()
{
    register_post_type('lawyers',
        array(
            'labels' => array(
                'name' => __('עורכי דין', 'bonestheme'), /* This is the Title of the Group */
                'singular_name' => __('עורך דין', 'bonestheme'), /* This is the individual type */
                'all_items' => __('כל עורכין הדין', 'bonestheme'), /* the all items menu item */
                'add_new' => __('הוסף חדש', 'bonestheme'), /* The add new menu item */
                'add_new_item' => __('הוסף עורך דין חדש', 'bonestheme'), /* Add New Display Title */
                'edit' => __('ערוך', 'bonestheme'), /* Edit Dialog */
                'edit_item' => __('ערוך פרופיל', 'bonestheme'), /* Edit Display Title */
                'new_item' => __('עורך דין חדש', 'bonestheme'), /* New Display Title */
                'view_item' => __('צפה בפרופיל', 'bonestheme'), /* View Display Title */
                'search_items' => __('חפש עורכי דין', 'bonestheme'), /* Search Custom Type Title */
                'not_found' => __('Nothing found in the Database.', 'bonestheme'), /* This displays if there are no entries yet */
                'not_found_in_trash' => __('Nothing found in Trash', 'bonestheme'), /* This displays if there is nothing in the trash */
                'parent_item_colon' => ''
            ), /* end of arrays */
            'description' => __('עורכי דין', 'bonestheme'), /* Custom Type Description */
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'show_ui' => true,
            'query_var' => true,
            'menu_position' => 5, /* this is what order you want it to appear in on the left hand side menu */
            'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
            'rewrite' => array('slug' => __('עורכי-דין', 'URL slug', 'bonestheme'), 'with_front' => false), /* you can specify its url slug */
            'has_archive' => true, /* you can rename the slug here */
            'capability_type' => 'post',
            'hierarchical' => false,
            /* the next one is important, it tells what's enabled in the post editor */
            'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'page-attributes', 'custom-fields', 'comments', 'revisions', 'sticky')

        )
    );
    // creating (registering) the custom type
    register_post_type('articles', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */


        // let's now add all the options for this post type
        array('labels' => array(
            'name' => __('מאמרים', 'bonestheme'), /* This is the Title of the Group */
            'singular_name' => __('מאמר', 'bonestheme'), /* This is the individual type */
            'all_items' => __('כל  המאמרים', 'bonestheme'), /* the all items menu item */
            'add_new' => __('הוסף מאמר', 'bonestheme'), /* The add new menu item */
            'add_new_item' => __('הוסף מאמר חדש', 'bonestheme'), /* Add New Display Title */
            'edit' => __('ערוך', 'bonestheme'), /* Edit Dialog */
            'edit_item' => __('ערוך מאמר', 'bonestheme'), /* Edit Display Title */
            'new_item' => __('מאמר חדש', 'bonestheme'), /* New Display Title */
            'view_item' => __('צפה במאמר', 'bonestheme'), /* View Display Title */
            'search_items' => __('חפש מאמרים', 'bonestheme'), /* Search Custom Type Title */
            'not_found' => __('לא נמצאו תוצאות.', 'bonestheme'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('לא נמצא דבר בפח האשפה', 'bonestheme'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ), /* end of arrays */
            'description' => __('מאמרים', 'bonestheme'), /* Custom Type Description */
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'show_ui' => true,
            'query_var' => true,
            'menu_position' => 3, /* this is what order you want it to appear in on the left hand side menu */
            'rewrite' => array('slug' => __('articles', 'URL slug', 'bonestheme'), 'with_front' => false), /* you can specify its url slug */
            'has_archive' => true, /* you can rename the slug here */
            'capability_type' => 'post',
            'hierarchical' => true,
            'show_in_nav_menus' => true,
            /* the next one is important, it tells what's enabled in the post editor */
            'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'page-attributes', 'custom-fields', 'comments', 'revisions', 'sticky')
        ) /* end of options */

    ); /* end of register post type */
    register_taxonomy('locations',
        array('lawyers'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
        array('hierarchical' => true,    /* if this is false, it acts like tags */
            'labels' => array(
                'name' => __('איזורים', 'bonestheme'), /* name of the custom taxonomy */
                'singular_name' => __('איזור', 'bonestheme'), /* single taxonomy name */
                'search_items' => __('חפש אזיור', 'bonestheme'), /* search title for taxomony */
                'parent_item' => __('אזור אב', 'bonestheme'), /* parent title for taxonomy */
                'edit_item' => __('ערוך איזור', 'bonestheme'), /* edit custom taxonomy title */
                'update_item' => __('עדכן איזור', 'bonestheme'), /* update title for taxonomy */
                'add_new_item' => __('הוסף איזור חדש', 'bonestheme'), /* add new title for taxonomy */
                'new_item_name' => __('שם איזור חדש', 'bonestheme') /* name title for taxonomy */
            ),
            'show_admin_column' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array('slug' => __('איזורים', 'URL slug', 'bonestheme')),
        )
    );
    register_taxonomy('practice-areas',
        array('articles'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
        array('hierarchical' => true,    /* if this is false, it acts like tags */
            'labels' => array(
                'name' => __('קטגוריות מאמרים', 'bonestheme'), /* name of the custom taxonomy */
                'singular_name' => __('תחום', 'bonestheme'), /* single taxonomy name */
                'search_items' => __('חפש תחום', 'bonestheme'), /* search title for taxomony */
                'all_items' => __('כל התחומים', 'bonestheme'), /* all title for taxonomies */
                'parent_item' => __('תחום אב', 'bonestheme'), /* parent title for taxonomy */
                'parent_item_colon' => __('תחום אב:', 'bonestheme'), /* parent taxonomy title */
                'edit_item' => __('ערוך תחום', 'bonestheme'), /* edit custom taxonomy title */
                'update_item' => __('עדכן תחום', 'bonestheme'), /* update title for taxonomy */
                'add_new_item' => __('הוסף תחום חדש', 'bonestheme'), /* add new title for taxonomy */
                'new_item_name' => __('שם תחום חדש', 'bonestheme') /* name title for taxonomy */
            ),
            'show_admin_column' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array('slug' => __('קטגוריות-מאמרים', 'URL slug', 'bonestheme')),
        )
    );
    register_taxonomy('lawyer-cat',
        array('lawyers'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
        array('hierarchical' => true,    /* if this is false, it acts like tags */
            'labels' => array(
                'name' => __('תחומי התמחות', 'bonestheme'), /* name of the custom taxonomy */
                'singular_name' => __('תחום', 'bonestheme'), /* single taxonomy name */
                'search_items' => __('חפש תחןם', 'bonestheme'), /* search title for taxomony */
                'all_items' => __('כל התחומים', 'bonestheme'), /* all title for taxonomies */
                'parent_item' => __('תחום אב', 'bonestheme'), /* parent title for taxonomy */
                'parent_item_colon' => __('איזור אב:', 'bonestheme'), /* parent taxonomy title */
                'edit_item' => __('ערוך תחום', 'bonestheme'), /* edit custom taxonomy title */
                'update_item' => __('עדכן תחום', 'bonestheme'), /* update title for taxonomy */
                'add_new_item' => __('הוסף תחום חדש', 'bonestheme'), /* add new title for taxonomy */
                'new_item_name' => __('שם תחום חדש', 'bonestheme') /* name title for taxonomy */
            ),
            'show_admin_column' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array('slug' => __('תחומי-התמחות', 'URL slug', 'bonestheme')),
        )
    );

}

<?php
 codex/convert-line-endings-and-register-post-types
function register_theme_post_types() {
    register_post_type('articles', array(
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'articles'),
        'supports' => array('title','editor','thumbnail','excerpt','author','comments'),
    ));
    register_post_type('lawyer', array(
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'lawyer'),
        'supports' => array('title','editor','thumbnail','excerpt','author','comments'),
    ));
    register_taxonomy('practice-area', 'lawyer', array(
        'public' => true,
        'hierarchical' => true,
        'rewrite' => array('slug' => 'practice-area'),
        'show_admin_column' => true,
    ));
}
add_action('init','register_theme_post_types');
function theme_flush_rewrite() {
    register_theme_post_types();
    flush_rewrite_rules();
}
add_action('after_switch_theme','theme_flush_rewrite');

add_action('init', function () {
    $lawyer_meta = ['phone', 'email', 'website', 'linkedin', 'office_location'];
    foreach ($lawyer_meta as $key) {
        register_post_meta('lawyers', $key, [
            'type' => 'string',
            'single' => true,
            'show_in_rest' => true,
            'sanitize_callback' => 'sanitize_text_field',
        ]);
    }
});
 main
 main
