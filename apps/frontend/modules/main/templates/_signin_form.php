<?php slot('signin_form') ?>
	<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post" id="signin_form">
		<?php $form->renderHiddenFields(); ?>

		<?php echo $form['_csrf_token']->render() ?>

		<div>
			<div class="label"><?php echo $form['username']->renderLabel() ?></div>
			<?php echo $form['username']->render() ?> <?php echo link_to("Регистрация", "sfApply/apply"); ?>
		</div>

		<div id="password">
			<div class="label"><?php echo $form['password']->renderLabel() ?></div>
			<?php echo $form['password']->render() ?> <a href="<?php echo url_for('@sf_guard_password') ?>">Забыли пароль?</a>
		</div>

		<div id="remember">
			<?php echo $form['remember']->renderLabel() ?>
			<?php echo $form['remember']->render() ?>
			<input type="submit" value="<?php echo 'Войти' ?>" class="signin" />
		</div>
	</form>
<?php end_slot() ?>