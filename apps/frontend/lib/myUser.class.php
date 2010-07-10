<?php

class myUser extends sfGuardSecurityUser
{
	public function signIn($user, $remember = false, $con = null)
		{
        	$profile = Doctrine_Query::create()->select('p.fullname')->from('Profile p')->where('p.user_id = ?',$user['id'])->fetchOne();

        	$this->setName($profile['fullname']);

			$online_user = Doctrine::getTable('OnlineUser')->addOnlineUser($user['id']);

        	parent::signIn($user, $remember, $con);
		}

	public function signOut()
		{
			$this->getAttributeHolder()->remove('name');
			$user_id = $this->getGuardUser()->getId();
            Doctrine::getTable('OnlineUser')->removeOnlineUser($user_id);
			$this->removeLastVisit();

			parent::signOut();
		}

	public function setName($name = null)
		{
        	$this->setAttribute('name', $name);
		}

	public function getName()
		{
        	$name = $this->getAttribute('name');

        	if ($name != null)
        		{
                	return htmlspecialchars($name);
        		}
        	else
        		{ return null; }
		}
	public function setLastVisit($place = null)
		{
        	$this->setAttribute('last_visit',$place);
		}

	public function getLastVisit()
		{
			return $this->getAttribute('last_visit');
		}

	public function removeLastVisit()
		{
        	$this->getAttributeHolder()->remove('last_visit');
		}

	public function getUserId()
		{
			return $this->getAttribute('user_id', null, 'sfGuardSecurityUser');
		}
}
