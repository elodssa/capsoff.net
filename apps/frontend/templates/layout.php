<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <title>
		<?php if(!include_slot('title')): ?>
			capsoff.net - Задай вопрос, получи ответ
		<?php endif; ?>
    </title>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
  </head>

<body>

<div id="top">
	<div id="logo">
		<img border="1" alt="logo" width="50" height="50">
	</div>
</div>
	<a name="top"></a>
	<div id="head">
		<div id="head_menu">
			<ul>
                <li class="<?php include_slot('homepage')?>">
					<?php echo link_to('посты','homepage'); ?>
					<ul id="sub_menu">
						<li>
							<?php include_slot('sub_menu') ?>
						</li>
					</ul>
				</li>
				<li class="<?php include_slot('categories') ?>"><?php echo link_to('рубрики','categories');  ?></li>
                <li class="<?php include_slot('tags') ?>"><?php echo link_to('теги','tags'); ?></li>
				<li class="<?php include_slot('users') ?>"><?php echo link_to('участники','users')	?></li>
				<li class="<?php include_slot('search') ?>"><?php echo link_to('поиск','all_search') ?></li>
				<li class="<?php include_slot('new_post') ?>">
					<span class='new_post'>
						<?php if($sf_user->isAuthenticated()): ?>
                            <a href="<?php echo url_for('post_new'); include_slot('new_post_category')?>">
                                написать пост
                            </a>
						<?php endif; ?>
					</span>
				</li>
			</ul>
		</div>

		<div id="authorising">
			<?php if($sf_user->isAuthenticated()): ?>
				<?php
					echo '<b>'.$sf_user->getName().'</b>';
					echo '<br>';
					echo link_to('Мой профиль','user_show',array('id' => $sf_user->getGuardUser()->getId()));
					echo '<br>';
					echo link_to('Выход','sf_guard_signout');
				?>
			<?php else: ?>
				<?php include_slot('signin_form') ?>
			<?php endif; ?>
		</div>
	</div>

	<div id="wrapper">
		<div id="main_block">
			<?php echo $sf_content ?>
		</div>

		<div id="sidebar">
			<?php include_slot('sidebar'); ?>
		</div>

	</div>

		<div id="top_link"><a href="#top">Наверх ↑</a></div>
		<div id="footer">
			ИжГТУ 2010 год
		</div>
	<?php include_javascripts() ?>
</body>
</html>
