<?php 

namespace src\config\router;

use src\config\http\Request;
use src\config\http\Response;

class Router 
{

    // --------------------------------------------------------------------------------------------
    private function parseURL(string $url) : array
    {
        $url = filter_var(trim($url), FILTER_SANITIZE_URL);
        $url = parse_url($url, PHP_URL_PATH); 
        $url = explode("/", $url);
        $url[0] = "/";
        return array_filter($url);
    }

    // --------------------------------------------------------------------------------------------
    private function runController(string $controller, Request $request, Response $response) : void
    {
        $controllerParts = explode('@', $controller);
        $controller = $controllerParts[0];
        $method = $controllerParts[1];

        $class = 'src\\controllers\\' . ucfirst($controller);
        $controller = new $class;
        $controller->$method($request, $response);
    }

    // --------------------------------------------------------------------------------------------
    private function initRouting(string $route, string $controller)
    {
        $route = $this->parseURL($route);
        $url = $this->parseURL($_SERVER["REQUEST_URI"]);
        $requestParams = [];
        $request = new Request();
        $response = new Response();
            
        if(count($url) === count($route) && count($url) <= 5)
        {
            for($i = 0; $i < count($route); $i++)
            {
                if($route[$i][0] === '{')
                {
                    $requestParams[ str_replace(["{", "}"], "", $route[$i])] = $url[$i];
                    unset($route[$i]);
                    unset($url[$i]);
                }
            }

            $request->setParamsFromURL($requestParams);
 
            $routeEqualsUrl = 0;

            foreach($url as $urlValue)
            {
                foreach($route as $routeValue)
                {
                    if($urlValue === $routeValue)
                    {
                        $routeEqualsUrl++;
                    }
                }
            }

            if($routeEqualsUrl === count($url))
            {   
                $this->runController($controller, $request, $response);                
            }
        }
    }    

    // --------------------------------------------------------------------------------------------
    public function get(string $route, string $controller) : void
    {        
        if(mb_strtoupper($_SERVER["REQUEST_METHOD"]) === "GET")
        {            
            $this->initRouting($route, $controller);
        }
    }

    // --------------------------------------------------------------------------------------------
    public function post(string $route, string $controller) : void
    {
        if(mb_strtoupper($_SERVER["REQUEST_METHOD"]) === "POST")
        {            
            $this->initRouting($route, $controller);
        }
    }
}