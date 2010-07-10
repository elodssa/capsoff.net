<?php

/**
 * Answer form base class.
 *
 * @method Answer getObject() Returns the current form's model object
 *
 * @package    capsoff.net
 * @subpackage form
 * @author     Моисеев Данил
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAnswerForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'user_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Profile'), 'add_empty' => true)),
      'post_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Post'), 'add_empty' => false)),
      'comment_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Answer'), 'add_empty' => true)),
      'text'       => new sfWidgetFormTextarea(),
      'comments'   => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'user_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Profile'), 'required' => false)),
      'post_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Post'))),
      'comment_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Answer'), 'required' => false)),
      'text'       => new sfValidatorString(array('max_length' => 4000)),
      'comments'   => new sfValidatorInteger(array('required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('answer[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Answer';
  }

}
