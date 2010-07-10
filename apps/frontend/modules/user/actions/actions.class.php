<?php

class userActions extends cnBaseActions
{
	public function executeIndex(sfWebRequest $request)
		{
        	$this->getUser()->setLastVisit('user.index');
			$pager = new sfDoctrinePager('Profile', sfConfig::get('app_users_on_index'));
			$pager->setQuery(Doctrine::getTable('Profile')->getIndexUsers());
			$pager->setPage($request->getParameter('page', 1));
			$pager->init();
            $uri = $this->generateUrl('users');
            $this->user_list = array('uri' => $uri, 'pager' => $pager, 'user_list' => $pager->getResults()->getData());
			$this->sidebar = $this->loadSidebar(array('postSearch','resentPosts','tagCloud'));
		}

	public function executeShow(sfWebRequest $request)
		{
			$user_id = $request->getParameter('id');
			$this->user_profile = Doctrine::getTable('Profile')->getProfileForShow($user_id);

			$this->sidebar = $this->loadSidebar($this->getStandartSidebar());
		}

	public function executeEdit(sfWebRequest $request)
		{
			$this->profile = $this->getRoute()->getObject();

            if ($this->profile['user_id'] != $this->getUser()->getGuardUser()->getId())
				{ $this->redirect('homepage'); }
            else
            	{
                	$this->form = new ProfileEditForm($this->getRoute()->getObject());
            	}
		}

	public function executeUpdate(sfWebRequest $request)
		{
			$this->form = new ProfileEditForm($this->getRoute()->getObject());
			$user = $this->getUser()->getGuardUser();
			$this->profile = Doctrine::getTable('Profile')->createQuery('p.id')->where('user_id = ?',$user['id'])->fetchOne();

			$this->form->bind($request->getParameter($this->form->getName()),$request->getFiles($this->form->getName()));

			if ($this->form->isValid())
				{
					$profile = $this->form->save();

                    $this->getUser()->setName($profile['fullname'] == NULL ? $profile['email'] : $profile['fullname']);

                    $this->redirect($this->generateUrl('user_show', array('id' => $this->profile['id'])));
				}


			$this->setTemplate('edit');
		}

	public function executeAvatarDelete(sfWebRequest $request)
		{
			if($this->getUser()->isAuthenticated())
				{
					$referer = $request->getReferer();

					$user_id = $this->getUser()->getGuardUser()->getId();
					$profile = Doctrine::getTable('Profile')->findOneByUserId($user_id);
					$profile->setAvatar(NULL);
					$profile->save();

					$this->redirect($referer);
				}
			else $this->redirect($this->generateUrl('homepage'));
		}

	public function executeUserPosts(sfWebRequest $request)
		{
			$profile = $this->getRoute()->getObject();

			$post_query = Doctrine::getTable('Post')->getUserPost($profile['user_id']);

			$this->post_list =  array_merge($this->postPagerInit($request, $post_query),
													array('uri' => $this->generateUrl('user_posts',array('id' => $profile['id'])),
														  'user_id' => $profile['user_id'],
														  'category_show' => false));

            $this->username = $profile['fullname'];
			$this->sidebar = $this->loadSidebar($this->getStandartSidebar());
		}

	public function executeUserComments(sfWebRequest $request)
		{
			$profile = $this->getRoute()->getObject();

			$comment_query = Doctrine::getTable('Answer')->getUserComments($profile['user_id']);

			$pager= new sfDoctrinePager('Answer', sfConfig::get('app_posts_on_index'));

			$sort_by = $request->getParameter('sort_by');
			$sort_type = $request->getParameter('sort_type');

			if(!($sort_by))   { $sort_by = 'created_at'; }
			if(!($sort_type)) { $sort_type = 'DESC'; }

			$query_and_links = AnswerTable::addSortQuery($comment_query,$sort_by,$sort_type);

			$sorts_for_links = $query_and_links['sorts_for_links'];

			$pager->setQuery($query_and_links['query']);
			$pager->setPage($request->getParameter('page', 1));
			$pager->init();
			$comment_list = $pager->getResults()->getData();

			$this->comment_list = array('pager' => $pager,
										'comment_list' => $comment_list,
										'sorts_for_links' => $sorts_for_links,
										'sort_by' => $sort_by,
										'sort_type' => $sort_type,
										'uri' => $this->generateUrl('user_comments',array('id' => $profile['id'])));

            $this->username = $profile['fullname'];
			$this->sidebar = $this->loadSidebar($this->getStandartSidebar());
		}
}



