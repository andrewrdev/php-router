<?php

use src\config\router\Router;

$router = new Router();

// ------------------------------------------------------------------------------------------------
$router->get("/", "IndexController@index");
