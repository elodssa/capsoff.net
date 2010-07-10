<?php
	use_helper('Tag');
	use_helper('Text');
?>

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
		<?php echo  content_tag('div',simple_format_text($comment['text']),array('class' => "comment_text")); ?>

		<table cellspacing="3" cellpadding="3">
			<tr class="panel" align="center" valign="bottom">
				<td class="date">
					<img width="15" height="15" border="1" align="middle" alt='---'  title="Дата публикации">
					<?php echo $comment->getDateTimeObject('created_at')->format('d.m.Y')                     ?>
				</td>
				<td>
					<?php echo $comment->getDateTimeObject('created_at')->format('h:i') ?>
				</td>
				<td>
					Тип:
						<?php
							if(is_null($comment['comment_id']))
                            	echo 'коммент к посту';
                            else
                            	echo 'коммент к комменту';
						?>
				</td>
				<td class="autor">
                    <img width="15" height="15" border="1" align="middle" alt='---' title="Автор">
					<?php
						echo link_to($comment['Profile']['fullname']  == NULL ? $comment['Profile']['email'] : $comment['Profile']['fullname'],
										'user_show',$comment['Profile'])
					?>
				</td>
				<?php if(!is_null($comment['comments'])): ?>
					<td>
						<img width="15" height="15" border="1" align="middle" alt='---'  title="Комментов">
						<?php echo $comment['comments']; ?>
					</td>
				<?php endif; ?>

			<tr>
		</table>
		<div style="text-align:right">
			<?php
				$comment_url = sprintf('%s#%s',url_for('post_show',array('id' => $comment['post_id'])),$comment);
				echo content_tag('a','Посмотреть в посте', array('href' => $comment_url));
			?>
		</div>
	</div>
<?php endforeach ?>

<?php
		include_partial('post/pager', array('uri' => $uri,
											'pager' => $pager,
											'sort_by' => $sort_by,
											'sort_type' => $sort_type,
											'search_params' => $search_params));

?>
