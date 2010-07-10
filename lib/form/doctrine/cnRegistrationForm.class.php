<?php

class cnRegistrationForm extends ProfileForm
{
  private $validate = null;

  public function configure()
  {
    parent::configure();

    // We're making a new user or editing the user who is
    // logged in. In neither case is it appropriate for
    // the user to get to pick an existing userid. The user
    // also doesn't get to modify the validate field which
    // is part of how their account is verified by email.

    unset($this['user_id'], $this['fullname'], $this['validate'], $this['avatar']);

    // Add username and password fields which we'll manage
    // on our own. Before you ask, I experimented with separately
    // emitting, merging or embedding a form subclassed from
    // sfGuardUser. It was vastly more work in every instance.
    // You have to clobber all of the other fields (you can
    // automate that, but still). If you use embedForm you realize
    // you've got a nested form that looks like a
    // nested form and an end user looking at that and
    // saying "why?" If you use mergeForm you can't save(). And if
    // you output the forms consecutively you have to manage your
    // own transactions. Adding two fields to the profile form
    // is definitely simpler.

    $this->setWidget('username', new sfWidgetFormInput(
      array(), array('maxlength' => 16)
    ));

    $this->widgetSchema->moveField('username', sfWidgetFormSchema::FIRST);

    $this->setWidget('password', new sfWidgetFormInputPassword(
      array(), array('maxlength' => 128)
    ));

    $this->widgetSchema->moveField('password', sfWidgetFormSchema::AFTER, 'username');

    $this->widgetSchema->setNameFormat('sfApplyApply[%s]');
    $this->widgetSchema->setFormFormatterName('list');

    // We have the right to an opinion on these fields because we
    // implement at least part of their behavior. Validators for the
    // rest of the user profile come from the schema and from the
    // developer's form subclass

    $this->setValidator('username',
      new sfValidatorAnd(array(
        new sfValidatorString(array(
          'required' => true,
          'trim' => true,
          'min_length' => 4,
          'max_length' => 16
        )),
        // Usernames should be safe to output without escaping and generally username-like.
        new sfValidatorRegex(array(
          'pattern' => '/^\w+$/'
        ), array('invalid' => 'Логин может содержать только буквы, цифры и символ подчеркивания.')),
        new sfValidatorDoctrineUnique(array(
          'model' => 'sfGuardUser',
          'column' => 'username'
        ), array('invalid' => 'Пользователь с таким именем уже существует.'))
      ))
    );

    // Passwords are never printed - ever - except in the context of Symfony form validation which has built-in escaping.
    // So we don't need a regex here to limit what is allowed

    // Don't print passwords when complaining about inadequate length
    $this->setValidator('password', new sfValidatorString(array(
      'required' => true,
      'trim' => true,
      'min_length' => 6,
      'max_length' => 128
    ), array(
      'min_length' => 'Пароль слишком короткий. Он должен содержать минимум %min_length% символов')));

    // Be aware that sfValidatorEmail doesn't guarantee a string that is preescaped for HTML purposes.
    // If you choose to echo the user's email address somewhere, make sure you escape entities.
    // <, > and & are rare but not forbidden due to the "quoted string in the local part" form of email address
    // (read the RFC if you don't believe me...).

    $this->setValidator('email', new sfValidatorAnd(array(
      new sfValidatorEmail(array('required' => true, 'trim' => true)),
      new sfValidatorString(array('required' => true, 'max_length' => 80)),
      new sfValidatorDoctrineUnique(array(
        'model' => 'Profile',
        'column' => 'email'
      ), array('invalid' => 'Пользователь с такой почтой уже существует. Если вы забыли свой пароль, нажмите "Отмена", а затем "Я забыл пароль"'))
    )));

    // Disallow <, >, & and | in full names. We forbid | because
    // it is part of our preferred microformat for lists of disambiguated
    // full names in sfGuard apps: Full Name (username) | Full Name (username) | Full Name (username)

    $this->setWidget('captcha', new sfWidgetCaptchaGD());
	$this->widgetSchema->setHelp('captcha','Чтобы обновить капчу кликните по ней');

    $this->setValidator('captcha', new sfCaptchaGDValidator(array('length' => 5)));

    $this->widgetSchema->setLabels
    		(array('username' => 'Логин для авторизации',
    		       'password' => 'Пароль',
    		       'captcha' => 'Введите код с картинки'));

	$this->widgetSchema->setHelps(array(
    								'password' => 'минимум 6 знаков',
    								'email' => 'на этот адрес вам будет выслано письмо с подтверждением регистрации',
    								'captcha' => 'Чтобы обновить капчу кликните по ней'));

	$this->validatorSchema['username']->setMessage('required', 'Введите логин');
	$this->validatorSchema['password']->setMessage('required', 'Введите пароль');
	$this->validatorSchema['email']->setMessage('required','Введите адрес почты');
    $this->validatorSchema['email']->setMessage('invalid','Неверный адрес почты');

	$this->validatorSchema['captcha']->setMessages(array('invalid' => 'Неверный код с картинки', 'required' => 'Введите код с картинки'));
  }

  public function setValidate($validate)
  {
    $this->validate = $validate;
  }

  public function doSave($con = null)
  {
    $user = new sfGuardUser();
    $user->setUsername($this->getValue('username'));
    $user->setPassword($this->getValue('password'));
    // They must confirm their account first
    $user->setIsActive(false);
    $user->save();
    $this->userId = $user->getId();

    return parent::doSave($con);
  }

  public function updateObject($values = null)
  {
    $object = parent::updateObject($values);
    $object->setUserId($this->userId);
    $object->setValidate($this->validate);

    // Don't break subclasses!
    return $object;
  }
}

