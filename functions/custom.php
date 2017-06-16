<?php


/**
 * 現在のページが指定したページID、タイトル、スラッグ、パスを持つページの子ページがどうか調べます。
 * (孫ページ対応。WordPress 3.1～のWP_Query::is_page()のコードをベースにしています)
 * 参考: http://wpcj.net/1862
 *
 * @param int|string|array $page 上位ページのページID、タイトル、スラッグ、パス、またはそれらの配列 (デフォルトは空)
 * @return bool 指定された引数のデータを持つページの子ページであればtrue 
 *              (引数が指定されていない場合は単に子ページであればtrue)
*/
function is_subpage( $page = '' ) {
  // 固定ページ表示中でない場合はfalse
  if ( ! is_page() ) {
    return false;
  }

  // 固定ページデータを取得
  $page_obj = get_queried_object();

  // 親ページのIDなどが指定されておらず、かつページデータに親ページIDがある場合はtrue
  if ( empty($page) && 0 != $page_obj->post_parent ) {
    return true;
  }

  // ページID、タイトル、スラッグ、パスの指定データを文字列の配列になるよう強制
  $page = array_map( 'strval', (array) $page );

  // 親ページがある間繰り返し
  while ( 0 != $page_obj->post_parent ) {

    // 親ページデータを取得
    $page_obj = get_post( $page_obj->post_parent );

    // 指定されたデータの中に親ページのIDがある場合true
    if ( in_array( (string) $page_obj->ID, $page ) ) {
      return true;
    }
    // 指定されたデータの中に親ページのタイトルがある場合true
    elseif ( in_array( $page_obj->post_title, $page ) ) {
      return true;
    }
    // 指定されたデータの中に親ページのスラッグがある場合true
    elseif ( in_array( $page_obj->post_name, $page ) ) {
      return true;
    } else {
      // 指定されたデータの中に親ページのパスがある場合true
      foreach ( $page as $pagepath ) {
        if ( ! strpos( $pagepath, '/' ) ) {
          continue;
        }
        $pagepath_obj = get_page_by_path( $pagepath );
        if ( $pagepath_obj && ( $pagepath_obj->ID == $page_obj->ID ) ) {
        return true;
        }
      }
    }
  }
  return false;
}

function umadash_remove_p_from_img($value) {
  return preg_replace('/<p>(\s*)(<img .* \/>)(\s*)<\/p>/iU', '\2', $value);
}

function kj_the_content() {
  echo umadash_remove_p_from_img(get_field('content'));
}

function kj_is_introduction() {
  return (is_page('introduction') || is_page('welfare'));
}

function kj_is_department() {
  $slug = 'department';
  return (is_page($slug) || is_subpage($slug));
}

function kj_is_members() {
  return (is_page('member') || is_singular('member'));
}

function kj_is_works() {
  $slug = 'works';
  return (is_page($slug) || is_singular($slug) || is_subpage($slug));
}

function kj_is_job() {
  $slug = 'job';
  return (is_page($slug) || is_subpage($slug));
}

function kj_is_special() {
  $slug = 'special';
  return (is_page($slug) || is_singular($slug));
}

function umadash_get_custom_tax_slug($post_id, $taxonomy_slug) {
  $terms = get_the_terms($post_id, $taxonomy_slug);
  $count = count($terms);
  if ( $count > 0 ) {
    $term = $terms[0];
    return $term -> name;
  }
  else {
    return '';
  }
}

function uma_get_recruit_url($type, $anchor_id) {
  $str = 'job/';
  if ($type == 0) { // 建築
    $str .= 'construction';
  }
  else if ($type == 1) { //インテリア
    $str .= 'interior';
  }
  else {
    $str .= 'soil';
  }

  $url = home_url($str).'#'.$anchor_id;
  return $url;
}

function get_first_post($post_type, $taxonomy, $terms) {
  $args = array(
    'numberposts' => 1,
    'orderby' => 'date',
    'order' => 'DESC',
    'post_type' => $post_type,
    'tax_query' => array(
      array(
        'taxonomy' => $taxonomy,
        'field' => 'slug',
        'terms' => $terms
      )
    )
  );
  $posts = get_posts($args);
  $num_posts = count($posts);
  if ($num_posts > 0) {
    return $posts[0];
  }
  return;
}

function get_latest_url($post_type) {
}

?>
