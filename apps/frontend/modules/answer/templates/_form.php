<div id="form">
    <form method="POST" action="<?php echo url_for('answer_create', array('post_id' => $post_id)) ?>">
    <div id="text_area">
      <?php echo $form['text']->render() ?>
      <?php echo $form['text']->renderError() ?>
    </div>

    <?php echo $form->renderHiddenFields() ?>
    <?php echo $form->renderGlobalErrors() ?>

    <div id="add_button">
      <input type="submit" value="Добавить" />&nbsp&nbsp
    </div>
    </form>

    <div id="errors">

    </div>
</div>