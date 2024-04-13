<?php

namespace core\src\Http\Request;

use core\src\Http\ParameterBag;
use RuntimeException;

class Request
{
    private ParameterBag $_parameterBag;
    public function __construct(ParameterBag $parameterBag)
    {
        $this->_parameterBag = $parameterBag;
        $this->init();
    }

    public function isGetMethod(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    public function isPostMethod(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function isOptionMethod(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'OPTION';
    }

    public function isHeadMethod(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'HEAD';
    }

    public function isDeleteMethod(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'DELETE';
    }

    public function getParameterBag()
    {
        return $this->_parameterBag;
    }

    public function init(): void
    {
        // if ($this->isGetMethod() || $this->isOptionMethod()) {
        //     Validation::validate($this->_parameterBag->getAll());
        // } elseif ($this->isPostMethod()) {
        //     Validation::validate($this->_parameterBag->postAll());
        // } else {
        //     throw new RuntimeException('GET, POSTメソッドのみ許可されました');
        // }
    }

    public function getRequestUri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function getPathInfo()
    {
        $baseUrl = $this->getBaseUrl();
        $requestUri = $this->getRequestUri();

        $pos = strpos($requestUri, '?');
        if (false !== $pos) {
            $requestUri = substr($requestUri, 0, $pos);
        }

        return (string)substr($requestUri, strlen($baseUrl));
    }

    public function getBaseUrl()
    {
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $requestUri = $this->getRequestUri();

        if (strpos($requestUri, $scriptName) === 0) {
            return $scriptName;
        } else if (strpos($requestUri, dirname($scriptName)) == 0) {
            return rtrim(dirname($requestUri), '/');
        }
        return '';
    }
}
