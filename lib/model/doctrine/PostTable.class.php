<?php

class PostTable extends Doctrine_Table
{
	static public function getLuceneIndex()
		{
			ProjectConfiguration::registerZend();

			Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive());
			Zend_Search_Lucene_Search_QueryParser::setDefaultEncoding('UTF-8');

			if (file_exists($index = self::getLuceneIndexFile()))
				{
					return Zend_Search_Lucene::open($index);
				}
			else
				{
					return Zend_Search_Lucene::create($index);
				}
		}

	static public function getLuceneIndexFile()
		{
			return sfConfig::get('sf_data_dir').'/post.index';
		}

	public function getForLuceneQuery($query)
	{
		$hits = self::getLuceneIndex()->find($query);

		$pks = array();
		foreach ($hits as $hit)
			{
				$pks[] = $hit->pk;
			}

		if (empty($pks))
			{
				return false;
			}

		$q = $this->getFullPostQuery()
			->andWhereIn('p.id', $pks)
			->limit(sfConfig::get('app_search_results'));

		return $q;
	}

	public function getResentPosts()
		{
        	return Doctrine_Query::create()
									->select('p.id, p.title, p.created_at')
									->from('Post p')
									->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY)
									->limit(sfConfig::get('app_posts_on_resent_posts_block'))
									->execute();
		}


	public function getUserPost($user_id = null)
		{
        	$post_query = $this->getFullPostQuery()
        					   ->andWhere('p.user_id = ?',$user_id)
        					   ->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

        	return $post_query;
		}


	static public function addSortQuery(Doctrine_Query $post_query = null,$sort_by = null,$sort_type = null)
		{
			$sorts_for_links = array('title' =>      array('header' => 'заголовку',    'type' => 'DESC'),
									 'comments' =>   array('header' => 'комментам',    'type' => 'DESC'),
									 'views' =>      array('header' => 'просмотрам',   'type' => 'DESC'),
									 'votes' =>      array('header' => 'рейтингу',     'type' => 'DESC'),
									 'created_at' => array('header' => 'дате создания','type' => 'DESC'));

        	if (in_array($sort_by,array('title','comments','views','votes','created_at')) and
				in_array($sort_type,array('ASC','DESC')))
					{
						if ($sort_by == 'comments')
                        	{ $post_query->orderBy($sort_by. ' ' .$sort_type); }
                        else
							{ $post_query->orderBy('p.' . $sort_by. ' ' .$sort_type); }

                        if ($sort_type == 'ASC')
							{ $sorts_for_links[$sort_by]['type'] = 'DESC'; }
						else
							{ $sorts_for_links[$sort_by]['type'] = 'ASC'; }
					}
				else
					{
                    	$post_query->orderBy('p.created_at DESC');
                    	$sorts_for_links['created_at']['type'] = 'ASC';
					}

			return array('query' => $post_query, 'sorts_for_links' => $sorts_for_links);

		}

	static public function getFullPostQuery()
		{
			$q = Doctrine_Query::create()
							->select('p.id, p.user_id, p.title, p.text, p.views, p.votes, p.created_at, p.is_show,
							         c.id, c.name,
							         t.id, t.name,
							         u.id, u.fullname')
							->addSelect('(SELECT COUNT(DISTINCT cm.id) FROM Answer cm WHERE cm.post_id = p.id) AS comments')
							->from('Post p')
							->leftJoin('p.Category c')
							->leftJoin('p.Tags t')
							->leftJoin('p.Profile u')
							->where('p.is_show = ?',true);

			return $q;
		}

	public function getIndexPosts($user_id = null)
		{
			$q = $this->getFullPostQuery()->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

			return $q;
		}

	public function getPostForShow($post_id = null)
		{
        	$post_query = $this->getFullPostQuery()->andWhere('p.id = ?',$post_id);

            $post = $post_query->execute();
            $post_query->free();

        	return $post[0];
		}

	public function getPostForTest($post_id = null)
		{
        	$post_query = Doctrine_Query::create()->select('p.id, p.views')
												  ->from('Post p')->where('p.id = ?',$post_id)
												  ->setHydrationMode(Doctrine_Core::HYDRATE_RECORD);

			$post = $post_query->execute();
            $post_query->free();

       		if (isset($post[0])) { return $post[0];}
      		elseif (count($post == 0)) { return false;}
		}
}