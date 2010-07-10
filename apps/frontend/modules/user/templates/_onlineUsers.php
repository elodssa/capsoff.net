<?php
	use_stylesheet('online_users.css');
	use_helper('Tag');

?>

<div id="online_users">
	<center class="block_head">Пользователи онлайн:</center>
	<ul>
		<?php
			foreach($online_users as $number => $user)
				{

					echo content_tag('span',link_to($user['Profile']['fullname'],'user_show',array('id' => $user['Profile']['id'])).' ');
				}
		?>
	</ul>
</div>
