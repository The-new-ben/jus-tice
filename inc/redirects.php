<?php
function jt_redirect_install(){
    global $wpdb;
    $table=$wpdb->prefix.'redirect_log';
    $charset=$wpdb->get_charset_collate();
    $sql="CREATE TABLE IF NOT EXISTS $table (id bigint unsigned auto_increment primary key, request_uri text not null, suggested bigint unsigned default null, target bigint unsigned default null, created datetime not null) $charset";
    require_once ABSPATH.'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}
add_action('after_switch_theme','jt_redirect_install');
function jt_redirect_suggestion($req){
    $slug=sanitize_title(basename($req));
    $q=new WP_Query(['name'=>$slug,'post_type'=>'any','post_status'=>'publish','posts_per_page'=>1]);
    if($q->have_posts()) return $q->posts[0]->ID;
    $q=new WP_Query(['s'=>$slug,'post_type'=>'any','post_status'=>'publish','posts_per_page'=>1]);
    if($q->have_posts()) return $q->posts[0]->ID;
    return null;
}
function jt_redirect_target($req){
    global $wpdb;
    $table=$wpdb->prefix.'redirect_log';
    return $wpdb->get_var($wpdb->prepare("select target from $table where request_uri=%s order by id desc limit 1",$req));
}
function jt_log_404(){
    if(!is_404()) return;
    $req=esc_url_raw($_SERVER['REQUEST_URI']);
    if($target=jt_redirect_target($req)){
        wp_redirect(get_permalink($target),301);
        exit;
    }
    global $wpdb;
    $suggested=jt_redirect_suggestion($req);
    $table=$wpdb->prefix.'redirect_log';
    $wpdb->insert($table,['request_uri'=>$req,'suggested'=>$suggested,'created'=>current_time('mysql')]);
}
add_action('template_redirect','jt_log_404');
function jt_redirect_admin(){
    add_menu_page('Redirects','Redirects','manage_options','jt-redirects','jt_redirect_admin_page');
}
add_action('admin_menu','jt_redirect_admin');
function jt_redirect_admin_page(){
    global $wpdb;
    $table=$wpdb->prefix.'redirect_log';
    if(isset($_POST['jt_redirect_nonce'])&&wp_verify_nonce($_POST['jt_redirect_nonce'],'jt_redirect')){
        $id=intval($_POST['id']);
        $target=intval($_POST['target']);
        $wpdb->update($table,['target'=>$target],['id'=>$id]);
    }
    $rows=$wpdb->get_results("select id,request_uri,suggested,target,created from $table order by created desc limit 50");
    echo '<div class="wrap"><h1>Redirects</h1><table class="widefat"><thead><tr><th>Request</th><th>Suggested</th><th>Target</th><th>Action</th></tr></thead><tbody>';
    foreach($rows as $row){
        $suggested=$row->suggested?get_permalink($row->suggested):'';
        $target=$row->target?get_permalink($row->target):'';
        echo '<tr><td>'.esc_html($row->request_uri).'</td><td>'.($suggested?'<a href="'.$suggested.'">'.$suggested.'</a>':'').'</td><td>'.($target?'<a href="'.$target.'">'.$target.'</a>':'').'</td><td>';
        echo '<form method="post"><input type="hidden" name="id" value="'.$row->id.'">';
        wp_nonce_field('jt_redirect','jt_redirect_nonce');
        echo '<input type="number" name="target" value="'.intval($row->suggested).'"><input type="submit" value="Save"></form>';
        echo '</td></tr>';
    }
    echo '</tbody></table></div>';
}
