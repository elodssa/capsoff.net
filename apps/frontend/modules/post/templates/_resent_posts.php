<?php
	use_stylesheet('resent_posts.css');
	use_helper('Tag');
?>

<div class="resent_posts_block">
<center class="block_head">Последние посты</center>
	<ul>
		<?php foreach($resent_posts as $post): ?>
			<li>
				<?php echo link_to($post['title'],'post_show',array('id' => $post['id'])); ?>
			</li>
		<?php endforeach?>
	</ul>
</div>
