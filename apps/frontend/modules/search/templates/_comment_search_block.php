<div id="search">
	<span class="block_head">Найти в комментах:</span>
	<form action="<?php echo url_for('comment_search') ?>" method="get">
		<input type="text" name="query" value="<?php echo $sf_request->getParameter('query') ?>" id="search_keywords" />
		<input type="submit" value="Поиск" />
		<div id="results_type">
		</div>
	</form>
</div>

