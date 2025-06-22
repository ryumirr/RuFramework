<?php

use core\src\Http\ParameterBag;
use core\src\Http\Request\Request;
use src\Application\AppApplication;

require 'core/config/bootstrap.php';

try {
    $httpRequest = new Request(new ParameterBag());
    $application = new AppApplication($httpRequest);
    echo $application->run();
} catch (\Exception $e) {
    // ErrorRunnerに移動させて処理
    var_dump($e->getMessage());
}
