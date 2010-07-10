<?php

class postActions extends cnBaseActions
{
	public function executeIndex(sfWebRequest $request)
	{
        $this->getUser()->setLastVisit('post.index');

		$post_query = Doctrine::getTable('Post')->getIndexPosts();

		$this->post_list =  array_merge($this->postPagerInit($request, $post_query),
										array('uri' => $this->generateUrl('homepage'),
											  'category_show' => false));

		$this->sidebar = $this->loadSidebar($this->getStandartSidebar());
	}

	public function executeShow(sfWebRequest $request)
	{
		$post_id =  $this->request->getParameter('id');

        $post = Doctrine::getTable('Post')->getPostForTest($post_id);

		$this->forward404Unless($post);

		if (!in_array($this->getUser()->getLastVisit(),array('post.show.' . $post_id,
															 'post.create.' . $post_id,
															 'post.answer.' . $post_id)))
				{ $post->increaseViews(); }

        $this->post = Doctrine::getTable('Post')->getPostForShow($post_id);

		$this->getUser()->setLastVisit('post.show.'.$post_id);

		$this->comment_tree = $this->post->getPostComments();

		$this->sidebar = $this->loadSidebar($this->getStandartSidebar());
	}

	public function executeNew(sfWebRequest $request)
	{
        $post = new Post();

		if (($this->category = $request->getParameter('category')) != NULL)
			{
            	$this->category = Doctrine::getTable('Category')->findOneByName($this->category);

            	if ($this->category != NULL)
                    { $post->setCategory($this->category); }
			}

		$this->form = new PostForm($post);
		$this->sidebar = array();
	}

    public function executeCreate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post'));

        $post = new Post();
        $user_id = $this->getUser()->getUserId();
        $post->setUserId($user_id);

        $this->form = new PostForm($post);

        $this->form->bind($request->getParameter($this->form->getName()));
        if ($this->form->isValid())
            {
                $post = $this->form->save();
                $post->saveTags($this->form->getValue('tags'));
                $this->getUser()->setLastVisit(sprintf('post.create.%s',$post['id']));

                $this->redirect($this->generateUrl('post_show', array('id' => $post['id'])));
            }

        $this->setTemplate('new');
        $this->sidebar = array();
    }

	public function executeVotePlus(sfWebRequest $request)
    {

            for ($i = 0; $i <= 1000000;++$i) {}

        $user_id = $this->getUser()->getUserId();

        $post = $this->getRoute()->getObject();

        $result = $post->increaseVotes($user_id);

        if ($request->isXmlHttpRequest())
            {
                if ($result)     return $this->renderText('{"result":true,"votes":' . $post['votes'] . '}');
                    else         return $this->renderText('{"result":false}');
            }

        $referer = $request->getReferer();

        if ($result) $this->redirect($referer == '' ? $this->generateUrl('homepage') : $referer);
        else         $this->redirect($this->generateUrl('post_vote_error'));
    }

    public function executeVoteMinus(sfWebRequest $request)
        {
            $user_id = $this->getUser()->getUserId();

            $post = $this->getRoute()->getObject();

            $result = $post->decreaseVotes($user_id);

            if ($request->isXmlHttpRequest())
                {
                    if ($result) return $this->renderText($post->votes);
                    else         return $this->renderText('false');
                }

            $referer = $request->getReferer();

            if ($result) $this->redirect($referer == '' ? $this->generateUrl('homepage') : $referer);
            else         $this->redirect($this->generateUrl('post_vote_error'));
        }


    public function executeVoteError(sfWebRequest $request) {}
}
