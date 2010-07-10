<?php
	slot('title','capsoff.net - Добавление поста');
	slot('new_post','shown');
?>

<div id="form">
	<h1>Добавить пост</h1>

	<form method="POST" action="<?php echo url_for('post_create') ?>">

		<div id="category">
			<?php echo $form['category_id']->renderLabel() ?><br>
			<?php echo $form['category_id']->render() ?>
			<?php echo $form['category_id']->renderError() ?>
		</div>


		<div id="title">
			<?php echo $form['title']->render() ?>
			<?php echo $form['title']->renderError() ?>
		</div>

		<div id="text_area">
			<?php echo $form['text']->renderRow() ?>
			<?php echo $form['text']->renderError() ?>
		</div>

		<div id="tags">
        	<?php echo $form['tags']->render() ?>
        	<?php echo $form['tags']->renderHelp() ?>
        	<?php echo $form['tags']->renderError() ?>
		</div>

		<?php echo $form->renderGlobalErrors(); ?>
		<?php echo $form->renderHiddenFields() ?>

		<div id="add_button"><input type="submit" value="Добавить" /></div>
	</form>
</div>


