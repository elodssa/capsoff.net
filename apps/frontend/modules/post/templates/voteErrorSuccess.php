<?php
	use_helper('Tag');
	echo 'Вы уже ставили оценку этому посту!';
	echo tag('br');
	echo  content_tag('a','Назад',array('href' => $sf_request->getReferer()));
?>
