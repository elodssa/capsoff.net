<?php
    use_helper('Tag');
    use_helper('Text');

    use_stylesheet('posts.css');

    use_javascript('rating.js');
?>

<div id="vote_notice">
</div>

<div class="sorts_and_pager">
  <?php
    if (!isset($search_params)) { $search_params = ''; }

    include_partial('post/pager', array('uri'           => $uri,
                                        'pager'         => $pager,
                                        'sort_by'       => $sort_by,
                                        'sort_type'     => $sort_type,
                                        'search_params' => $search_params));

    include_partial('post/sort',array('uri'             => $uri,
                                      'sorts_for_links' => $sorts_for_links,
                                      'sort_by'         => $sort_by,
                                      'sort_type'       => $sort_type,
                                      'search_params'   => $search_params));

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
                if ((strlen($post['text']) > $max_text_length) && ((strlen($post['text']) - $max_text_length)) >= 100)
                    {
                        echo htmlspecialchars_decode($post['text']), '<br>';
                        echo link_to('Читать дальше → ', 'post_show', array('id' => $post['id']));
                    }
                else
                    {
                        echo htmlspecialchars_decode($post['text']);
                    }
            ?>
        </div>

        <!-- Теги поста	 -->
        <?php if (count($post['Tags']) != 0): ?>
            <div class="post_tags">
                <img src="/images/tag.png" alt="метки">
                
                <?php
                    foreach ($post['Tags'] as $tag)
                        { echo link_to($tag['name'], 'tag_show', array('id' => $tag['id'])).'&nbsp;&nbsp;'; }
                ?>
            </div>
        <?php endif; ?>

        <div class="post_bar">
            <div class="rating_block">
                <?php
                    $plus  = '';
                    $minus = '';
                    if ($sf_user->isAuthenticated())
                        {
                            $img  = tag('img',array('src' => '/images/plus.png'));
                            $plus = content_tag('a',$img,array('href'  => url_for('post_vote_plus',array('id' => $post['id'])),
                                                            'class' => 'vote',
                                                            'title' => 'Хороший пост!'));

                            $img   = tag('img',array('src' => '/images/minus.png'));
                            $minus = content_tag('a',$img,array('href'  => url_for('post_vote_minus',array('id' => $post['id'])),
                                                                'class' => 'vote',
                                                                'title' => 'Плохой пост!'));
                        }

                    else
                        {
                            $plus  = tag('img',array('src' => '/images/plus_inactive.png'));
                            $minus =  tag('img',array('src' => '/images/minus_inactive.png'));
                        }

                    echo $plus;
                    echo content_tag('span',sprintf(' %s ',$post['votes']),array('class' => 'rating'));
                    echo '<img src="/images/loader.gif" id="loader" style="display:none">';
                    echo $minus;
                ?>

               <img src="/images/separator.png">
            </div>

            <div class="date">
                <img src="/images/data.png" align="middle" title="Дата публикации">
                <?php echo $post['created_at']; ?>
                <img src="/images/separator.png">
            </div>

            <div class="autor">
                <img src="/images/autor.png" align="middle" title="Автор">
                <?php
                    echo link_to($post['Profile']['fullname'],
                                'user_show',
                                array('id'    => $post['Profile']['id']),
                                array('class' => 'user_menu'));
                ?>
                <img src="/images/separator.png">
            </div>

            <div class="views">
                <img src="/images/views.png" title="Просмотров">
                <?php echo $post['views'] ?>
                <img src="/images/separator.png">
            </div>

            <div class="comments">
                <img src="/images/comments.png" title="Комментов">
                <?php echo $post['comments']; ?>
            </div>

            <?php if($sf_user->isAuthenticated()): ?>
                <div>
                    <img src="/images/separator.png">
                    <?php
                        $url = url_for('answer_new',array('post_id' => $post['id']));
                        echo tag('img',array('src' => '/images/comment.png', 'title' => 'Комментировать'));
                        echo content_tag('a','Комментировать',array('href' => $url));
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>

<?php
    include_partial('post/pager', array('uri'           => $uri,
                                        'pager'         => $pager,
                                        'sort_by'       => $sort_by,
                                        'sort_type'     => $sort_type,
                                        'search_params' => $search_params));
?>
