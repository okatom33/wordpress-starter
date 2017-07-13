<?php get_header(); ?>

<?php
$args = array(
    'numberposts' => 10,
    'post_type' => 'product',
    'order' => 'ASC'
);
$posts = get_posts( $args );
var_dump($posts);
?>
<?php if ($posts): foreach($posts as $post): ?>

<?php endforeach ?>
<?php else: ?>
    投稿が見つかりません
<?php endif ?>



<?php get_footer(); ?>
