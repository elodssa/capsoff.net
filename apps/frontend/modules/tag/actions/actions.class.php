<?php

class tagActions extends cnBaseActions
{
	public function executeIndex(sfWebRequest $request)
	{
        $this->getUser()->setLastVisit('tag.index');

		$this->tag_list = Doctrine::getTable('Tag')->getIndexTags();

		$this->main_block_varibles =  array('tag_list' => $this->tag_list);

		$this->sidebar = $this->loadSidebar(array('postSearch','resentPosts','onlineUsers'));
	}

	public function executeShow(sfWebRequest $request)
	{
        $this->getUser()->setLastVisit('tag.show');
		$this->user_id = $this->getUser()->getUserId();

		$this->tag = $this->getRoute()->getObject();
		$this->tag->setViews($this->tag->views + 1);
		$this->tag->save();

		$post_query = $this->tag->getTagPosts();

		$this->post_list =  array_merge($this->postPagerInit($request, $post_query),
												  array('uri' => $this->generateUrl('tag_show',$this->tag),
														'user_id' => $this->user_id,
														'category_show' => false,));

		$this->sidebar = $this->loadSidebar($this->getStandartSidebar());
	}
}
