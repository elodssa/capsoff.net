<?php

require_once(sfConfig::get('sf_plugins_dir').'/sfDoctrineApplyPlugin/modules/sfApply/lib/BasesfApplyActions.class.php');

class sfApplyActions extends BasesfApplyActions
{
  public function executeApply(sfRequest $request)
  {
	$this->form = $this->newForm('sfApplyApplyForm');
	if ($request->isMethod('post'))
		{
			$this->form->bind($request->getParameter('sfApplyApply'), $request->getFiles($this->form->getName(), array('captcha'   => $request->getParameter('captcha'))));
			if ($this->form->isValid())
			{
				$guid = "n" . self::createGuid();
				$this->form->setValidate($guid);
				$this->form->save();
				$user_group = new sfGuardUserGroup();
				$user_group->setUserId($this->form->getObject()->getUserId());
				$user_group->setGroupId(2);
				try
					{
						$profile = $this->form->getObject();
						$this->mail(array('subject' => sfConfig::get('app_sfApplyPlugin_apply_subject',
							sfContext::getInstance()->getI18N()->__("Пожалуйста, подтвердите регистрацию на %1%", array('%1%' => $this->getRequest()->getHost()))),
						'email' => $profile->getEmail(),
						'parameters' => array('fullname' => $profile->getFullname(), 'validate' => $profile->getValidate()),
						'text' => 'sfApply/sendValidateNewText',
						'html' => 'sfApply/sendValidateNew'));
						return 'After';
					}
				catch (Exception $e)
					{
						//$mailer->disconnect();
						$profile = $this->form->getObject();
						$user = Doctrine::getTable('sfGuardUser')->findOneById($profile['user_id']);
						$user->delete();
						$profile->delete();
						// You could re-throw $e here if you want to
						// make it available for debugging purposes
						throw new sfException($e);
						return 'MailerError';
					}
			}
		}

	$this->sidebar = null;
  }

  protected function mail($options) {
    $required = array('subject', 'parameters', 'email', 'html', 'text');
    foreach ($required as $option)
    {
      if (!isset($options[$option]))
      {
        throw new sfException("Required option $option not supplied to sfApply::mail");
      }
    }
    $message = $this->getMailer()->compose();
    $message->setSubject($options['subject']);

    // Render message parts
    $message->setBody($this->getPartial($options['html'], $options['parameters']), 'text/html');
    $message->addPart($this->getPartial($options['text'], $options['parameters']), 'text/plain');
    $address = $this->getFromAddress();
    $message->setFrom(array($address['email'] => $address['fullname']));
    $message->setTo(array($options['email'] => $options['email']));
    $this->getMailer()->send($message);
  }

  static private function createGuid()
  {
    $guid = "";
    // This was 16 before, which produced a string twice as
    // long as desired. I could change the schema instead
    // to accommodate a validation code twice as big, but
    // that is completely unnecessary and would break
    // the code of anyone upgrading from the 1.0 version.
    // Ridiculously unpasteable validation URLs are a
    // pet peeve of mine anyway.
    for ($i = 0; ($i < 8); $i++) {
      $guid .= sprintf("%02x", mt_rand(0, 255));
    }
    return $guid;
  }

  static private function getValidationType($validate)
  {
    $t = substr($validate, 0, 1);
    if ($t == 'n')
    {
      return 'New';
    }
    elseif ($t == 'r')
    {
      return 'Reset';
    }
    else
    {
      return sfView::NONE;
    }
  }

  public function executeConfirm(sfRequest $request)
  {
    $validate = $this->request->getParameter('validate');
    // 0.6.3: oops, this was in sfGuardUserProfilePeer in my application
    // and therefore never got shipped with the plugin until I built
    // a second site and spotted it!

    // Note that this only works if you set foreignAlias and
    // foreignType correctly
    $sfGuardUserProfile = Doctrine_Query::create()->
      from('Profile p')->
      where('p.validate = ?',$validate)->
      fetchOne();

    $sfGuardUser = Doctrine_Query::create()->
      from('sfGuardUser u')->
      where('u.id = ?',$sfGuardUserProfile->getUserId())->
      fetchOne();

    if (!$sfGuardUser)
    {
      return 'Invalid';
    }
    $type = self::getValidationType($validate);
    if (!strlen($validate))
    {
      return 'Invalid';
    }
    $sfGuardUserProfile;
    $sfGuardUserProfile->setValidate(null);
    $sfGuardUserProfile->save();
    if ($type == 'New')
    {
      $sfGuardUser->setIsActive(true);
      $sfGuardUser->save();
      $this->getUser()->signIn($sfGuardUser);
    }
    if ($type == 'Reset')
    {
      $this->getUser()->setAttribute('sfApplyReset', $sfGuardUser->getId());
      return $this->redirect('sfApply/reset');
    }
  }

  public function executeResetRequest(sfRequest $request)
  {
    $user = $this->getUser();
    if ($user->isAuthenticated())
    {
      $guardUser = $this->getUser()->getGuardUser();
      $this->forward404Unless($guardUser);
      return $this->resetRequestBody($guardUser);
    }
    else
    {
      $this->form = $this->newForm('sfApplyResetRequestForm');
      if ($request->isMethod('post'))
      {
        $this->form->bind($request->getParameter('sfApplyResetRequest'));
        if ($this->form->isValid())
        {
          // The form matches unverified users, but retrieveByUsername does not, so
          // use an explicit query. We'll special-case the unverified users in
          // resetRequestBody

          $username_or_email = $this->form->getValue('username_or_email');
          if (strpos($username_or_email, '@') !== false)
          {
            $user = Doctrine::getTable('sfGuardUser')->createQuery('u')
													 ->innerJoin('u.UserProfile p')
													 ->where('p.email = ?', $username_or_email)
													 ->fetchOne();
          }
          else
          {
            $user = Doctrine::getTable('sfGuardUser')->createQuery('u')->where('username = ?', $username_or_email)->fetchOne();
          }
          return $this->resetRequestBody($user);
        }
      }
    }
  }
}
