<?php
namespace core\test\Controller;

use core\src\Http\Request\Request;
use core\src\Http\Response\Response;

abstract class Controller
{
    private Request $_request;
    private Response $_response;
    public function __construct(Request $request)
    {
        $this->_request = $request;
    }
    
    
}
