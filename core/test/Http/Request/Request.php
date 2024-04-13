<?php

namespace core\src\Http\Request;

use core\src\Http\ParameterBag;

abstract class Request
{
    private string $_headers;
    private ParameterBag $_parameterBag;
    public function __construct(ParameterBag $parameterBag)
    {
        $this->_parameterBag = $parameterBag;
    }

    // バリデーションw
}