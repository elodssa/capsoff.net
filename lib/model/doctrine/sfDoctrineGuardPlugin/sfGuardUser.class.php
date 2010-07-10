<?php

/**
 * sfGuardUser
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    forum
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class sfGuardUser extends PluginsfGuardUser
{
	public function getNickname()
		{
			if ($this->isAuthenticated())
			{
				$q = Doctrine::getTable('Profile')->
							createQuery('p.nickname')->
							where('p.user_id = ?',$this->getId())->
							fetchOne();
				return $q;
        	}
		}

	public function getProfile()
		{
        	$profile = Doctrine::getTable('Profile')->findOneByUserId($this->getId());

        	return $profile;
		}
}
