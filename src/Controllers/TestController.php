<?php

namespace src\Controllers;
use core\src\Http\Response\ApiResponse;
use core\src\Http\Response\Response;

/**
 * テストコントローラー
 */
class TestController extends AppController
{
    public function test1(): ApiResponse
    {
        $test = 'Hi, this is Test111111 in (first test version)ru-Framework! :)';
        $code = 200;
        return new ApiResponse($test, $code);
    }

    public function test2(): Response
    {
        $test = 'Hi, this is Test22222 in (first test version)ru-Framework! :)';
        $code = 200;
        return new Response($test, $code);
    }
}
