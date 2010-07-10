<?php slot('sidebar') ?>
	<?php include_partial('main/sidebar',array('sidebar' => $sidebar)); ?>
<?php end_slot(); ?>

<?php
	slot('title','capsoff.net - Список комментов пользователя "' . $username . '""');
	use_stylesheet('search.css');
	use_stylesheet('comment_list.css');

	include_partial('comment/comment_list',$comment_list);
?>