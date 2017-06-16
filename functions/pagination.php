<?php

function the_pagination() {

  // ページ数をすべて表示するか
  $show_all = false;

  // 現在のページの左右に表示するページ数
  $mid_size = 2;
  $end_size = 1;

  the_posts_pagination(array(
    'prev_text' => '',
    'next_text' => '',
    'show_all' => $show_all,
    'end_size' => $end_size,
    'mid_size' => $mid_size,
  ));
}

?>
