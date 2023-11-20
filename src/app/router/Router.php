<?php 

declare(strict_types=1);

namespace src\app\router;

use src\app\http\Request;
use src\app\http\Response;


class Router 
{

    // ********************************************************************************************
    // ********************************************************************************************

    private function parseURL(string $url): array
    {
        $url = filter_var(trim($url), FILTER_SANITIZE_URL);
        $url = parse_url($url, PHP_URL_PATH); 
        $url = explode("/", $url);
        $url[0] = '/';
        $url = array_filter($url);        
        return $url; 
    }

    // ********************************************************************************************
    // ********************************************************************************************

    private function runController(string $controller, Request $request, Response $response) : void
    {
        $controllerParts = explode('@', $controller);
        $controller = $controllerParts[0];
        $method = $controllerParts[1];

        $class = 'src\\controllers\\' . $controller;
        $controller = new $class();
        $controller->$method($request, $response);
    }

    // ********************************************************************************************    
    // ********************************************************************************************

    private function initRouting(string $route, string $controller)
    {
        $route = $this->parseURL($route);
        $requestURI = $this->parseURL($_SERVER["REQUEST_URI"]); 
            
        $request = new Request();
        $response = new Response(); 

        if(count($requestURI) === count($route))
        {   
            $requestParams = [];  
            
            for($i = 0; $i < count($route); $i++)
            {
                if($route[$i][0] === '{')
                {
                    $requestParams[ str_replace(["{", "}"], "", $route[$i])] = $requestURI[$i];
                    unset($route[$i]);
                    unset($requestURI[$i]);
                }
            }    
            
            $request->setParamsFromURL($requestParams);
 
            $routeEqualsUrl = 0;

            foreach($requestURI as $requestURIValue)
            {
                foreach($route as $routeValue)
                {
                    if($requestURIValue === $routeValue)
                    {
                        $routeEqualsUrl++;
                    }
                }
            }

            if($routeEqualsUrl === count($requestURI))
            {   
                $this->runController($controller, $request, $response);                
            } else 
            {   
                http_response_code(404);
                $response->view('/error/404');              
            }

        } else 
        {   
            http_response_code(404);
            $response->view('/error/404');              
        }
    }    

    // ********************************************************************************************
    // ********************************************************************************************

    public function get(string $route, string $controller) : void
    {        
        if(mb_strtoupper($_SERVER["REQUEST_METHOD"]) === "GET")
        {            
            $this->initRouting($route, $controller);
        }
    }

    // ********************************************************************************************
    // ********************************************************************************************

    public function post(string $route, string $controller) : void
    {
        if(mb_strtoupper($_SERVER["REQUEST_METHOD"]) === "POST")
        {            
            $this->initRouting($route, $controller);
        }
    }

    // ********************************************************************************************
    // ********************************************************************************************
}