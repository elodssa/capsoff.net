<?php slot('sidebar') ?>
	<?php include_partial('main/sidebar',array('sidebar' => $sidebar)); ?>
<?php end_slot(); ?>

<?php
	slot('title','capsoff.net - Список тегов');
	slot('tags','shown');
	use_stylesheet('search.css');
?>

<?php foreach ($tag_list as $tag): ?>
		<?php echo link_to($tag['name'],'tag_show',array('id' => $tag['id']),array('title' => sprintf('%s просмотров',$tag['views']))); ?>
        (<?php echo $tag['posts'] ?> постов)
		<br>
<?php endforeach; ?>
