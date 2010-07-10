<?php slot('sidebar') ?>
	<?php include_partial('main/sidebar',array('sidebar' => $sidebar)); ?>
<?php end_slot(); ?>

<?php
	slot('title','capsoff.net - Поиск юзера по имени');
	use_stylesheet('posts.css');
	use_stylesheet('search.css');

	if($found_something)
		{
    		include_partial('search/user_search_block',array());
    		include_partial('user/user_list',$results);
    	}
    else
        {
        	include_partial('search/user_search_block',array());
    		echo $message;
    	}
?>


