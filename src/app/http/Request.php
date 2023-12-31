<?php

declare(strict_types=1);

namespace src\app\http;

class Request
{
    private array $urlParams;

    // ********************************************************************************************
    // ********************************************************************************************

    public function getParam(string $param = ''): string
    {
        return $this->urlParams[$param];
    }
    
    // ********************************************************************************************
    // ********************************************************************************************
    
    public function setParamsFromURL(array $urlParams): void
    {
        $this->urlParams = $urlParams;
    }

    // ********************************************************************************************
    // ********************************************************************************************
}
