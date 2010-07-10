<?php slot('sidebar') ?>
	<?php include_partial('main/sidebar',array('sidebar' => $sidebar)); ?>
<?php end_slot(); ?>

<?php
	slot('title','capsoff.net - Поиск в коммент');
	use_stylesheet('comment_list.css');
	use_stylesheet('search.css');

	if($found_something)
		{
        	include_partial('search/comment_search_block',array());
			include_partial('comment/comment_list',$results);
    	}
    else
        {
        	include_partial('search/comment_search_block',array());
    		echo $message;
    	}
?>
