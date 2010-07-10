<?php

/**
 * Profile form base class.
 *
 * @method Profile getObject() Returns the current form's model object
 *
 * @package    capsoff.net
 * @subpackage form
 * @author     Моисеев Данил
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseProfileForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'user_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('sfGuardUser'), 'add_empty' => false)),
      'email'     => new sfWidgetFormInputText(),
      'gender'    => new sfWidgetFormInputText(),
      'fullname'  => new sfWidgetFormInputText(),
      'avatar'    => new sfWidgetFormInputText(),
      'know'      => new sfWidgetFormTextarea(),
      'want_know' => new sfWidgetFormTextarea(),
      'validate'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'user_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('sfGuardUser'))),
      'email'     => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'gender'    => new sfValidatorString(array('max_length' => 16, 'required' => false)),
      'fullname'  => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'avatar'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'know'      => new sfValidatorString(array('max_length' => 511, 'required' => false)),
      'want_know' => new sfValidatorString(array('max_length' => 511, 'required' => false)),
      'validate'  => new sfValidatorString(array('max_length' => 17, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Profile', 'column' => array('email')))
    );

    $this->widgetSchema->setNameFormat('profile[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Profile';
  }

}
