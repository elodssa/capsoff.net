<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new CapsoffTestFunctional(new sfBrowser());

$browser->
  get('/users')->

  with('request')->begin()->
    isParameter('module', 'user')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '!/This is a temporary page/')->
  end()
;
