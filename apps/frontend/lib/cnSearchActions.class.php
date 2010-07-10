<?php

class cnSearchActions extends cnBaseActions
{
	public function resultTextPreprocessing($results = null,$query = null)

		{
			$query_array = str_replace(array(',','.',':',';'),' ',$query);
			$query_array = explode(' ',$query);

			$query_array = array_unique($query_array);

			$replace = array();
			foreach ($query_array as $string) { $replace[] = '<span class="query">' . $string . '</span>'; }

			foreach ($results as $i => $record)
				{ $results[$i]['text'] = (str_replace($query_array, $replace,$record['text'])); }

			return $results;
		}
}