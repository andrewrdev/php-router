<?php 

namespace src\config\http;

class Response 
{

    // --------------------------------------------------------------------------------------------
    public function view(string $viewName, array $viewData = null) : void
    {
        if(file_exists(__DIR__ . "/../../views/" . $viewName . ".php"))
        {
            require_once __DIR__ . "/../../views/" . $viewName . ".php";
        }
    }

    // --------------------------------------------------------------------------------------------
    public function redirect(string $route) : void
    {
        header("Location:" . $route);
        exit;
    }

}