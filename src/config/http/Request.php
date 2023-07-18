<?php 

namespace src\config\http;

class Request 
{
    private array $urlParams;
    private array $requestParams;

    // --------------------------------------------------------------------------------------------
    public function getParamsFromURL() : array
    {
        return $this->urlParams;
    }

    // --------------------------------------------------------------------------------------------
    public function setParamsFromURL(array $urlParams)
    {
        $this->urlParams = $urlParams;
    }

    // --------------------------------------------------------------------------------------------
    public function getParamsFromRequest() : array
    {
        return $this->requestParams;
    }

    // --------------------------------------------------------------------------------------------
    public function setParamsFromRequest(array $params)
    {
        $this->requestParams = $params;
    }

}