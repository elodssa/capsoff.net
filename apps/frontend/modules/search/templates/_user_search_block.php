<div id="search">
	<span class="block_head">Найти юзера по имени или полям "Знаю", "Хочу знать":</span>
	<form action="<?php echo url_for('user_search') ?>" method="get">
		<input type="text" name="query" value="<?php echo $sf_request->getParameter('query') ?>" id="search_keywords" />
		<input type="submit" value="Поиск" />
	</form>
</div>

