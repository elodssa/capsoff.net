<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new CapsoffTestFunctional(new sfBrowser());
$browser->loadData();

$browser->info('Главная страница')->
  get('/')->
  info('Проверка модуля, действия, кода')->
  with('request')->begin()->
    isParameter('module', 'post')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '!/This is a temporary page/')->
  end();

$max_on_homepage = sfConfig::get('app_posts_on_index');
$max_on_category = sfConfig::get('app_posts_on_category');
$max_on_tag = sfConfig::get('app_posts_on_tag');

$q = Doctrine_Query::create()
  ->select('p.*')
  ->from('Post p')
  ->orderBy('p.updated_at DESC');

$post = $q->fetchOne();


$category = Doctrine::getTable('Category')->findOneByName('Web');
$category_posts = $category->getPosts();


$tag = Doctrine::getTable('Tag')->findOneByName('tag1');
$tag_posts = $tag->getPosts();

$browser->info('1. Отображение постов на разных страницах');

$browser->info('1.1 - Главная страница')->
  get('/')->

  info('1.1.1 - Каждый пост на главной странице кликабельный')->
  click($post->getTitle(), array(), array('position' => 1))->
  with('request')->begin()->
    isParameter('module', 'post')->
    isParameter('action', 'show')->
    isParameter('post_id', $post->getId())->
  end()->

  get('/')->
  info(sprintf('1.1.2 - Только %s постов отображаются на главной странице', $max_on_homepage))->
  with('response')->
    checkElement('.post_preview', $max_on_homepage);

$browser->info('1.2 - Страница постов рубрики')->
  get('/categories')->
  click('Web')->
  info('1.1 - Каждый пост на странице постов рубрики кликабельный')->
  click($category_posts[0]->getTitle(), array(), array('position' => 1))->
  with('request')->begin()->
    isParameter('module', 'post')->
    isParameter('action', 'show')->
    isParameter('post_id', $category_posts[0]->getId())->
  end()->
  get('/categories')->
  click('Web')->
  info(sprintf('1.1.2 - Только %s постов отображаются на странице постов рубрики', $max_on_category))->
  with('response')->
    checkElement('.post_preview', $max_on_category);

$browser->info('1.2 - Страница постов тега')->
  get('/tags')->
  click('tag1')->
  info('1.1 - Каждый пост на странице постов тега кликабельный')->
  click($tag_posts[0]->getTitle(), array(), array('position' => 1))->
  with('request')->begin()->
    isParameter('module', 'post')->
    isParameter('action', 'show')->
    isParameter('post_id', $tag_posts[0]->getId())->
  end()->
  get('/tags')->
  click('tag1')->
  info(sprintf('1.1.2 - Только %s постов отображаются на странице постов тега', $max_on_tag))->
  with('response')->
    checkElement('.post_preview', $max_on_tag)->

  info('2.2 - Несуществующие посты отправляют на страницу 404')->
  get('/post/0')->
  with('response')->isStatusCode(404);