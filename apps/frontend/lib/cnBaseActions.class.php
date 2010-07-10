<?php

class cnBaseActions extends sfActions
{
	static public $standart_sidebar = array('postSearch','resentPosts','tagCloud','onlineUsers');

	public function getStandartSidebar()
		{
			return self::$standart_sidebar;
		}

	public function getUserId()
		{
			$user = sfContext::getInstance()->getUser();
			if ($user and $user->isAuthenticated())
				{
					$user = $user->getGuardUser();
					$user_id = $user->getId();
				}
			else
				{
					$user_id = null;
				}

			return $user_id;
		}

	public function postPagerInit(sfWebRequest $request, Doctrine_Query $post_query)
		{
            $max_text_length = sfConfig::get('app_max_post_text_length');

			$pager= new sfDoctrinePager('Post', sfConfig::get('app_posts_on_index'));

			$sort_by   = $request->getParameter('sort_by');
			$sort_type = $request->getParameter('sort_type');

			if(!($sort_by))   { $sort_by   = 'created_at'; }
			if(!($sort_type)) { $sort_type = 'DESC'; }

			$query_and_links = PostTable::addSortQuery($post_query,$sort_by,$sort_type);

			$sorts_for_links = $query_and_links['sorts_for_links'];

			$pager->setQuery($query_and_links['query']);
			$pager->setPage($request->getParameter('page', 1));
			$pager->init();
			$post_list = $pager->getResults();

			return array('pager'           => $pager,
						 'post_list'       => $post_list,
						 'sorts_for_links' => $sorts_for_links,
						 'sort_by'         => $sort_by,
						 'sort_type'       => $sort_type,
						 'max_text_length' => $max_text_length);
		}

	public function loadSidebar($blocks = null)
		{
			$sidebar = array();

        	if (!is_null($blocks))
        		{
                	foreach ($blocks as $sidebar_block)
                		{
                			try
                				{
									$sidebar[] = call_user_func(array($this,sprintf('%sBlockLoad',$sidebar_block)));
								}
							catch (Exception $e)
								{
									$sidebar = null;
									throw $e;
								}
                		}
        		}

			if(!$this->getUser()->isAuthenticated())
                {
                    $sidebar[] = $this->signinFormBlockLoad();
                }

        	return $sidebar;
		}

	private function resentPostsBlockLoad()
		{
        	$resent_posts = Doctrine::getTable('Post')->getResentPosts();

        	$partial = 'post/resent_posts';
        	$parameters = array('resent_posts' => $resent_posts);

        	return array('partial' => $partial, 'parameters' => $parameters);
		}

	private function tagCloudBlockLoad()
		{
        	$tag_list = Doctrine::getTable('Tag')->getCloudTags();

        	$partial = 'tag/tagCloud';
        	$parameters = array('tag_list' => $tag_list);

        	return array('partial' => $partial, 'parameters' => $parameters);
		}

	private function onlineUsersBlockLoad()
		{
        	$online_users = Doctrine::getTable('OnlineUser')->getOnlineUsers();

        	$partial = 'user/onlineUsers';
        	$parameters = array('online_users' => $online_users);

        	return array('partial' => $partial, 'parameters' => $parameters);
		}

	private function postSearchBlockLoad()
		{
        	$partial = 'search/post_search_block';
        	$parameters = array();

        	return array('partial' => $partial, 'parameters' => $parameters);
		}

	private function signinFormBlockLoad()
		{
			$class = sfConfig::get('app_sf_guard_plugin_signin_form', 'sfGuardFormSignin');
			$signin_form = new $class();
			$partial = 'main/signin_form';
			$parameters = array('form' => $signin_form);

			return array('partial' => $partial, 'parameters' => $parameters);
		}
}
