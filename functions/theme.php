<?php

//====================================
//サムネイル用の画像サイズを定義
// add_image_size('thumb100', 100, 100, true);

//====================================
//画像を自動で圧縮しないようにする
add_filter('jpeg_quality', function($arg){ return 100; });

?>