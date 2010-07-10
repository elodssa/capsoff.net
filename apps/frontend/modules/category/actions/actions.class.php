<?php

class categoryActions extends cnBaseActions
{
  public function executeIndex(sfWebRequest $request)
  {
		$this->category_list = $this->getRoute()->getObjects();
        $this->getUser()->setLastVisit('category.index');
		$this->sidebar = $this->loadSidebar($this->getStandartSidebar());
  }

	public function executeShow(sfWebRequest $request)
	{
        $this->getUser()->setLastVisit('category.show');

		$this->max_text_length = sfConfig::get('app_max_post_text_length');

		$this->category = $this->getRoute()->getObject();

       	$post_query = $this->category->getCategoryPosts();

		$this->post_list =  array_merge($this->postPagerInit($request, $post_query),
												array('uri' => $this->generateUrl('category_show',array('id' => $this->category['id'])),
													  'category_show' => true));

		$this->sidebar = $this->loadSidebar($this->getStandartSidebar());
	}
}
