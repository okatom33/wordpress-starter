<?php

//========================================
// 画像オブジェクトからサイズを返す
function get_image_sizes($image, $size = '') {
  if ( empty($size) ) {
    $image_width = $image["width"];
    $image_height = $image["height"];
  }
  else {
    $sizes = $image['sizes'];
    $image_width = $sizes[$size."-width"];
    $image_height = $sizes[$size."-height"];
  }
  return array('width' => $image_width, 'height' => $image_height);
}


//========================================
// 画像オブジェクトからURLを返す
function get_image_url($image, $size = '') {
  if (empty($size)) {
    $url = $image['url'];
  }
  else {
    $sizes = $image['sizes'];
    $url = $sizes[$size];
  }
  return $url;
}

//========================================
// ヨコのサイズに対する縦の比率を返す
function get_image_ratio($image, $size = '') {
  if (empty($size)) {
    $image_width = $image["width"];
    $image_height = $image["height"];
  }
  else {
    $sizes = $image['sizes'];
    $image_width = $sizes[$size."-width"];
    $image_height = $sizes[$size."-height"];
  }
  return $image_height / $image_width * 100;
}

/**
 * 現在のページが指定したページID、タイトル、スラッグ、パスを持つページの子ページがどうか調べる
 * : http://wpcj.net/1862
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

?>
