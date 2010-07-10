<?php slot('sidebar') ?>
	<?php include_partial('main/sidebar',array('sidebar' => $sidebar)); ?>
<?php end_slot(); ?>

<?php
	slot('title','capsoff.net - Поиск в постах');
	use_stylesheet('posts.css');
	use_stylesheet('search.css');

	if($found_something)
		{
    		include_partial('search/post_search_block',array());
    		include_partial('post/post_list',$results);
    	}
    else
        {
        	include_partial('search/post_search_block',array());
    		echo $message;
    	}
?>


