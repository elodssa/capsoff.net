<?php

require_once dirname(__FILE__).'/../../../bootstrap/Doctrine.php';

$t = new lime_test(13);

$t->comment('----функция fetchTagArray преобразует перечисленные через запятую теги в массив----');

$test_post = new Post();

$tag_string = 'tag1,tag2,tag3,tag4';
$expect_array = array('0' => 'tag1','1' => 'tag2', '2' => 'tag3', '3' => 'tag4');
$t->is($test_post->fetchTagArray($tag_string),$expect_array, ':функция fetchTagArray - строка " tag1,tag2,tag3,tag4"');

$tag_string = ' tag1,tag2,tag3,tag4';
$expect_array = array('0' => 'tag1','1' => 'tag2', '2' => 'tag3', '3' => 'tag4');
$t->is($test_post->fetchTagArray($tag_string),$expect_array, ':функция fetchTagArray - строка " tag1,tag2,tag3,tag4"');

$tag_string = ' tag1,tag2,tag3,tag4 ';
$expect_array = array('0' => 'tag1','1' => 'tag2', '2' => 'tag3', '3' => 'tag4');
$t->is($test_post->fetchTagArray($tag_string),$expect_array, ':функция fetchTagArray - строка " tag1,tag2,tag3,tag4 "');

$tag_string = ' tag1, tag2, tag3, tag4 ';
$expect_array = array('0' => 'tag1','1' => 'tag2', '2' => 'tag3', '3' => 'tag4');
$t->is($test_post->fetchTagArray($tag_string),$expect_array, ':функция fetchTagArray - строка " tag1, tag2, tag3, tag4 "');

$tag_string = ' tag1 ,tag2 ,tag3 ,tag4 ';
$expect_array = array('0' => 'tag1','1' => 'tag2', '2' => 'tag3', '3' => 'tag4');
$t->is($test_post->fetchTagArray($tag_string),$expect_array, ':функция fetchTagArray - строка " tag1 ,tag2 ,tag3 ,tag4 "');

$tag_string = ' tag1 ,tag2 ,tag3 ,tag4 ';
$expect_array = array('0' => 'tag1','1' => 'tag2', '2' => 'tag3', '3' => 'tag4');
$t->is($test_post->fetchTagArray($tag_string),$expect_array, ':функция fetchTagArray - строка " tag1 , tag2 , tag3 , tag4 "');

$tag_string = ' tag1 ,tag2 ,tag3 ,tag4 ';
$expect_array = array('0' => 'tag1','1' => 'tag2', '2' => 'tag3', '3' => 'tag4');
$t->is($test_post->fetchTagArray($tag_string),$expect_array, ':функция fetchTagArray - строка " tag1 , tag2, tag3, tag4"');

$tag_string = 'TAG1,TAG2,TAG3,TAG4';
$expect_array = array('0' => 'tag1','1' => 'tag2', '2' => 'tag3', '3' => 'tag4');
$t->is($test_post->fetchTagArray($tag_string),$expect_array, ':функция fetchTagArray - строка "TAG1,TAG2,TAG3,TAG4"');

$tag_string = ' tag1 ,, ,tag2 ';
$expect_array = array('0' => 'tag1','1' => 'tag2');
$t->is($test_post->fetchTagArray($tag_string),$expect_array, ':функция fetchTagArray - строка " tag1 ,, ,tag2 "');

$tag_string = ' tag1 ,tag2 ,tag3 ,tag4 , tag4, tag1, tag3';
$expect_array = array('0' => 'tag1','1' => 'tag2', '2' => 'tag3', '3' => 'tag4');
$t->is($test_post->fetchTagArray($tag_string),$expect_array, ':функция fetchTagArray - строка " tag1 ,tag2 ,tag3 ,tag4 , tag4, tag1, tag3"');


$t->comment('----функция generateTitle если пользователь не написал тайтл поста он автоматически генерируется из текста поста----');

$post_text = str_repeat('1',sfConfig::get('app_max_post_title_length') - 10).'.'.str_repeat('1',50).'.';

$t->is($test_post->generateTitle($post_text),str_repeat('1',sfConfig::get('app_max_post_title_length') - 10),
	   'Первое предложение короче максимальной длины тайтла и длинее минимальной');


$post_text = str_repeat('1',sfConfig::get('app_max_post_title_length') + 10).'.'.str_repeat('1',50).'.';

$t->is($test_post->generateTitle($post_text),str_repeat('1',sfConfig::get('app_min_post_title_length')),
	   'Первое предложение длинее максимальной длины тайтла');


$post_text = str_repeat('1',sfConfig::get('app_min_post_title_length') - 2).'.'.str_repeat('1',50).'.';

$t->is($test_post->generateTitle($post_text),str_repeat('1',sfConfig::get('app_min_post_title_length') - 2).'.1',
	   'Первое предложение короче минимальной длины тайтла');


