<?php slot('sidebar') ?>
	<?php include_partial('main/sidebar',array('sidebar' => $sidebar)); ?>
<?php end_slot(); ?>

<?php

	use_stylesheet('search.css');

	$name = $user_profile['fullname'] == NULL ? $user_profile['email'] : $user_profile['fullname'];

	slot('title','capsoff.net - Просмотр профиля пользователя ' . $name);
?>

<img src="<?php echo $user_profile['avatar'] == NULL ? '/images/none.png' : '/uploads/avatars/'.$user_profile['avatar'] ?>"><br>
Статус: <?php echo $user_profile['status'] ? 'На сайте' : 'Не на сайте' ?><br>
Имя: <?php echo $user_profile['fullname'] == NULL ? 'Не указано' : $user_profile['fullname'] ?><br>
E-mail: <?php echo htmlspecialchars($user_profile['email']) ?><br>
Пол:
<?php
	switch($user_profile['gender'])
		{
            case 'male':
            	echo 'Мужчина';
            	break;
            case 'female':
            	echo 'Женщина';
            	break;
            case 'undefined':
            	echo 'Неизвестный';
            	break;
		}
?><br>
Умею: <?php echo $user_profile['know'] ?><br>
Хочу научиться: <?php echo $user_profile['want_know'] ?><br>
Постов:    <?php echo $user_profile['posts'] ?><br>
Комментов: <?php echo $user_profile['comments'] ?><br>

<?php echo link_to('Посты пользователя','user_posts',array('id' => $user_profile['id'])) ?><br>
<?php echo link_to('Комменты пользователя','user_comments',array('id' => $user_profile['id'])) ?><br>

<?php
	if ($sf_user->isAuthenticated() && ($sf_user->getGuardUser()->getId() == $user_profile['user_id']))
		{
			echo link_to('Редактировать профиль','profile_edit',array('id' => $user_profile['id']));
		}
?>