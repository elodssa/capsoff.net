<?php slot('sidebar') ?>
	<?php include_partial('main/sidebar',array('sidebar' => $sidebar)) ?>
<?php end_slot(); ?>

<?php
	slot('title','capsoff.net - Список постов пользователя "'. $username . '"');
	use_stylesheet('search.css');
	use_stylesheet('posts.css');

	include_partial('post/post_list',$post_list);
?>