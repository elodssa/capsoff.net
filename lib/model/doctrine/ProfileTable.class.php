<?php

class ProfileTable extends Doctrine_Table
{
  static public $genders = array(
    'male' => 'Мужчина',
    'female' => 'Женщина',
    'undefined' => 'Неизвестный');

	public function getGenders()
		{
			return self::$genders;
		}

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
 			return sfConfig::get('sf_data_dir').'/user.index';
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

			$q = $this->getIndexUsers()
				->whereIn('u.id', $pks)
				->limit(sfConfig::get('app_search_results'));

			return $q;
		}

	public function getIndexUsers()
		{
        	$q = Doctrine_Query::create()
        			  ->select('u.fullname, u.know, u.want_know')
        			  ->addSelect('(SELECT ou.user_id FROM OnlineUser ou WHERE ou.user_id = u.user_id) as online')
        			  ->from('Profile u')
        			  ->orderBy('u.fullname');

        	return $q;
		}

	public function getProfileForShow($user_id = null)
		{
        	$q = Doctrine_Query::create()
        			  ->select('u.*, p.id, c.id,
								COUNT(DISTINCT p.id) AS posts,
								COUNT(DISTINCT c.id) AS comments,
        			  		   ')
        			  ->addSelect('(SELECT ou.user_id FROM OnlineUser ou WHERE ou.user_id = u.user_id) as status')
        			  ->from('Profile u, u.Post p, u.Answer c')
        			  ->where('u.id = ?',$user_id)
        			  ->orderBy('u.fullname')
        			  ->groupBy('u.id')
        			  ->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

        	$profile = $q->execute();
        	$q->free();

        	return $profile[0];
		}
}
