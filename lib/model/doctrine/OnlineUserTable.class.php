<?php


class OnlineUserTable extends Doctrine_Table
{

    public static function getInstance()
    {
        return Doctrine_Core::getTable('OnlineUser');
    }

    public function getOnlineUsers()
    	{
        	$online_users = $this->createQuery('u')
        	                      ->select('u.user_id, p.id, p.fullname')
        	                      ->from('OnlineUser u')
								  ->leftJoin('u.Profile p')
								  ->limit(sfConfig::get('app_online_users_on_block'))
								  ->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

			$online_users_list = $online_users->execute();
			$online_users->free();

			return $online_users_list;
    	}

	private function isUserOnline($user_id = null)
		{
            $q = Doctrine_Query::create()
							->select('u.user_id')
							->from('OnlineUser u')
							->where('u.user_id = ?',$user_id);

        	return  $q;
		}

	public function addOnlineUser($user_id = null)
		{
			$online_user = $this->isUserOnline($user_id)->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

            $is_user_online = $online_user->execute();
            $online_user->free();

			if (count($is_user_online) == 0)
				{
					$online_user = new OnlineUser();
					$online_user->user_id = $user_id;
					$online_user->save();
				}
		}

	public function removeOnlineUser($user_id = null)
		{
			$online_user = $this->isUserOnline($user_id)->setHydrationMode(Doctrine_Core::HYDRATE_RECORD);
			$is_user_online = $online_user->execute();
            $online_user->free();

			if ($is_user_online[0]['user_id'] == $user_id) { $is_user_online[0]->delete(); }
		}
}