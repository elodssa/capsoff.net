<?php use_stylesheet('tag_cloud.css') ?>

<div class="tag_cloud">
<center class="block_head">Облако тегов</center>
		<?php
			if (count($tag_list) != 0)
			{
				foreach($tag_list as $tag)
					{
						$tag_show_link = link_to($tag['name'],'tag_show',array('id' => $tag['id']),array('title' => $tag['views'] . ' просмотров'));

						echo content_tag('span',$tag_show_link.' ',array('class' => sprintf('t%s',$tag['views'])));
					}
			}
		?>
	<br>
	<?php echo link_to('остальные теги','tags',array(), array('id' => 'more')) ?>
</div>
