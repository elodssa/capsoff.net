<?php
	use_stylesheet('answer_form.css');
	use_stylesheet('posts.css');
	use_stylesheet('search.css');

	slot('title','capsoff.net - Комментирование поста');
?>


<div class="post_preview">
	<!-- Ссылка на рубрику (если нужна) -->
	<div class="post_header">

		<?php  echo link_to($post['Category']['name'], 'category_show', $post['Category'])  ?>
		→
		<!-- Ссылка на пост -->
		<?php echo link_to($post['title'],'post_show',array('id' => $post['id'])) ?>

		→ комментирование
	</div>

	<!-- Текст поста -->
	<div class="post_text">
		<?php echo htmlspecialchars_decode($post['text']); ?>
	</div>

	<!-- Теги поста	 -->
	<?php if (count($post['Tags']) != 0): ?>
		<div class="post_tags">Тэги:
			<?php
				foreach ($post['Tags'] as $tag)
					{ echo link_to($tag['name'], 'tag_show', $tag).'&nbsp;&nbsp;'; }
			?>
		</div>
	<?php endif; ?>

		<table cellspacing="3" cellpadding="3">
			<tr class="panel" align="center" valign="bottom">
				<td class="date">
					<img width="15" height="15" border="1" align="middle" alt='---'  title="Дата публикации">
					<?php echo $post->getDateTimeObject('created_at')->format('d.m.Y')                     ?>
				</td>
				<td>
					<?php echo $post->getDateTimeObject('created_at')->format('h:i') ?>
				</td>
				<td class="views">
					<img width="15" height="15" border="1" align="middle" alt='---'  title="Просмотров"> <?php echo $post['views'] ?>
				</td>
				<td class="comments">
					<img width="15" height="15" border="1" align="middle" alt='---'  title="Комментов"> <?php echo $post['comments']; ?>
				</td>
				<td class="autor">
                    <img width="15" height="15" border="1" align="middle" alt='---' title="Автор">
					<?php
						echo link_to($post['Profile']['fullname'],'user_show',array('id' => $post['Profile']['id']))
					?>
				</td>
			<tr>
		</table>
</div>

<?php include_partial('answer/form',array('form' => $form, 'post_id' => $post['id'])); ?>

</div>