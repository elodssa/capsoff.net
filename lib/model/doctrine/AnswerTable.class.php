<?php

class AnswerTable extends Doctrine_Table
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
		return sfConfig::get('sf_data_dir').'/comment.index';
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

		$q = Doctrine_Query::create()
			->select('c.*, u.user_id, u.fullname')
			->from('Answer c')
			->whereIn('c.id', $pks)
			->leftJoin('c.Profile u')
			->limit(sfConfig::get('app_search_results'));

		return $q;
	}

	public function getUserComments($user_id = null)
		{
        	$comment_query = $this->createQuery('c')->where('c.user_id = ?',$user_id);

			return $comment_query;
		}


	public function getAnswerText($id = null)
		{
        	$comment_query = Doctrine_Query::create()
								->select('c.text, c.user_id, p.fullname')
								->from('Answer c')
								->leftJoin('c.Profile p')
								->where('c.id = ?',$id)
								->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

			$comment = $comment_query->execute();
			$comment_query->free();

			return $comment[0];
		}

	static public function addSortQuery(Doctrine_Query $comment_query = null,$sort_by = null,$sort_type = null)
		{
			$sorts_for_links = array('created_at' => array('header' => 'дате создания','type' => 'DESC'));

        	if (in_array($sort_by,array('created_at')) and
				in_array($sort_type,array('ASC','DESC')))
					{
						$comment_query->orderBy(sprintf('c.%s %s',$sort_by,$sort_type));

                        if ($sort_type == 'ASC')
							{ $sorts_for_links[$sort_by]['type'] = 'DESC'; }
						else
							{ $sorts_for_links[$sort_by]['type'] = 'ASC'; }
					}
				else
					{
                    	$comment_query->orderBy('с.created_at DESC');
                    	$sorts_for_links['created_at']['type'] = 'ASC';
					}

			return array('query' => $comment_query, 'sorts_for_links' => $sorts_for_links);

		}
}