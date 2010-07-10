<?php use_stylesheet('profile_edit_form.css') ?>
<?php include_javascripts_for_form($form) ?>
<?php slot('title','capsoff.net - Редактирование вашего профиля') ?>

<div id="form">
<form method="POST" enctype="multipart/form-data" action="<?php echo url_for('user_update',array('id' => $profile['id'])) ?>" name="profile_form">

		<?php echo $form->renderHiddenFields(); ?>

		<div id="fullname">
			<?php echo $form['fullname']->renderLabel() ?><br>
			<?php echo $form['fullname']->render() ?>
			<span class="help">
            	<?php echo $form['fullname']->renderHelp() ?>
			</span>
			<?php echo $form['fullname']->renderError() ?>
		</div><br>

		<div id="email">
			<?php echo $form['email']->renderLabel() ?><br>
			<?php echo $form['email']->render() ?>
			<?php echo $form['email']->renderError() ?>
		</div><br>

		<div id="gender">
			<?php
				echo $form['gender']->renderLabel().': ';

				switch($profile['gender'])
					{
						case 'male':
							echo 'Мужчина';
							break;
						case 'female':
							echo 'Женщина';
							break;
						case 'undefined':
							echo 'Неизвестный';
							break;
					}
			?>
			<?php echo $form['gender']->render() ?>
			<?php echo $form['gender']->renderError() ?>
		</div>

		Текущая аватарка:<br>
		<?php if($profile['avatar'] != NULL): ?>
			<img src="/uploads/avatars/<?php echo $profile['avatar'] ?>">
		<?php else: ?>
        	<img alt="Не загружена" width="100" height="100">
        <?php endif; ?><br>
		<div id="avatar">
			<?php echo $form['avatar']->renderLabel() ?><br>
            <?php if($profile['avatar'] == null): ?>
				<?php echo $form['avatar']->render() ?>
				<span class="help">
					<?php echo $form['avatar']->renderHelp() ?>
				</span>
				<?php echo $form['avatar']->renderError() ?>
			<?php else: ?>
				<?php if($profile['avatar'] != null): ?><a href="<?php echo url_for('avatar_delete') ?>" >Удалить аватар</a><?php endif; ?>
			<?php endif; ?>

		</div><br>

		<div id="know">
			<?php echo $form['know']->renderLabel() ?><br>
			<?php echo $form['know']->render() ?>
			<?php echo $form['know']->renderError() ?>
		</div><br>

		<div id="want_know">
			<?php echo $form['want_know']->renderLabel() ?><br>
			<?php echo $form['want_know']->render() ?>
			<?php echo $form['want_know']->renderError() ?>
		</div><br>

		<?php $form->renderGlobalErrors() ?>

	<div id="add_button"><input type="submit" value="Сохранить" /></div>

	</form>
</div>