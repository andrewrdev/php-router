<?php

use src\app\router\Router;

$router = new Router();

$router->get('/', 'IndexController@index');