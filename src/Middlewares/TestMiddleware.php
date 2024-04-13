<?php

namespace src\Middlewares;
//use core\src\Middleware\MiddlewareInterface;
class TestMiddleware //implements MiddlewareInterface
{
    public function run()
    {
        return $this;
    }
}