<?php

use App\Controller\IndexController;
use App\Framework\Router;
use App\Framework\Dispatcher;

$router = new Router();
$router->add('/', 'App\Controller\IndexController@index');


$dispatcher = new Dispatcher($router);
$dispatcher->handle();