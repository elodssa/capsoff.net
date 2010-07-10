<?php

/**
 * OnlineUser filter form base class.
 *
 * @package    capsoff.net
 * @subpackage filter
 * @author     Моисеев Данил
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseOnlineUserFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('online_user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'OnlineUser';
  }

  public function getFields()
  {
    return array(
      'user_id' => 'Number',
    );
  }
}
