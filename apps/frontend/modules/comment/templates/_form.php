<div id="form">
  <form method="POST" action="<?php echo url_for('comment_create', array('post_id' => $post_id, 'comment_id' => $comment_id)) ?>">
    <div id="text_area">
      <?php echo $form['text']->render() ?>
      <?php echo $form['text']->renderError() ?>
    </div>

    <?php echo $form->renderHiddenFields() ?>

    <div id="add_button">
      <input type="submit" value="Добавить" />&nbsp&nbsp
    </div>
  </form>
</div> 
