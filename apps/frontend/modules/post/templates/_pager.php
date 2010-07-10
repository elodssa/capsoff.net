<div class="pager">
	<?php
		if($pager->haveToPaginate())
			{
				if (($sort_by != null) and ($sort_type != null))
					{
                        $sort_string = '&sort_by='. $sort_by .'&sort_type=' . $sort_type;
					}
				else
					{
						$sort_string =  "";
					}

				$uri = sprintf('%s?page=',$uri);

                echo '<div>';
				$img = tag('img',array('alt' => '|<','src' => '/images/first.png', 'valign' => 'bottom'));
				echo content_tag('a',$img,array('href' => $uri.$pager->getFirstPage().$sort_string.$search_params)).' ';

				$img = tag('img',array('alt' => '<<','src' => '/images/previous.png', 'valign' => 'bottom'));
				echo content_tag('a',$img,array('href' => $uri.$pager->getPreviousPage().$sort_string.$search_params)).' ';
                echo '</div>';

                echo '<div class="pages">';
				foreach ($pager->getLinks() as $page)
					if ($page == $pager->getPage())
						echo content_tag('span',$page,array('style' => "font-size:14px; color:red; font-weigth:bold;")).' ';
					else
						echo content_tag('a',$page,array('href' => $uri.$page.$sort_string.$search_params)).' ';
				echo '</div>';

				echo '<div>';
				$img = tag('img',array('alt' => '>>','src' => '/images/next.png', 'valign' => 'bottom'));
				echo content_tag('a',$img,array('href' => $uri.$pager->getNextPage().$sort_string.$search_params)).' ';

				$img = tag('img',array('alt' => '>|','src' => '/images/last.png', 'valign' => 'bottom'));
				echo content_tag('a',$img,array('href' => $uri.$pager->getLastPage().$sort_string.$search_params)).' ';
				echo '</div>';
			}
	 else echo content_tag('span','1',array('style' => "font-size:14px; color:red; font-weigth:bottom;"));
	?>
</div>