<?php 

namespace src\controllers;

use src\config\http\Request;
use src\config\http\Response;

class IndexController
{
    // --------------------------------------------------------------------------------------------
    public function index(Request $request, Response $response)
    { 
        $response->view('IndexView');
    }
    
}