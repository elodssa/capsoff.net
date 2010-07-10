<?php slot('sidebar') ?>
	<?php include_partial('main/sidebar',array('sidebar' => $sidebar)); ?>
<?php end_slot(); ?>

<?php
	slot('title','capsoff.net - Посты в рубрике "' . $category['name'] . '"');
	slot('new_post_category',"?category=" . $category['name']);

	include_partial('post/post_list',$post_list);
?>