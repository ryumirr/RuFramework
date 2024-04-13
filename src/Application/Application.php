<?php

namespace src\Application;

use core\src\Http\ParameterBag;
use core\src\Controllers\Controller;
use core\src\Http\Request\Request;
use core\src\Http\Response\Response;
use core\src\DB\DbManager;
use core\src\Router\Router;

abstract class Application
{
    protected array $_availableActions = [];
    protected ParameterBag $_parameters;
    protected Controller $_controller;
    protected Request $_request;
    protected Response $_response;
    protected Router $router;
    protected DbManager $dbManager;

    public function __construct(Request $_request)
    {
        $this->_request = $_request;
        $this->initialize();
    }

    public function initialize()
    {
        $this->_parameters = $this->_request->getParameterBag();
        $this->_request = new Request($this->_parameters);
        $this->router = new Router($this->registerRoutes());
        //$this->dbManager = new DbManager();
        echo 'initialize テスト！' . "\n";
    }

    public function run()
    {
        $params = $this->router->resolve($this->_request->getPathInfo());
        if ($params === false) {
            throw new \RuntimeException('Missmatching URL');
        }
        $controller = $params['controller'];
        $action = $params['action'];
        // middleware出発〜〜！
        //  $httpRequest; //= MiddlewareInit::init($httpRequest);
        $controller = $this->findController($controller);
        return $controller->run($action);
    }

    abstract protected function registerRoutes();

    abstract public function getRootDir();

    public function getControllerDir()
    {
        return $this->getRootDir() . '/Controllers';
    }

    public function getMiddlewareDir()
    {
        return $this->getRootDir() . '/Middlewares';
    }

    public function getViewDir()
    {
        return $this->getRootDir() . '/Views';
    }

    public function getModelDir()
    {
        return $this->getRootDir() . '/Models';
    }

    public function getWebDir()
    {
        return $this->getRootDir() . '/web';
    }

    protected function findController($controllerClass)
    {
        if (!class_exists($controllerClass)) {
            $controllerFile = $this->getControllerDir() . '/' . $controllerClass . 'php';
            if (!is_readable($controllerFile)) {
                return;
            }
            require_once $controllerFile;
            if (!class_exists($controllerClass)) {
                return;
            }
        }
        return new $controllerClass($this->_request);
    }
}
