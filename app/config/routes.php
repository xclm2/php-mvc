<?php

use App\Framework\Dispatcher;
use App\Framework\Router;

$web = new App\Framework\Router\Web();
$web->add('/', 'App\Controller\IndexController@index');

$api = new App\Framework\Router\Api();
$api->add('/api/user/', 'App\Controller\Api\User@getUser');



$dispatcher = new Dispatcher($web);
$dispatcher->handle();

$dispatcher = new Dispatcher($api);
$dispatcher->handle();