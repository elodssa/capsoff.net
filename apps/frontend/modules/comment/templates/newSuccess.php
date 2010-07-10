<?php
	use_stylesheet('comment_form.css');
	use_stylesheet('search.css');

	slot('title','capsoff.net - Добавление комментария к комментарию');
?>

<h2>Добавить ответ к:</h1>

<div id="commented_text">
  <div id="commented_user">
    <b><?php echo $commented_text['Profile']['fullname'] ?></b>
  </div>
  <?php echo $commented_text['text'] ?>
</div>

<?php include_partial('comment/form',array('form' => $form, 'post_id' => $post_id, 'comment_id' => $comment_id));
