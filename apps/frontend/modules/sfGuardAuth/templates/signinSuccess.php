<?php
	use_helper('I18N');
	use_stylesheet('signin_form.css');
	slot('title','capsoff.net - Вход');
?>

<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post" id="form">

	<?php $form->renderHiddenFields(); ?>

	<?php echo $form['_csrf_token']->render() ?>

	<div>
    	<?php echo $form['username']->renderLabel() ?><br>
    	<?php echo $form['username']->render() ?>
    	<?php echo $form['username']->renderError() ?>
   	</div><br>

	<div>
    	<?php echo $form['password']->renderLabel() ?><br>
    	<?php echo $form['password']->render() ?>
    	<?php echo $form['password']->renderError() ?><br>
   	</div><br>

	<div>
    	<?php echo $form['remember']->renderLabel() ?>
    	<?php echo $form['remember']->render() ?>
    	<?php echo $form['remember']->renderError() ?>
   	</div><br>

  <input type="submit" value="<?php echo __('Войти') ?>" class="button" />
  <a href="<?php echo url_for('@sf_guard_password') ?>"><?php echo __('Забыли пароль?') ?></a><br><br>

  <?php echo link_to("Регистрация", "sfApply/apply"); ?>

</form>