<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <title><?php wp_title(' : ', 1, 'right'); ?> <?php bloginfo('name'); ?></title>
  <meta name="description" content="" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta http-equiv="content-language" content="ja" />
  <meta http-equiv="content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="content-style-type" content="text/css" />
  <meta http-equiv="content-script-type" content="text/javascript" />
  <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1" />

  <?php
  $default_og_title = 'デフォルトのog:title';
  $default_og_description = 'デフォルトのog:description';
  ?>
  <?php if(is_front_page()):?>
  <meta property="og:title" content="<?php echo $default_og_title ?>">
  <meta property="og:description" content="<?php echo $default_og_description ?>">
  <meta property="og:url" content="<?php echo home_url('/'); ?>">
  <meta property="og:image" content="<?php echo home_url('/'); ?>img/ogp.png">
  <?php else:?>
  <meta property="og:title" content="<?php if(get_field('og-title')):?><?php the_field('og-title'); ?>：小さな声を届けるウェブマガジン「BAMP」<?php else:?>小さな声を届けるウェブマガジン「BAMP」<?php endif;?>">
  <meta property="og:description" content="<?php if(get_field('og-description')):?><?php the_field('og-description'); ?><?php else:?><?php echo $default_og_description ?><?php endif;?>">
  <meta property="og:url" content="<?php $radio = get_field('og-select'); if('1'== $radio):?><?php the_permalink(); ?><?php elseif('2'== $radio):?><?php echo home_url('/'); ?><?php else:?><?php echo home_url('/'); ?><?php endif; ?>">
  <meta property="og:image" content="<?php if(get_field('og-image')):?><?php $img = get_field('og-image'); $imgurl = wp_get_attachment_image_src($img, 'og-image'); if($imgurl){ ?><? echo $imgurl[0]; ?><? } ?><?php else:?><?php echo home_url('/'); ?>img/ogp.png<?php endif;?>">
  <?php endif;?>
  <meta property="og:site_name" content="<?php bloginfo('name'); ?>">
  <meta property="og:type" content="website">
  <meta property="og:locale" content="ja_JP">

  <meta property="fb:app_id" content="" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:site" content="@hoge" />
  <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon" />
  <meta name="format-detection" content="telephone=no">
  <link rel="stylesheet" type="text/css" href="/css/common.css" />
  <?php wp_head() ?>
  <!-- この下にGoogleAnalyticsのコードを挿入してください -->
</head>
<body>
<div class="wrapper">
