<?php

namespace core\src\Middleware;

use core\src\Controllers\Controller;
use core\src\Http\Request\Request;
interface MiddlewareInterface
{
    public function init(Request $request);
}
