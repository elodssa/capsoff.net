<?php

/**
 * Post form.
 *
 * @package    form
 * @subpackage Post
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class PostForm extends BasePostForm
{
	public function configure()
		{
			$this->setWidget('tags', new sfWidgetFormInput());

			$this->setValidator('tags', new sfValidatorString(array('required' => false, 'max_length' => 1000)));
			$this->widgetSchema->setHelp('tags', 'Для разделения тегов используйте запятую');

			$this->validatorSchema['title']->setMessage('max_length','Заголовок слишком длинный (%max_length% символов максимум).');
			$this->validatorSchema['text']->setMessage('required','Введите текст сообщения');
			$this->validatorSchema['text']->setMessage('max_length','Сообщение слишком длинное (%max_length% символов максимум).');
			$this->validatorSchema['text']->setMessage('min_length','Сообщение слишком короткое (%min_length% символов минимум).');

			$this->widgetSchema->setLabels(array('category_id' => 'Рубрика', 'title' => 'Заголовок', 'text' => ' ', 'tags' => 'Теги'));


			$this->useFields(array('category_id','title','text','tags'));
		}
}