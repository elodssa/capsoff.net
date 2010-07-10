<?php

/**
 * Profile filter form base class.
 *
 * @package    capsoff.net
 * @subpackage filter
 * @author     Моисеев Данил
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseProfileFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('sfGuardUser'), 'add_empty' => true)),
      'email'     => new sfWidgetFormFilterInput(),
      'gender'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'fullname'  => new sfWidgetFormFilterInput(),
      'avatar'    => new sfWidgetFormFilterInput(),
      'know'      => new sfWidgetFormFilterInput(),
      'want_know' => new sfWidgetFormFilterInput(),
      'validate'  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'user_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('sfGuardUser'), 'column' => 'id')),
      'email'     => new sfValidatorPass(array('required' => false)),
      'gender'    => new sfValidatorPass(array('required' => false)),
      'fullname'  => new sfValidatorPass(array('required' => false)),
      'avatar'    => new sfValidatorPass(array('required' => false)),
      'know'      => new sfValidatorPass(array('required' => false)),
      'want_know' => new sfValidatorPass(array('required' => false)),
      'validate'  => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('profile_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Profile';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'user_id'   => 'ForeignKey',
      'email'     => 'Text',
      'gender'    => 'Text',
      'fullname'  => 'Text',
      'avatar'    => 'Text',
      'know'      => 'Text',
      'want_know' => 'Text',
      'validate'  => 'Text',
    );
  }
}
