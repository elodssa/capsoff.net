<?php slot('title','capsoff.net - Регистрация') ?>

<?php use_helper('I18N') ?>

<?php
	include_stylesheets_for_form($form);
	include_javascripts_for_form($form);
	use_stylesheet('reg_form.css');
?>

<div id="form">

<?php if (!$sf_user->isAuthenticated()): ?>

		<form method="POST" enctype="multipart/form-data" action="<?php echo url_for('apply') ?>" name="sf_apply_apply_form" id="sf_apply_apply_form">
			<?php echo $form->renderHiddenFields() ?>

			<div id="">
				<?php echo $form['username']->renderLabel() ?><br>
				<?php echo $form['username']->render() ?> <span class="error"><?php echo $form['username']->getError() ?></span>
			</div><br>

			<div id="">
				<?php echo $form['password']->renderLabel() ?><br>
				<?php echo $form['password']->render() ?> <span class="error"><?php echo $form['password']->getError() ?></span>
				<span class="help"><?php echo $form['password']->renderHelp() ?></span>
			</div><br>

			<div id="">
				<?php echo $form['email']->renderLabel() ?><br>
				<?php echo $form['email']->render() ?><span class="error"> <?php echo $form['email']->getError() ?></span>
				<span class="help"><?php echo $form['email']->renderHelp() ?></span>
			</div><br>

			<div id="captcha">
				<?php echo $form['captcha']->renderLabel() ?><br>
				<?php echo $form['captcha']->render() ?><span class="error"> <?php echo $form['captcha']->getError() ?></span>
				<span class="help"><?php echo $form['captcha']->renderHelp() ?></span>
			</div><br>

			<input type="submit" value="Зарегистрироваться" class="button" />

			или

			<?php echo link_to("Отмена", sfConfig::get('app_sfApplyPlugin_after', '@homepage')) ?>

		</form>
	<?php else: ?>
		Вы уже зарегистрированы на сайте!
	<?php endif; ?>
</div>







