<div class="sorts">
	Сортировать по:
	<?php
        if($sf_request->getParameter('page'))
        	{ $uri = sprintf('%s?page=1s&',$uri); }
        else
        	{ $uri = sprintf('%s?',$uri); }

		$i = 1; foreach($sorts_for_links as $name => $sorting):
	?>
		<span>
			<?php
				if (($name == $sort_by) || (($sort_by == null) and ($name == 'created_at')))
					{$is_now_sort = true;}
				else
					{$is_now_sort = false;}
				$url = $uri . 'sort_by=' . $name. '&sort_type=' . $sorting['type'] . $search_params;
				echo content_tag('a',$sorting['header'], array('href' => $url, 'class' => $is_now_sort ? 'now_sort' : 'non_now_sort'));

				if ($is_now_sort)
					echo ' ' . tag('img',array(
										'src' => $sorting['type'] == 'DESC' ? '/images/asc_sort.png' : '/images/desc_sort.png',
										'valign' => 'middle'
										));

				if ($i != count($sorts_for_links)) { echo ' | '; }; $i = ++$i;
			?>
		</span>
	<?php endforeach; ?>
</div>
