<?php

class cnCommentTree
	{
    	static public function print_tree($comment_tree = null, $post_id = null, $sf_user = null)
    		{
				foreach($comment_tree as $comment): ?>
					<li><!-- Начало комента к посту -->
						<table class="comment_container">
							<tr>
								<!-- Аватар юзера -->
								<td><img border="1" src='<?php echo $comment['Profile']['avatar'] == NULL ? '/images/none.png' : '/uploads/avatars/'.$comment['Profile']['avatar'] ?>'></td>

								<!-- Сслыка на родительский комент, имя автора комента, дата комента -->
								<td>
									<a name="<?php echo $comment['id'] ?>"></a>
									<a href="#<?php echo $comment['comment_id'] == null ? 'post' : $comment['comment_id'] ?>">↑</a>
									<?php
										echo link_to($comment['Profile']['fullname'],'user_show',array('id' => $comment['Profile']['id']))
									?>
									<i style="font-size: 10px"><?php echo $comment['created_at'] ?></i>
								</td>
							</tr>

							<tr>
								<td colspan="2" align="justify">
									<!-- Текст комента -->
									<?php echo htmlspecialchars_decode($comment['text']) ?><br>

									<!-- Ссылка для коментирования этого комента -->
									<?php  if ($sf_user->isAuthenticated())
										{
											echo link_to('Ответить','comment_new',array('post_id' => $post_id, 'comment_id' => $comment['id']),array('class' => 'comment_answer'));
										}
									?>
								</td>
							</tr>
						</table>

									<!-- Рекурсивный вывод коментов к коментам -->
									<ul>
										<?php
											if (isset($comment['childs']))
												{ cnCommentTree::print_tree($comment['childs'], $post_id, $sf_user); }
										?>
									</ul>
								</td>

					</li> <!-- Конец комента к посту -->

				<?php endforeach;
    		}
	}