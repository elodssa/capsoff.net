<?php slot('sidebar') ?>
	<?php include_partial('main/sidebar',array('sidebar' => $sidebar)); ?>
<?php end_slot(); ?>

<?php
    slot('title','capsoff.net - Просмотр поста');
    use_stylesheet('posts.css');
    use_stylesheet('post.css');
    use_helper('Text');
    use_helper('Tag');

    use_javascript('rating.js');

    if($sf_user->isAuthenticated())
        {
            use_javascript('answer.js');
            use_javascript('ckeditor/ckeditor.js');
            use_javascript('ckeditor/adapters/jquery.js');
        }
?>
<div id="vote_notice">
</div>
<div class="post_preview">
	<!-- Ссылка на рубрику (если нужна) -->
	<div class="post_header">
		<a name="post"></a>

		<?php  echo link_to($post['Category']['name'], 'category_show', $post['Category'])  ?>
		→
		<!-- Ссылка на пост -->
		<?php echo $post['title'] ?>
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

		<div class="post_bar">
        <div class="rating_block">
            <?php
                $plus = '';
                $minus = '';
                if ($sf_user->isAuthenticated())
                    {
                        $img = tag('img',array('src' => '/images/plus.png'));
                        $plus = content_tag('a',$img,array('href' => url_for('post_vote_plus',array('id' => $post['id'])),
                                                        'class' => 'vote',
                                                        'title' => 'Хороший пост!'));

                        $img = tag('img',array('src' => '/images/minus.png'));
                        $minus =  content_tag('a',$img,array(
                                                        'href' => url_for('post_vote_minus',array('id' => $post['id'])),
                                                        'class' => 'vote',
                                                        'title' => 'Плохой пост!'));
                    }

                else
                    {
                        $plus = tag('img',array('src' => '/images/plus_inactive.png'));
                        $minus =  tag('img',array('src' => '/images/minus_inactive.png'));
                    }

                echo $plus;
                echo content_tag('span',sprintf(' %s ',$post['votes']),array('class' => 'rating'));
                echo '<img src="/images/loader.gif" id="loader" style="display:none">';
                echo $minus;
            ?>
        </div>

      <div class="date">
        <img src="/images/data.png" align="middle" title="Дата публикации">
        <?php echo $post['created_at'] ?>
      </div>
      <div class="autor">
        <img src="/images/autor.png" align="middle" title="Автор">
        <?php
          echo link_to($post['Profile']['fullname'],'user_show',array('id' => $post['Profile']['id']))
        ?>
      </div>
      <div class="views">
        <img src="/images/views.png" title="Просмотров">
        <?php echo $post['views'] ?>
      </div>
      <div class="comments">
        <img src="/images/comments.png" title="Комментов"> <?php echo $post['comments']; ?>
      </div>
      <?php if($sf_user->isAuthenticated()): ?>
      <div id="post_commenting">
        <?php
          echo $img = tag('img',array('src' => '/images/comment.png', 'title' => 'Ответить'));
          $url = url_for('answer_new',array('post_id' => $post['id']));
          echo content_tag('a','Комментировать',array('href' => $url, 'id' => 'comment_post'));
        ?>
      </div>
      <?php endif; ?>
    </div>
</div>
			<!-- Рекурсивный вывод коментов к посту-->
			<div><ul>
				<?php
					if ($comment_tree != null)

						{
							?>Комментарии:<?php
							cnCommentTree::print_tree($comment_tree, $post['id'], $sf_user);
						}
				?>
			</ul></div>
