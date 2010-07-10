<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new CapsoffTestFunctional(new sfBrowser());

$browser->
  get('/user/login')->

  with('request')->begin()->
    isParameter('module', 'sfGuardAuth')->
    isParameter('action', 'signin')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '!/This is a temporary page/')->
  end();