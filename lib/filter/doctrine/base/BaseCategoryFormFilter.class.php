<?php

/**
 * Category filter form base class.
 *
 * @package    capsoff.net
 * @subpackage filter
 * @author     Моисеев Данил
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCategoryFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'cover' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'  => new sfValidatorPass(array('required' => false)),
      'cover' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('category_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Category';
  }

  public function getFields()
  {
    return array(
      'id'    => 'Number',
      'name'  => 'Text',
      'cover' => 'Text',
    );
  }
}
