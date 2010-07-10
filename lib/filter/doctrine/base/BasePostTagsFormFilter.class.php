<?php

/**
 * PostTags filter form base class.
 *
 * @package    capsoff.net
 * @subpackage filter
 * @author     Моисеев Данил
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasePostTagsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('post_tags_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PostTags';
  }

  public function getFields()
  {
    return array(
      'id'      => 'Number',
      'post_id' => 'Number',
      'tag_id'  => 'Number',
    );
  }
}
