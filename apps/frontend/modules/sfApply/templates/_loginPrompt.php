<?php use_helper('I18N') ?>
<form method="POST" action="<?php echo url_for("@sf_guard_signin") ?>" name="sf_guard_signin" id="sf_guard_signin" class="sf_apply_signin_inline">
  <?php echo $form ?>
  <input type="submit" value="<?php echo __('sign in') ?>" />
  <p>
  <?php echo link_to(__('Сменить пароль'), 'sfApply/resetRequest')  ?>
  </p>
  <p>
  <?php
  echo link_to(__('Зарегистрироваться'), 'sfApply/apply')
  ?>
  </p>
</form>
