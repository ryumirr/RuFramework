<?php

namespace core\src\Middleware;

use core\src\Http\Request\Request;

final class MiddlewareInit
{
    public static function init(Request $request): Request
    {
        $middlewares = glob(dirname(__FILE__, 4) . '/src/' . 'Middlewares/*Middleware.php');
       // var_dump($middlewares);
        // var_dump('MiddlewareInit: 未完成のため、exit処理してる');
        // exit;
        /**
         * 유저가 추가한 미들웨어를 1바퀴 전부 돌린다.
         */
        $response = $request;
        // foreach ($middlewares as $middleware) {
        //     $response = new $middleware($response);
        // }
        return $response;
    }
}