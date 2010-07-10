<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new CapsoffTestFunctional(new sfBrowser());
$browser->loadData();

$browser->info('1. Страница списка рубрик')->
  get('/categories')->
  info(' 1.1 - Проверка модуля, действия, кода')->
  with('request')->begin()->
    isParameter('module', 'category')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '!/This is a temporary page/')->
  end();

$max = sfConfig::get('app_posts_on_index');

$q = Doctrine_Query::create()->select('c.*')->from('Category c');

$category = $q->fetchOne();

$posts_on_category = sfConfig::get('app_posts_on_category');

$browser->info('2 - Страница постов рубрики')->
  get('/categories')->
  info(' 2.1 - Каждая рубрика кликабельна')->
  click($post->getName, array(), array())->
  with('request')->begin()->
    isParameter('module', 'category')->
    isParameter('action', 'show')->
    isParameter('id', $category->getId())->
  end()->

  info(sprintf('  2.2 - Рубрики с больше чем %s постами имеют блоки со страницами рубрики', $posts_on_category))->
  get('/categories')->
  click('Web')->
  with('request')->begin()->
    isParameter('module', 'category')->
    isParameter('action', 'show')->
  end()->

  with('response')->
    checkElement('.pager',2)->

  info(sprintf('  2.3 - Только %s постов показано',$posts_on_category))->
  with('response')->
  	checkElement('.post_preview', $posts_on_category)->

  info(' 2.4 - Ссылки на страницы с постами рубрики кликабельны')->
  click('2')->
  with('request')->
  	isParameter('page',2)->

  info(sprintf(' 2.4 - Рубрики с меньше чем %s постами не имеют блоки со страницами рубрики', $posts_on_category))->
  get('/categories')->
  click('Students')->
  with('request')->begin()->
    isParameter('module', 'category')->
    isParameter('action', 'show')->
  end()->

  with('response')->
    checkElement('.pager',0)->

  info(' 2.5 - Несуществующие рубрики отправляют на страницу 404')->
  get('/category/0')->
  with('response')->
  	isStatusCode(404);