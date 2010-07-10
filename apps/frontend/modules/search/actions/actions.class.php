<?php

/**
 * search actions.
 *
 * @package    capsoff.net
 * @subpackage search
 * @author     Моисеев Данил
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class searchActions extends cnSearchActions
{
	public function executeAllSearch(sfWebRequest $request)
		{
        	$this->getUser()->setLastVisit('search.index');
			$this->sidebar = $this->loadSidebar(array('resentPosts','tagCloud','onlineUsers'));
		}

	public function executePostSearch(sfWebRequest $request)
		{
        	$this->getUser()->setLastVisit('search.post');
			$query = $request->getParameter('query');

			$user_id = $this->getUser()->getUserId();

			if(($query != null) and $post_query = Doctrine_Core::getTable('Post')->getForLuceneQuery($query))
				{
					$search_params = '&query=' . $query . '&';
                    $this->results = array_merge($this->postPagerInit($request, $post_query),
                    										array(
															'uri' => $this->generateUrl('post_search',array()),
															'search_params' => $search_params,
															'user_id' => $user_id,
															'category_show' => false,
															'query' => $query));

                    $this->results['post_list'] = $this->resultTextPreprocessing($this->results['post_list'],$query);

					$this->found_something = true;
				}
			else
				{
					$this->found_something = false;
					if ($query == null)
						{ $this->message = 'Вы не ввели слова для поиска!'; }
					else
						{ $this->message = 'Ничего не найдено!'; }
				}

			$this->sidebar = $this->loadSidebar(array('resentPosts','tagCloud','onlineUsers'));
		}

	public function executeCommentSearch(sfWebRequest $request)
		{
        	$this->getUser()->setLastVisit('search.comment');
			$query = $request->getParameter('query');

			if(($query != null) and $comment_query = Doctrine_Core::getTable('Answer')->getForLuceneQuery($query))
				{
					$search_params = sprintf('&query=%s',$query);

					$pager = new sfDoctrinePager('Answer', sfConfig::get('app_posts_on_index'));

					$sort_by = $request->getParameter('sort_by');
					$sort_type = $request->getParameter('sort_type');

					if(!($sort_by))   { $sort_by = 'created_at'; }
					if(!($sort_type)) { $sort_type = 'DESC'; }

					$query_and_links = AnswerTable::addSortQuery($comment_query,$sort_by,$sort_type);

					$sorts_for_links = $query_and_links['sorts_for_links'];

					$pager->setQuery($query_and_links['query']);
					$pager->setPage($request->getParameter('page', 1));
					$pager->init();
					$comment_list = $this->resultTextPreprocessing($pager->getResults()->getData(),$query);

				    $this->results = array('pager' => $pager,
								 	 'comment_list' => $comment_list,
								  	 'sorts_for_links' => $sorts_for_links,
									 'sort_by' => $sort_by,
									 'sort_type' => $sort_type,
									 'uri' => $this->generateUrl('comment_search',array()),
									 'search_params' => $search_params);

					$this->found_something = true;
				}
			else
				{
					$this->found_something = false;

					if ($query == null)
						{ $this->message = 'Вы не ввели слова для поиска!'; }
					else
						{ $this->message = 'Ничего не найдено!'; }
				}

			$this->sidebar = $this->loadSidebar($this->getStandartSidebar());
		}

	public function executeUserSearch(sfWebRequest $request)
		{
        	$this->getUser()->setLastVisit('search.user');
			$query = $request->getParameter('query');

			if(($query != null) and $user_query = Doctrine_Core::getTable('Profile')->getForLuceneQuery($query))
				{
					$search_params = sprintf('&query=%s',$query);

					$pager = new sfDoctrinePager('User', sfConfig::get('app_search_results'));

					$pager->setQuery($user_query);
					$pager->setPage($request->getParameter('page', 1));
					$pager->init();
					$user_list = $pager->getResults()->getData();

				    $this->results =  array('pager' => $pager,
											'comment_list' => $comment_list,
											'uri' => $this->generateUrl('comment_search',array()),
											'search_params' => $search_params);

					$this->found_something = true;
				}
			else
				{
					$this->found_something = false;

					if ($query == null)
						{ $this->message = 'Вы не ввели слова для поиска!'; }
					else
						{ $this->message = 'Ничего не найдено!'; }
				}

			$this->sidebar = $this->loadSidebar($this->getStandartSidebar());
		}
}
