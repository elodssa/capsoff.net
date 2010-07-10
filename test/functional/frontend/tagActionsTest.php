<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new CapsoffTestFunctional(new sfBrowser());

$browser->
  get('/tags')->

  with('request')->begin()->
    isParameter('module', 'tag')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '!/This is a temporary page/')->
  end()
;
