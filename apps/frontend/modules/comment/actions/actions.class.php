<?php

class commentActions extends cnBaseActions
{
    public function executeNew(sfWebRequest $request)
        {
            $this->post_id = $request->getParameter('post_id');
            $this->comment_id = $request->getParameter('comment_id');

            $comment = new Answer();

            $comment->setPostId($this->post_id);
            $comment->setCommentId($this->comment_id);

            $this->form = new AnswerForm($comment);

            if($request->isXmlHttpRequest())
                { return $this->renderPartial('comment/form',array('form' => $this->form, 'post_id' => $this->post_id, 'comment_id' => $this->comment_id)); }

            $this->commented_text = Doctrine::getTable('Answer')->getAnswerText($this->comment_id);
        }

    public function executeCreate(sfWebRequest $request)
        {
            $this->forward404Unless($request->isMethod('post'));

            $comment = new Answer();
            $comment->setUserId($this->getUser()->getGuardUser()->getId());

            $this->form = new AnswerForm($comment);

            $this->form->bind($request->getParameter($this->form->getName()));
            if ($this->form->isValid())
            {
              $comment = $this->form->save();

              $this->redirect($this->generateUrl('post_show', array('id' => $comment['post_id'])).'#'.$comment->getId());
            }

            $this->post_id = $request->getParameter('post_id');
            $this->comment_id = $request->getParameter('comment_id');
            $this->commented_text = Doctrine::getTable('Answer')->getAnswerText($this->comment_id);

            $this->setTemplate('new');
        }
}
