<?php slot('sidebar') ?>
	<?php include_partial('main/sidebar',array('sidebar' => $sidebar)); ?>
<?php end_slot(); ?>

<?php
	slot('title','capsoff.net - Рубрики');
	slot('categories', 'shown');
	use_stylesheet('categories.css');
	use_stylesheet('search.css');
?>

<table cellspacing="50" align="center" valign="top">
	<tr valign="top">
		<?php foreach ($category_list as $category): ?>
			<td align="center">
				<?php echo link_to("<img src='/images/$category[cover]' align='middle'>", 'category_show', array('id' => $category['id'])) ?>
				<br>
				<?php echo link_to($category['name'], 'category_show', array('id' => $category['id'])) ?>
			</td>
		<?php endforeach; ?>
	</tr>
</table>

