<?php

/**
 * Answer filter form base class.
 *
 * @package    capsoff.net
 * @subpackage filter
 * @author     Моисеев Данил
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAnswerFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Profile'), 'add_empty' => true)),
      'post_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Post'), 'add_empty' => true)),
      'comment_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Answer'), 'add_empty' => true)),
      'text'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'comments'   => new sfWidgetFormFilterInput(),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'user_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Profile'), 'column' => 'id')),
      'post_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Post'), 'column' => 'id')),
      'comment_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Answer'), 'column' => 'id')),
      'text'       => new sfValidatorPass(array('required' => false)),
      'comments'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('answer_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Answer';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'user_id'    => 'ForeignKey',
      'post_id'    => 'ForeignKey',
      'comment_id' => 'ForeignKey',
      'text'       => 'Text',
      'comments'   => 'Number',
      'created_at' => 'Date',
      'updated_at' => 'Date',
    );
  }
}
