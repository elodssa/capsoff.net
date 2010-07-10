<?php
	use_helper('Tag');
	use_helper('Text');
?>

<div class="sorts_and_pager">
	<?php
    	if (!isset($search_params)) { $search_params = ''; }

		include_partial('post/pager', array('uri' => $uri,
											'pager' => $pager,
											'sort_by' => $sort_by,
											'sort_type' => $sort_type,
											'search_params' => $search_params));

		include_partial('post/sort',array('uri' => $uri,
										  'sorts_for_links' => $sorts_for_links,
										  'sort_by' => $sort_by,
										  'sort_type' => $sort_type,
										  'search_params' => $search_params
										 ));

	?>
</div>

<?php foreach ($post_list as $post): ?>
	<div class="post_preview">

		<!-- Ссылка на рубрику (если нужна) -->
		<div class="post_header">
			<?php if($category_show): ?>
				<?php  echo $post['Category']['name'] ?>
			<?php else: ?>
				<?php  echo link_to($post['Category']['name'], 'category_show', array('id' => $post['Category']['id']))  ?>
			<?php endif; ?>
            →
			<!-- Ссылка на пост -->
			<?php echo link_to($post['title'],'post_show',array('id' => $post['id'])) ?>
		</div>


		<!-- Текст поста -->
		<div class="post_text">
			<?php
				echo ;
			?>
		</div>

		<!-- Теги поста	 -->
		<?php if (count($post['Tags']) != 0): ?>
			<div class="post_tags">Тэги:
				<?php
					foreach ($post['Tags'] as $tag)
						{ echo link_to($tag['name'], 'tag_show', array('id' => $tag['id'])).'&nbsp;&nbsp;'; }
				?>
			</div>
		<?php endif; ?>

		<table cellspacing="3" cellpadding="3">
			<tr class="panel" align="center" valign="bottom">
				<td class="rating_block">
					<?php
						if ($user_id != NULL)
							echo content_tag('a','+',array(
													       'href' => url_for('post_vote_plus',array('id' => $post['id'])),
													       'class' => 'plus',
													       'title' => 'Хороший пост!'
													       ));

						else
							echo content_tag('a','+',array(
												  			'href' => url_for('sf_guard_signin'),
												  			'class' => 'plus',
											   	  			'title' => 'Вы бы могли поставить плюс, если бы авторизовались!'
												 		   ));

                        echo content_tag('span',sprintf(' %s ',$post['votes']),array('class' => 'rating'));

						if ($user_id != NULL)
							echo content_tag('a','-',array(
													       'href' => url_for('post_vote_minus',array('id' => $post['id'])),
													       'class' => 'plus',
													       'title' => 'Хороший пост!'
													       ));

						else
							echo content_tag('a','-',array(
												  			'href' => url_for('sf_guard_signin'),
												  			'class' => 'plus',
											   	  			'title' => 'Вы бы могли поставить минус, если бы авторизовались!'
												 		   ));
   					?>
				</td>

				<td class="date">
					<img width="15" height="15" border="1" align="middle" alt='---'  title="Дата публикации">
					<?php //echo $post->getDateTimeObject('created_at')->format('d.m.Y')                     ?>
				</td>
				<td>
					<?php //echo $post->getDateTimeObject('created_at')->format('h:i') ?>
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
		<?php if($sf_user->isAuthenticated()): ?>
			<div style="text-align:right"><?php echo link_to('Комментировать','answer_new',array('post_id' => $post['id'])) ?></div>
		<?php endif; ?>
	</div>
<?php endforeach ?>

<?php
		include_partial('post/pager', array('uri' => $uri,
											'pager' => $pager,
											'sort_by' => $sort_by,
											'sort_type' => $sort_type,
											'search_params' => $search_params));
?>
