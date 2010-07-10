<?php

/**
 * Post filter form.
 *
 * @package    filters
 * @subpackage Post *
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class PostFormFilter extends BasePostFormFilter
{
  public function configure()
  {
	$this->widgetSchema['tags_list'] = new sfWidgetFormDoctrineChoice(array('model' => 'Tag'));
	$this->validatorSchema['tags_list'] = new sfValidatorDoctrineChoice(array('model' => 'Tag', 'required' => false));

	$this->widgetSchema->setLabels(array('category_id' => 'Рубрика', 'title' => 'Заголовок', 'created_at' => 'Опубликовано', 'tags_list' => 'Теги'));
  }
}