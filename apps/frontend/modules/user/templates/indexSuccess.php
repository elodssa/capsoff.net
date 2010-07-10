<?php slot('sidebar') ?>
	<?php include_partial('main/sidebar',array('sidebar' => $sidebar)); ?>
<?php end_slot(); ?>

<?php
	slot('title','capsoff.net - Список пользователей');
 	slot('users','shown');
	use_stylesheet('search.css');

	include_partial('user/user_list',$user_list);
?>