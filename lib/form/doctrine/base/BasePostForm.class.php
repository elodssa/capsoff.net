<?php

/**
 * Post form base class.
 *
 * @method Post getObject() Returns the current form's model object
 *
 * @package    capsoff.net
 * @subpackage form
 * @author     Моисеев Данил
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasePostForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'category_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'add_empty' => false)),
      'user_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Profile'), 'add_empty' => true)),
      'title'       => new sfWidgetFormTextarea(),
      'text'        => new sfWidgetFormTextarea(),
      'views'       => new sfWidgetFormInputText(),
      'votes'       => new sfWidgetFormInputText(),
      'is_show'     => new sfWidgetFormInputCheckbox(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
      'tags_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Tag')),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'category_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Category'))),
      'user_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Profile'), 'required' => false)),
      'title'       => new sfValidatorString(array('max_length' => 300)),
      'text'        => new sfValidatorString(array('max_length' => 4000)),
      'views'       => new sfValidatorInteger(array('required' => false)),
      'votes'       => new sfValidatorInteger(array('required' => false)),
      'is_show'     => new sfValidatorBoolean(array('required' => false)),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
      'tags_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Tag', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('post[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Post';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['tags_list']))
    {
      $this->setDefault('tags_list', $this->object->Tags->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveTagsList($con);

    parent::doSave($con);
  }

  public function saveTagsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['tags_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Tags->getPrimaryKeys();
    $values = $this->getValue('tags_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Tags', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Tags', array_values($link));
    }
  }

}
