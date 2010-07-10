<?php

class BackendPostForm extends PostForm
{
	public function configure()
		{
        	parent::configure();

			$this->widgetSchema->setLabels(array('title' => 'Заголовок', 'tags_list' => 'Теги поста', 'text' => 'Текст'));

			$this->widgetSchema->setHelps(array('title' => ' '));
		}


	protected function removeFields()
	{
		unset($this['created_at'], $this['updated_at']);
	}
}