<?php

/**
 * UserPostVoting filter form base class.
 *
 * @package    capsoff.net
 * @subpackage filter
 * @author     Моисеев Данил
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseUserPostVotingFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id' => new sfWidgetFormFilterInput(),
      'post_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Post'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'user_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'post_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Post'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('user_post_voting_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserPostVoting';
  }

  public function getFields()
  {
    return array(
      'id'      => 'Number',
      'user_id' => 'Number',
      'post_id' => 'ForeignKey',
    );
  }
}
