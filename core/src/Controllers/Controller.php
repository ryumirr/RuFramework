<?php

namespace core\src\Controllers;

use core\src\Http\Request\Request;
use core\src\Http\Response\Response;
use core\src\Http\Response\JsonResponse;
use core\src\Http\Validation\Validation;
use core\src\Http\Response\ApiResponse;
use core\src\Middleware\Middleware;
use RuntimeException;

abstract class Controller
{
    protected Request $_request;
    protected Response $_response;
    protected $middlewares = [];

    public function __construct(Request $request)
    {
        $this->_request = $request;
        // $this->initAndValidate();
    }

    public function initAndValidate(): void
    {
        if ($this->_request->isGetMethod() || $this->_request->isOptionMethod()) {
            Validation::validate($this->_request->getParameterBag()->getAll());
        } elseif ($this->_request->isPostMethod()) {
            Validation::validate($this->_request->getParameterBag()->postAll());
        } else {
            throw new RuntimeException('GET, POSTメソッドのみ許可されました');
        }
    }

    public function run($action)
    {
        // アクションチェック
        if (!method_exists($this, $action)) {
            throw new RuntimeException('Not Found 404 :(');
        }
        foreach ($this->middlewares as $middleware) {
            $middlewareName = $middleware . 'Middleware';
            new $middlewareName($this->_request);
        }
        $reflectionMethod = new \ReflectionMethod($this, $action);
        $result = $reflectionMethod->invoke($this, $this->_request);
        if ($result instanceof ApiResponse) {
            http_response_code($result->getCode());
            echo JsonResponse::encodeJson($result->response());
        } elseif ($result instanceof Response) {
            http_response_code($result->getCode());
            echo $result->getBody();
        } else {
            throw new \Exception('予測外のException...');
        }
    }

    protected function getValueForMiddleware(Middleware $middleware, $index)
    {
        if (!isset($this->middlewares[$index])) {
            return $middleware;
        }
        $middlewareName = $this->middlewares[$index];
        $middlewareName = $middlewareName . 'Middleware';
        $result = new $middlewareName();
        return $this->getValueForMiddleware($result->init($this->_request), $index++);
    }
}
