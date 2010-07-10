<?php

/**
 * Answer form.
 *
 * @package    form
 * @subpackage Answer
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class AnswerForm extends BaseAnswerForm
{
  public function configure()
  {
	$this->widgetSchema['post_id'] = new sfWidgetFormInputHidden();
	$this->widgetSchema['comment_id'] = new sfWidgetFormInputHidden();

	$this->validatorSchema['text']->setMessage('required','Введите текст сообщения');
    $this->validatorSchema['text']->setMessage('max_length','Сообщение слишком длинное (%max_length% символов максимум).');
    $this->validatorSchema['text']->setMessage('min_length','Сообщение слишком короткое (%min_length% символов минимум).');

	unset($this['user_id'], $this['created_at'], $this['updated_at']);

	$this->widgetSchema->setLabels(array('text' => ' ',));
  }
}