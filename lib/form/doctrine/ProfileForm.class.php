<?php

/**
 * Profile form.
 *
 * @package    forum
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProfileForm extends BaseProfileForm
{
  public function configure()
  {
		unset($this['validate']);

		$this->widgetSchema['avatar'] = new sfWidgetFormInputFile();

		$this->validatorSchema['fullname']->setOption('required', true);

		$this->validatorSchema['avatar'] = new sfValidatorImage(array(
											'required' => false,
		                                   'path' => sfConfig::get('sf_upload_dir').'/avatars',
		                                   'mime_types' => 'web_images',
		                                   'max_size' => 153600));

		$this->validatorSchema['avatar']->setMessages(array(
                                        'max_size' => 'Аватарка слишком большая (максимум 150 Кбайт).',
                                        'mime_types' => 'Неверный тип файла'));
  }
}
