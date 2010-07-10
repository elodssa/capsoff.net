<div class="sorts_and_pager">
	<?php
    	if (!isset($search_params)) { $search_params = ''; }

		include_partial('post/sort',array('uri' => $uri,
										  'sorts_for_links' => $sorts_for_links,
										  'sort_by' => $sort_by,
										  'sort_type' => $sort_type,
										  'search_params' => $search_params
										 ));
		include_partial('post/pager', array('uri' => $uri,
											'pager' => $pager,
											'sort_by' => $sort_by,
											'sort_type' => $sort_type,
											'search_params' => $search_params));
	?>
</div>

<?php foreach ($comment_list as $comment): ?>
	<div class="comment_preview">

		<!-- Текст коммента -->
		<div class="comment_text"><?php echo html_entity_decode(str_replace("\n",'<p>',$comment['text'])) ?></div>

		<table cellspacing="3" cellpadding="3">
			<tr class="panel" align="center" valign="bottom">
				<td class="date">
					<img width="15" height="15" border="1" align="middle" alt='---'  title="Дата публикации">
					<?php echo $comment['created_at'] ?>
				</td>
				<td class="autor">
                    <img width="15" height="15" border="1" align="middle" alt='---' title="Автор">
					<?php
						echo link_to($comment['Profile']['fullname'],'user_show',$comment['Profile'])
					?>
				</td>
				<td>
					<?php $comment_url = url_for('post_show',array('id' => $comment['post_id'])) . '#' . $comment['id'] ?>
					<a href="<?php echo $comment_url ?>">Посмотреть в посте</a>
				</td>
			<tr>
		</table>
	</div>
<?php endforeach ?>

<?php
		include_partial('post/pager', array('uri' => $uri,
											'pager' => $pager,
											'sort_by' => $sort_by,
											'sort_type' => $sort_type,
											'search_params' => $search_params));

?>
