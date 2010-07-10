<?php

/**
 * Tag filter form base class.
 *
 * @package    capsoff.net
 * @subpackage filter
 * @author     Моисеев Данил
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseTagFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'views'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'posts'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'posts_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Post')),
    ));

    $this->setValidators(array(
      'name'       => new sfValidatorPass(array('required' => false)),
      'views'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'posts'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'posts_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Post', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tag_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addPostsListColumnQuery(Doctrine_Query $query, $field, $values)
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
          ->andWhereIn('PostTags.post_id', $values);
  }

  public function getModelName()
  {
    return 'Tag';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'name'       => 'Text',
      'views'      => 'Number',
      'posts'      => 'Number',
      'posts_list' => 'ManyKey',
    );
  }
}
