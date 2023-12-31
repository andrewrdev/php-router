<?php 

declare(strict_types=1);

namespace src\controllers;

use src\app\http\Request;
use src\app\http\Response;

class IndexController
{    

    // ********************************************************************************************
    // ********************************************************************************************

    public function index(Request $request, Response $response)
    {         
        $response->publicView('index');       
    }    

    // ********************************************************************************************
    // ********************************************************************************************
}