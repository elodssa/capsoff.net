<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>

<body>
		<!-- Ссылки  -->
		<?php if($sf_user->isAuthenticated()): ?>
			<div class="head" style="margin-bottom:0px">
                <?php
					echo link_to('Посты','post_post').' - ';
					echo link_to('Рубрики','category_category').' - ';
					echo link_to('Юзеры', '@sf_guard_user').' - ';
				?>
				<a href="/frontend_dev.php">Фронтенд</a>
			</div>
			<div class="head" style="width: 50px"><?php echo link_to('Выход', '@sf_guard_signout') ?></div>
		<?php endif; ?>

        <!-- Контент  -->
		<?php echo $sf_content ?>

		<!-- Нижняя часть страницы -->
		<div class="footer">
			ИжГТУ 2009 год
		</div>
</body>
</html>
