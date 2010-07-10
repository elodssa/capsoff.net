<?php slot('sidebar') ?>
	<?php include_partial('main/sidebar',array('sidebar' => $sidebar)); ?>
<?php end_slot(); ?>

<?php
    slot('title','capsoff.net - Поиск');
	slot('search','shown');
	use_stylesheet('search.css');
	use_stylesheet('search.css');

	include_partial('search/post_search_block');

	include_partial('search/comment_search_block');

	//include_partial('search/user_search_block');
?>