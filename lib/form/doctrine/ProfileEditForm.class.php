<?php
class ProfileEditForm extends ProfileForm
{
  public function configure()
  {
        unset($this['validate'], $this['user_id']);

		$this->validatorSchema['email'] = new sfValidatorAnd(array(
        		$this->validatorSchema['email'],
        		new sfValidatorEmail()
		));

        $this->validatorSchema['email']->setMessage('invalid', 'Неверный E-mail');
		$this->widgetSchema['avatar'] = new sfWidgetFormInputFile();

		$this->validatorSchema['avatar'] = new sfValidatorImage(array(
											'required' => false,
		                                   'path' => sfConfig::get('sf_upload_dir').'/avatars',
		                                   'mime_types' => 'web_images',
		                                   'max_size' => 153600));

		$this->validatorSchema['avatar']->setMessages(array(
                                        'max_size' => 'Аватарка слишком большая (максимум 150 Кбайт).',
                                        'mime_types' => 'Неверный тип файла'));

		$this->widgetSchema['password'] = new sfWidgetFormInputPassword();

		$this->widgetSchema['gender'] = new sfWidgetFormChoice(array(
		'choices'  => Doctrine_Core::getTable('Profile')->getGenders(),
		'expanded' => true));
		$this->validatorSchema['gender'] = new sfValidatorChoice(array(
		'choices' => array_keys(Doctrine_Core::getTable('Profile')->getGenders()),'required' => false));

		$this->widgetSchema->setLabels(array(
        'avatar' => 'Аватарка',
        'email' => 'E-mail',
        'gender' => 'Ваш пол',
        'fullname' => 'Ваш ник на сайте',
        'know' => 'Знаю',
        'want_know' => 'Хочу знать'
		));

		$this->widgetSchema->setHelps(array(
        'avatar' => 'Максимальное разрешение 100х100, максимальный размер 150кб',
        'fullname' => 'Если не указано, то на сайте будет отображаться ваш E-mail'
		));
  }
}