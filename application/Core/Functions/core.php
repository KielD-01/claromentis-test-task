<?php

use Illuminate\Http\Request;
use KielD01\Core\IoC;
use Symfony\Component\HttpFoundation\Response;

if (!function_exists('ioc')) {
    function ioc(): IoC
    {
        return IoC::getInstance();
    }
}

if (!function_exists('request')) {
    function request(): Request
    {
        return Request::capture();
    }
}

if (!function_exists('json')) {
    /**
     * @throws Exception
     */
    function json($data, int $code = 200, array $headers = []): void
    {
        $headers += ['Content-Type' => 'application/json'];

        $response = new Response(json_encode($data, JSON_PRETTY_PRINT), $code, $headers);
        $response->send();
    }
}