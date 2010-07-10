<?php

class Tag extends BaseTag
{
	public function GetTagPosts()
		{
			$q = PostTable::getFullPostQuery()
					->andWhere('p.id IN (SELECT pt.post_id FROM PostTags pt WHERE pt.tag_id = ?)',$this['id'])
					->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

			return $q;
		}
}