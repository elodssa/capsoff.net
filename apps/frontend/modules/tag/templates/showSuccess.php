<?php slot('sidebar') ?>
	<?php include_partial('main/sidebar',array('sidebar' => $sidebar)); ?>
<?php end_slot(); ?>

<?php
	slot('title','capsoff.net - Просмотр постов тега "' . $tag['name'] . '"');
	use_stylesheet('posts.css');
	use_stylesheet('search.css');

	include_partial('post/post_list',$post_list);
?>