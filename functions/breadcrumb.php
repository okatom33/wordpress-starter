<?php

/** 
 * パンくずリストを表示する 
 * 注意: この関数は未完成
 */
function umadash_the_breadcrumb($current_page_title = '') {
  global $post;
  $HOME = 'HOME';


  $html = '';
  if ( !is_home() && !is_admin() ) {
    $post_id = $post -> ID;
    $html .= '<div id="js-breadcrumb" class="breadcrumb"><div class="breadcrumb_inner">';
    $title = (empty($current_page_title)) ? get_the_title($post_id) : $current_page_title;

    // HOME
    $home_url = home_url();
    $html .= umadash_createBreadcrumbItem($HOME, $home_url);

    /**
     * シングル(投稿)ページ
     */
    if ( is_single() )
    {
      $TAX_NAME_INTERIOR = 'インテリア事業部';
      $TAX_NAME_SOIL = '土木事業部';
      $TAX_NAME_CONSTRUCTION = '建築事業部';

      if ( is_singular() ) // カスタム投稿タイプ
      {
        if (is_singular('special'))
        {
          $html .= umadash_createBreadcrumbItem('特殊採用', home_url('special'));
        }
        else if (is_singular('welfare'))
        {
          $html .= umadash_createBreadcrumbItem('福利厚生', home_url('welfare'));
        }
        else
        {
          $post_type = get_post_type($post_id);
          $post_type_object = get_post_type_object($post_type);
          $label = $post_type_object -> label;

          if (is_singular('member'))
          {
            $html .= umadash_createBreadcrumbItem($label, home_url('member'));
            $terms = get_the_terms($post_id, 'department');
            $term = $terms[0];
            $term_name = $term -> name;

            if ($term_name == $TAX_NAME_INTERIOR)
            {
              $html .= umadash_createBreadcrumbItem($term_name);
            }
            else if ($term_name == $TAX_NAME_SOIL)
            {
              $html .= umadash_createBreadcrumbItem($term_name);
            }
            else
            {
              $html .= umadash_createBreadcrumbItem($term_name);
            }
          }
          else if (is_singular('works'))
          {
            $html .= umadash_createBreadcrumbItem($label, home_url('works'));
            $terms = get_the_terms($post_id, 'department');
            $term = $terms[0];
            $term_name = $term -> name;

            if ($term_name == $TAX_NAME_INTERIOR)
            {
              $html .= umadash_createBreadcrumbItem($term_name, home_url('works/interior'));
            }
            else if ($term_name == $TAX_NAME_SOIL)
            {
              $html .= umadash_createBreadcrumbItem($term_name, home_url('works/soil'));
            }
            else
            {
              $html .= umadash_createBreadcrumbItem($term_name, home_url('works/construction'));
            }
          }
          else if (is_singular('job'))
          {
            $html .= umadash_createBreadcrumbItem($label, home_url('job'));
            $html .= umadash_create_custom_tax_item($post_id, 'department');
          }
          else
          {
            $html .= umadash_createBreadcrumbItem($label);
            $html .= umadash_create_custom_tax_item($post_id, 'department');
          }
        }
      }
      else
      {
        $categories = get_the_category( $post_id );
        $cat = $categories[0];
        if ($cat -> parent != 0) {
          $ancestors = array_reverse(get_post_ancestors( $cat -> cat_ID, 'category' ));
          foreach($ancestors as $ancestor) {
            $url = get_category_link($ancestor);
            $cat_name = get_cat_name($ancestor);
            $title = get_the_title($ancestor);
            $html .= umadash_createBreadcrumbItem($cat_name, $url);
          }
        }
      }
      $html .= umadash_createBreadcrumbItem($title);
    }
    /**
     * 固定ページ
     */
    else if ( is_page() )
    {
      if ( $post -> post_parent != 0 ) { // 子
        $ancestors = array_reverse(get_post_ancestors( $post_id ));

        foreach($ancestors as $ancestor) {
          $html .= umadash_createBreadcrumbItem(get_the_title($ancestor), get_permalink($ancestor));
        }
      }
      $html .= umadash_createBreadcrumbItem($title);
    }
    /**
     * カテゴリアーカイブ
     */
    else if ( is_category() ) 
    {
      // カテゴリオブジェクトを取得
      $cat = get_queried_object();

      if ($category -> parent != 0) { // 子
        $ancestors = array_reverse(get_post_ancestors( $cat -> cat_ID, 'category' ));
        foreach($ancestors as $ancestor) {
          $url = get_category_link($ancestor);
          $cat_name = get_cat_name($ancestor);
          $html .= umadash_createBreadcrumbItem($cat_name, $url);
        }
      }
      else {
        $cat_name = get_cat_name($cat -> cat_ID);
        $html .= umadash_createBreadcrumbItem($cat_name);
      }
    }
    else if ( is_archive() ) 
    {
      $post_type = get_post_type($post_id);
      $post_type_object = get_post_type_object($post_type);
      $label = $post_type_object -> label;
      $html .= umadash_createBreadcrumbItem($label);
    }
    else {
    }

    // 閉じタグ
    $html .= '</div></div>';
    echo $html;
  }
}

function umadash_create_custom_tax_item($post_id, $custom_tax_slug) {
  $html = '';
  $terms = get_the_terms($post_id, $custom_tax_slug);
  $term = $terms[0];
  if ( $term -> parent != 0 )
  {
    $ancestors = array_reverse(get_post_ancestors( $term -> term_id )); 
    // TODO: 未完成です
  }
  else 
  {
    $html .= umadash_createBreadcrumbItem($term -> name);
  }
  return $html;
}

function umadash_createBreadcrumbItem($title, $url = '') {
  $html = '';
  if (empty($url)) 
  {
    $html .= '<div class="breadcrumbItem">';
    $html .= '<span class="breadcrumbItem_label">';
    $html .= $title;
    $html .= '</span></div>';
  }
  else
  {
    $html .= '<div class="breadcrumbItem"><a href="'.$url.'" />';
    $html .= '<span class="breadcrumbItem_label">';
    $html .= $title;
    $html .= '</span></a></div>';
  }
  return $html;
}

?>
