<?php

namespace src\Application;

use src\Controllers\TestController;

class AppApplication extends Application
{
    // protected array $_availableActions = ['test'];
    protected function registerRoutes()
    {
        return [
            '/module1' => [
                '/test' => ['controller' => TestController::class, 'action' => 'test1']
            ],
            '/module2' => [
                '/test' => ['controller' => TestController::class, 'action' => 'test2']
            ]
        ];
    }

    public function getRootDir()
    {
        return dirname(__FILE__);
    }
}
