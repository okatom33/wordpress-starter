<?php

//======================================
// 管理画面メニューの不要項目を削除
function remove_menus() {
    //remove_menu_page('edit.php'); // 投稿
    //remove_menu_page('edit-comments.php'); // コメント
    remove_menu_page('tools.php'); // ツール
    //remove_menu_page('profile.php'); // プロファイル
    //remove_menu_page( 'index.php' ); // ダッシュボード
    remove_menu_page( 'upload.php' ); // メディア
    remove_menu_page( 'edit.php?post_type=page' ); // 固定ページ
    remove_menu_page( 'edit-comments.php' ); // コメント
    remove_menu_page( 'themes.php' ); // 外観
    remove_menu_page( 'plugins.php' ); // プラグイン
    //remove_menu_page( 'users.php' ); // ユーザー
    remove_menu_page( 'options-general.php' ); // 設定
}
add_action('admin_menu', 'remove_menus');

//======================================
// 絵文字を削除
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

//=======================================
// head項目削除
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_shortlink_wp_head');

//=======================================
// wp_head()で吐き出されるタグを整理する
remove_action('wp_head','wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

//======================================
// helpの削除
function remove_help_tabs() {
  $screen = get_current_screen();
  $screen -> remove_help_tabs();
}
add_action( 'admin_head', 'remove_help_tabs' );

//======================================
// 管理者以外だったら、更新情報を非表示にする
if (!current_user_can('administrator')) {
  add_filter('pre_site_transient_update_core', '__return_zero');
}

?>
