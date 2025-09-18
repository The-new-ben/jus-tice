<?php
function jt_term_external_links_install()
{
    global $wpdb;
    $table = $wpdb->prefix . 'term_external_links';
    $charset = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        term_id bigint(20) unsigned NOT NULL,
        url varchar(255) NOT NULL,
        status varchar(100) NOT NULL DEFAULT '',
        PRIMARY KEY  (id),
        KEY term_id (term_id)
    ) $charset;";
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}
add_action('after_switch_theme', 'jt_term_external_links_install');

function jt_term_external_links_admin_menu()
{
    add_menu_page('Term External Links', 'Term External Links', 'manage_options', 'jt-term-external-links', 'jt_term_external_links_admin_page');
}
add_action('admin_menu', 'jt_term_external_links_admin_menu');

function jt_term_external_links_admin_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }
    global $wpdb;
    $table = $wpdb->prefix . 'term_external_links';
    $table_exists = $wpdb->get_var($wpdb->prepare('SHOW TABLES LIKE %s', $table));
    if ($table_exists !== $table) {
        jt_term_external_links_install();
    }
    $message = '';
    $error = '';
    if (isset($_POST['jt_term_links_nonce']) && wp_verify_nonce(wp_unslash($_POST['jt_term_links_nonce']), 'jt_term_links')) {
        $action = isset($_POST['term_link_action']) ? sanitize_text_field(wp_unslash($_POST['term_link_action'])) : '';
        if ($action === 'insert') {
            $term_id = isset($_POST['term_id']) ? absint($_POST['term_id']) : 0;
            $url = isset($_POST['url']) ? esc_url_raw(wp_unslash($_POST['url'])) : '';
            $status = isset($_POST['status']) ? sanitize_text_field(wp_unslash($_POST['status'])) : '';
            if ($term_id && $url) {
                $wpdb->insert($table, ['term_id' => $term_id, 'url' => $url, 'status' => $status]);
                wp_redirect(add_query_arg(['page' => 'jt-term-external-links', 'jt_term_links_status' => 'added'], admin_url('admin.php')));
                exit;
            }
            $error = __('Term ID and URL are required.', 'bonestheme');
        } elseif ($action === 'update') {
            $id = isset($_POST['id']) ? absint($_POST['id']) : 0;
            $term_id = isset($_POST['term_id']) ? absint($_POST['term_id']) : 0;
            $url = isset($_POST['url']) ? esc_url_raw(wp_unslash($_POST['url'])) : '';
            $status = isset($_POST['status']) ? sanitize_text_field(wp_unslash($_POST['status'])) : '';
            if ($id && $term_id && $url) {
                $wpdb->update($table, ['term_id' => $term_id, 'url' => $url, 'status' => $status], ['id' => $id]);
                wp_redirect(add_query_arg(['page' => 'jt-term-external-links', 'jt_term_links_status' => 'updated'], admin_url('admin.php')));
                exit;
            }
            $error = __('All fields are required for updating a link.', 'bonestheme');
        } elseif ($action === 'delete') {
            $id = isset($_POST['id']) ? absint($_POST['id']) : 0;
            if ($id) {
                $wpdb->delete($table, ['id' => $id]);
                wp_redirect(add_query_arg(['page' => 'jt-term-external-links', 'jt_term_links_status' => 'deleted'], admin_url('admin.php')));
                exit;
            }
            $error = __('Unable to remove the requested link.', 'bonestheme');
        }
    }
    if (isset($_GET['jt_term_links_status'])) {
        $status_key = sanitize_text_field(wp_unslash($_GET['jt_term_links_status']));
        if ($status_key === 'added') {
            $message = __('Link added successfully.', 'bonestheme');
        } elseif ($status_key === 'updated') {
            $message = __('Link updated successfully.', 'bonestheme');
        } elseif ($status_key === 'deleted') {
            $message = __('Link removed successfully.', 'bonestheme');
        }
    }
    $rows = $wpdb->get_results("SELECT id, term_id, url, status FROM $table ORDER BY id DESC");
    $editing_id = isset($_GET['edit']) ? absint($_GET['edit']) : 0;
    $editing_row = null;
    if ($editing_id) {
        $editing_row = $wpdb->get_row($wpdb->prepare("SELECT id, term_id, url, status FROM $table WHERE id = %d", $editing_id));
    }
    echo '<div class="wrap">';
    echo '<h1>' . esc_html__('Term External Links', 'bonestheme') . '</h1>';
    if ($message) {
        echo '<div class="notice notice-success"><p>' . esc_html($message) . '</p></div>';
    }
    if ($error) {
        echo '<div class="notice notice-error"><p>' . esc_html($error) . '</p></div>';
    }
    echo '<h2>' . esc_html__('Add New Link', 'bonestheme') . '</h2>';
    echo '<form method="post">';
    wp_nonce_field('jt_term_links', 'jt_term_links_nonce');
    echo '<input type="hidden" name="term_link_action" value="insert">';
    echo '<table class="form-table"><tbody>';
    echo '<tr><th scope="row"><label for="term-link-new-term">' . esc_html__('Term ID', 'bonestheme') . '</label></th><td><input type="number" name="term_id" id="term-link-new-term" value="" min="1" required></td></tr>';
    echo '<tr><th scope="row"><label for="term-link-new-url">' . esc_html__('URL', 'bonestheme') . '</label></th><td><input type="url" name="url" id="term-link-new-url" class="regular-text" required></td></tr>';
    echo '<tr><th scope="row"><label for="term-link-new-status">' . esc_html__('Status', 'bonestheme') . '</label></th><td><input type="text" name="status" id="term-link-new-status" class="regular-text"></td></tr>';
    echo '</tbody></table>';
    submit_button(__('Save Link', 'bonestheme'));
    echo '</form>';
    if ($editing_row) {
        echo '<h2>' . esc_html__('Edit Link', 'bonestheme') . '</h2>';
        echo '<form method="post">';
        wp_nonce_field('jt_term_links', 'jt_term_links_nonce');
        echo '<input type="hidden" name="term_link_action" value="update">';
        echo '<input type="hidden" name="id" value="' . intval($editing_row->id) . '">';
        echo '<table class="form-table"><tbody>';
        echo '<tr><th scope="row"><label for="term-link-edit-term">' . esc_html__('Term ID', 'bonestheme') . '</label></th><td><input type="number" name="term_id" id="term-link-edit-term" value="' . intval($editing_row->term_id) . '" min="1" required></td></tr>';
        echo '<tr><th scope="row"><label for="term-link-edit-url">' . esc_html__('URL', 'bonestheme') . '</label></th><td><input type="url" name="url" id="term-link-edit-url" class="regular-text" value="' . esc_attr($editing_row->url) . '" required></td></tr>';
        echo '<tr><th scope="row"><label for="term-link-edit-status">' . esc_html__('Status', 'bonestheme') . '</label></th><td><input type="text" name="status" id="term-link-edit-status" class="regular-text" value="' . esc_attr($editing_row->status) . '"></td></tr>';
        echo '</tbody></table>';
        submit_button(__('Update Link', 'bonestheme'));
        echo '</form>';
    }
    echo '<h2>' . esc_html__('Existing Links', 'bonestheme') . '</h2>';
    echo '<table class="widefat fixed striped"><thead><tr>';
    echo '<th>' . esc_html__('ID', 'bonestheme') . '</th>';
    echo '<th>' . esc_html__('Term', 'bonestheme') . '</th>';
    echo '<th>' . esc_html__('URL', 'bonestheme') . '</th>';
    echo '<th>' . esc_html__('Status', 'bonestheme') . '</th>';
    echo '<th>' . esc_html__('Actions', 'bonestheme') . '</th>';
    echo '</tr></thead><tbody>';
    if ($rows) {
        foreach ($rows as $row) {
            $term_label = '';
            if ($row->term_id) {
                $term = get_term($row->term_id);
                if ($term && !is_wp_error($term)) {
                    $term_label = $term->name;
                }
            }
            echo '<tr>';
            echo '<td>' . intval($row->id) . '</td>';
            if ($term_label) {
                echo '<td>' . esc_html($term_label) . ' (ID ' . intval($row->term_id) . ')</td>';
            } else {
                echo '<td>' . intval($row->term_id) . '</td>';
            }
            if ($row->url) {
                echo '<td><a href="' . esc_url($row->url) . '" target="_blank" rel="noopener noreferrer">' . esc_html($row->url) . '</a></td>';
            } else {
                echo '<td></td>';
            }
            echo '<td>' . esc_html($row->status) . '</td>';
            echo '<td>';
            $edit_url = add_query_arg(['page' => 'jt-term-external-links', 'edit' => $row->id], admin_url('admin.php'));
            echo '<a class="button" href="' . esc_url($edit_url) . '">' . esc_html__('Edit', 'bonestheme') . '</a> ';
            echo '<form method="post" style="display:inline;">';
            wp_nonce_field('jt_term_links', 'jt_term_links_nonce');
            echo '<input type="hidden" name="term_link_action" value="delete">';
            echo '<input type="hidden" name="id" value="' . intval($row->id) . '">';
            submit_button(__('Delete', 'bonestheme'), 'delete', '', false);
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="5">' . esc_html__('No external links found.', 'bonestheme') . '</td></tr>';
    }
    echo '</tbody></table>';
    echo '</div>';
}
