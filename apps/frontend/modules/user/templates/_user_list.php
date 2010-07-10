<?php
	if (!isset($search_params)) { $search_params = ''; }

	include_partial('post/pager', array('uri' => $uri, 'pager' => $pager, 'sort_by' => '', 'sort_type' => ''));

	foreach ($user_list as $user)
		{
			echo '<b>'.link_to($user['fullname'],'user_show',$user).'</b>';
			if($user['online'])
				{ echo ': На сайте'; }
			else
				{ echo ': Не на сайте'; }

			echo '<br>';
			echo 'Знаю: ', $user['know'], ' ';
			echo 'Хочу знать', $user['want_know'], '<br><br>';
		}

	include_partial('post/pager', array('uri' => $uri, 'pager' => $pager, 'sort_by' => '', 'sort_type' => ''));
?>