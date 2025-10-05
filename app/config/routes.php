<?php

use App\Controller\IndexController;
use App\Framework\Dispatcher;
use App\Framework\Router;

$router = new Router();
$router->add('/', 'App\Controller\IndexController@index');


$dispatcher = new Dispatcher($router);
$dispatcher->handle();