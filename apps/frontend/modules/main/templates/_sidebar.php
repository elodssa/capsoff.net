<?php
	foreach($sidebar as $block)
		{
            include_partial($block['partial'],$block['parameters']);
		}
?>


