<?php $max_text_length = sfConfig::get('app_max_post_text_length') ?>

<?php foreach ($post_list as $post): ?>
	<div class="post_preview">

		<!-- Ссылка на рубрику (если нужна) -->
		<?php if ($categories): ?>
			<span class="post_category">
				<a href="
							<?php
								echo url_for(array(
													'module' => 'category',
													'action' => 'show',
													'id'     => $post['Category']['id']
													))
							?>
						">
					<?php  echo $post['Category']['name'] ?>
				</a>
			</span><span style="font-size: 30px">→</span>
		<?php endif ?>

		<!-- Ссылка на пост -->
		<span class="post_link">
			<a href="
						<?php
							echo url_for(array(
												'module' => 'post',
												'action' => 'show',
												'id'     => $post['id']
												))
						?>
					">
				<?php echo $post['title'] ?>
			</a>
		</span>


		<!-- Текст поста -->
		<div class="post_text">
			<?php
				if ((strlen($post['text']) > $max_text_length) && ((strlen($post['text']) - $max_text_length)) >= 1000)
					{
						echo substr($post['text'], 0, $max_text_length).'...'.'<br>';
						?>
							<a href="
										<?php
											echo url_for(array(
																'module' => 'post',
																'action' => 'show',
																'id'     => $post['id']
																))
										?>
									">
								Читать дальше<span style="font-size: 30px">→</span>
							</a>
						<?php
					}
				else
					{
						echo $post['text'];
					}
			?>
		</div>

		<!-- Дата создания поста и ее автор -->
		<div class="post_date">
			Автор: <span><?php echo 'username' ?></span> Опубликованно: <span><?php echo $post['created_at'] ?></span>
		</div>

		<!-- Теги поста	 -->
		<div class="post_tags">Тэги:
			<?php foreach ($post['Tags'] as $tag): ?>
						<a href="
									<?php
										echo url_for(array(
															'module' => 'tag',
															'action' => 'show',
															'id'     => $tag['id']
															))
									?>
								">
							<?php echo $tag['name'] ?>
						</a>
			<?php endforeach; ?>
		</div>


	</div>
<?php endforeach ?>