<?php

class answerActions extends cnBaseActions
{
    public function executeNew(sfWebRequest $request)
        {
            $post_id = $request->getParameter('post_id');

            $this->post = Doctrine::getTable('Post')->getPostForShow($post_id);

            $answer = new Answer();
            $answer->setPostId($post_id);

            $this->form = new AnswerForm($answer);

            if($request->isXmlHttpRequest())
                { return $this->renderPartial('answer/form',array('form' => $this->form, 'post_id' => $post_id)); }
        }

    public function executeCreate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post'));

        $answer = new Answer();
        $answer->setUserId($this->getUser()->getGuardUser()->getId());
        $this->form = new AnswerForm($answer);

        $this->form->bind($request->getParameter($this->form->getName()));
        if ($this->form->isValid())
            {
              $answer = $this->form->save();

              $this->redirect($this->generateUrl('post_show', array('id' => $answer->getPostId())).'#'.$answer->getId());
            }

        $post_id = $request->getParameter('post_id');
        $this->post = Doctrine::getTable('Post')->getPostForShow($post_id);

        $this->setTemplate('new');
    }
}
