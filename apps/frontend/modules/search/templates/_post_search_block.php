<?php use_stylesheet('search.css'); ?>

<div id="search">
	<span class="block_head">Найти в постах:</span>
	<form action="<?php echo url_for('post_search'); ?>" method="get">
		<input type="text" name="query" value="<?php echo $sf_request->getParameter('query') ?>" id="search_keywords" />
		<input type="submit" value="Поиск" />
	</form>
</div>

