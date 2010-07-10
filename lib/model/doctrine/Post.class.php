<?php

class Post extends BasePost
{
	public function updateLuceneIndex()
	{
		$index = PostTable::getLuceneIndex();

		// удалить существующие записи
		foreach ($index->find('pk:'.$this->getId()) as $hit)
			{
				$index->delete($hit->id);
			}

		// не индексировать истекшие и не активированные вакансии
		if (!$this->getIsShow())
			{
				return;
			}

		$doc = new Zend_Search_Lucene_Document();

		// сохраняем первичный ключ вакансии для идентификации ее в результатах поиска
		$doc->addField(Zend_Search_Lucene_Field::Keyword('pk', $this->getId()));

		// индексируем поля вакансии
		$doc->addField(Zend_Search_Lucene_Field::UnStored('title', $this->getTitle(), 'utf-8'));
		$doc->addField(Zend_Search_Lucene_Field::UnStored('text', $this->getText(), 'utf-8'));

		// добавляем работу в индекс
		$index->addDocument($doc);
		$index->commit();
	}

	public function save(Doctrine_Connection $conn = null)
		{
			if ($this->isNew())
				{
					$ret = parent::save($conn);

					$this->updateLuceneIndex();

					return $ret;
				}

			return parent::save($conn);
		}

	public function delete(Doctrine_Connection $conn = null)
	{
		$index = PostTable::getLuceneIndex();

		foreach ($index->find('pk:'.$this->getId()) as $hit)
			{
				$index->delete($hit->id);
			}

		return parent::delete($conn);
	}

	//Сохранение тегов поста
	public function saveTags($tag_string = null)
		{
			$tag_string = str_replace(' ','',strtolower(trim($tag_string)));
			$tag_array = explode(',',$tag_string);

			foreach ($tag_array as $i => $tag)
				{
                	if ($tag == '') { unset($tag_array[$i]); }
				}

            $tag_array = array_unique($tag_array);

			if(count($tag_array) != 0)
				{
					$exist_tags_query = Doctrine_Query::create()->select('t.id, t.name')
														->from('Tag t')
														->whereIn('LOWER(t.name)',$tag_array)
														->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

					$exist_tags = $exist_tags_query->execute();
					$exist_tags_query->free();

                    if(count($exist_tags) != 0)
						foreach ($exist_tags as $exist_tag)
							{
								$post_tag_bound = new PostTags();
								$post_tag_bound->post_id = $this->getId();
								$post_tag_bound->tag_id = $exist_tag['id'];
								$post_tag_bound->save();

								$exist_tag_pos = array_search($exist_tag['name'],$tag_array);
								unset($tag_array[$exist_tag_pos]);
							}

                    if(count($tag_array) != 0)
						foreach ($tag_array as $tag_name)
							{
                                $tag = new Tag();
                                $tag->setName($tag_name);
                                $tag->save();

								$post_tag_bound = new PostTags();
								$post_tag_bound->post_id = $this->getId();
								$post_tag_bound->tag_id = $tag['id'];
								$post_tag_bound->save();
							}
				}
		}

	//Получение строки с тегами для поста
	public function getPostTagsString()
		{
			$tags_string = null;
			$tags = $this->getPostTags();

			foreach ($tags as $tag):
				$tags_string = $tags_string.' '.$tag['name'];
			endforeach;

			trim($tags_string);

			return $tags_string;
		}

	//Получение дерева комментов поста
	public function getPostComments()
		{
        	$answer_list = Doctrine_Query::create()
        							->select('a.*, p.id, p.user_id, p.fullname, p.avatar')
        							->from('Answer a')
        							->where('a.post_id = ?',$this->id)
        							->andWhere('a.comment_id IS NULL')
        							->leftJoin('a.Profile p')
        							->orderBy('a.created_at ASC')
        							->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY)
        							->execute();

			if (count($answer_list) != 0)
				{
					$tree = array();

					$comment_list = Doctrine_Query::create()
        							->select('c.*, p.id, p.user_id, p.fullname, p.avatar')
        							->from('Answer c')
        							->where('c.post_id = ?',$this->id)
        							->leftJoin('c.Profile p')
        							->andWhere('c.comment_id IS NOT NULL')
        							->orderBy('c.created_at ASC')
        							->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY)
        							->execute();

                    $answer_count = count($answer_list);
					for ($root_id = 0; $root_id < $answer_count; $root_id++)
						{
							$tree[$root_id] = $answer_list[$root_id];

							if ($childs = $this->child_create($tree[$root_id]['id'], &$comment_list, count($comment_list)))
								{
									$tree[$root_id]['childs'] = $childs;
								}

                unset($answer_list[$root_id]);
						}

					return $tree;
				}
			else
				{ return null; }
		}

  	//Функция с рекурсией юзающаяся функцией получения дерева коментов поста
	private function child_create($parent_id, $recs, $rec_count)
		{
			$comments = array();
			$child_offset = 0;
			for ($comment_id = 0; $comment_id < $rec_count; $comment_id++)
				{
                	if ($recs[$comment_id]['comment_id'] == $parent_id)
                		{
                            $comments[$child_offset] = $recs[$comment_id];
                			if ($childs = $this->child_create($recs[$comment_id]['id'], &$recs, $rec_count))
                				{
                					$comments[$child_offset]['childs'] = $childs;
                				}
                        	$child_offset++;
                        	unset($comments[$comment_id]);
                		}
				}
			if (count($comments) == 0)
				{ return false; }
			else
				{ return $comments; }
		}

	//Увеличение просмотров поста
	public function increaseViews()
		{
        	$post_query = Doctrine_Query::create()
        							->update('Post p')
        							->set('p.views','?',$this->views + 1)
        							->where('p.id = ?',$this->id);

        	$update = $post_query->execute();

        	$post_query->free();
		}

	//Увеличение голосов поста
	public function increaseVotes($user_id = null)
		{
        	if ($this->isUserVotePost($user_id,$this->getId()))
        		{ return false; }
        	else
        		{
        			$this->setVotes($this->getVotes() + 1);
        			$this->save();
                	$plus = new UserPostVoting();
                	$plus->setUserId($user_id);
                	$plus->setPostId($this->getId());
                	$plus->save();

                	return true;
        		}
        }

	//Уменьшение голосов поста
	public function decreaseVotes($user_id = null)
		{

        	if ($this->isUserVotePost($user_id,$this->getId()))
        		{ return false; }
        	else
        		{
        			$this->setVotes($this->getVotes() - 1);
        			$this->save();
                	$plus = new UserPostVoting();
                	$plus->setUserId($user_id);
                	$plus->setPostId($this->getId());
                	$plus->save();

                	return true;
        		}
		}

	//Проверка, голосовал ли юзер за пост, использующаяса процедурами увеличения и уменьшения голосов поста
    private function isUserVotePost($user_id = null,$post_id = null)
    	{
            $voting = Doctrine::getTable('UserPostVoting')->createQuery('pv')
                                                          ->where('pv.post_id = ? AND pv.user_id = ?',array($post_id,$user_id))
                                                          ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                                                          ->execute();

			if (count($voting) == 0)
				{ return false; }
			else
				{ return true; }
    	}
}

