<?php

/**
 * Post filter form base class.
 *
 * @package    capsoff.net
 * @subpackage filter
 * @author     Моисеев Данил
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasePostFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'category_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'add_empty' => true)),
      'user_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Profile'), 'add_empty' => true)),
      'title'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'text'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'views'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'votes'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_show'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'tags_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Tag')),
    ));

    $this->setValidators(array(
      'category_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Category'), 'column' => 'id')),
      'user_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Profile'), 'column' => 'id')),
      'title'       => new sfValidatorPass(array('required' => false)),
      'text'        => new sfValidatorPass(array('required' => false)),
      'views'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'votes'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_show'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'tags_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Tag', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('post_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addTagsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query->leftJoin('r.PostTags PostTags')
          ->andWhereIn('PostTags.tag_id', $values);
  }

  public function getModelName()
  {
    return 'Post';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'category_id' => 'ForeignKey',
      'user_id'     => 'ForeignKey',
      'title'       => 'Text',
      'text'        => 'Text',
      'views'       => 'Number',
      'votes'       => 'Number',
      'is_show'     => 'Boolean',
      'created_at'  => 'Date',
      'updated_at'  => 'Date',
      'tags_list'   => 'ManyKey',
    );
  }
}
