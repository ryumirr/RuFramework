<?php

use core\src\Http\ParameterBag;
use core\src\Http\Request\Request;
use src\Application\AppApplication;

require 'core/config/bootstrap.php';

try {
    $httpRequest = new Request(new ParameterBag());
    // $moduleName = $httpRequest->getParameterBag()->getModuleName();
    // moduleNameにより、稼働させるApllicationを分岐させる
    $application = new AppApplication($httpRequest);
    //  match ($moduleName) {
    //   'test' => new TestApplication($httpRequest),
    //   default => throw new RuntimeException('Not Found Module')
    // };
    echo $application->run();
} catch (\Exception $e) {
    // ErrorRunnerに移動させて処理
    var_dump($e->getMessage());
}
