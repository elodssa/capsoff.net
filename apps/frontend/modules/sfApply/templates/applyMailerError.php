<?php use_helper('I18N') ?>
<div class="sf_apply_notice">
<?php echo __(<<<EOM
<p>
Во время отправки письма с подтверждением возникла ошибка.
Попробуйте зарегистрироваться позже
</p>
EOM
) ?>
<?php include_partial('sfApply/continue') ?>
</div>
