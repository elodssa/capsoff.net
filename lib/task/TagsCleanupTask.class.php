<?php

class TagsCleanupTask extends sfBaseTask
{
	protected function configure()
		{
			$this->namespace = 'tags';
			$this->name = 'cleanup';
			$this->briefDescription = 'Удаление тегов не связанных ни с одним постом';

			$this->detailedDescription = <<<EOF
Задача [tags:cleanup|INFO] удаляет из базы все теги, у которых отсутствует связь с постами в таблице PostTags:

[./symfony tags:cleanup|INFO]
EOF;
		}

	protected function execute($arguments = array(), $options = array())
		{
			$databaseManager = new sfDatabaseManager($this->configuration);
			$nb = Doctrine_Core::getTable('Tag')->cleanup();
			$this->logSection('doctrine', sprintf('Удалено %d несвязанных тегов', $nb));
		}
}