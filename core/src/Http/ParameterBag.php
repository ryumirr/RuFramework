<?php

namespace core\src\Http;

/**
 * HTTPリクエストからのパラメータを取得し、
 * Get(String Parameters), そのほか(Postなどのやつ)のパラメーターをメソッドで分けて返す
 * 1つずつ取り出せるようにww
 * んーん
 * こいつを持って、リクエストクラスに組み込んで取り出すかも
 */
class ParameterBag
{
    protected $header;
    protected $body;
    /**
     * 全てのパラメータ
     * getパラメータのみ
     * そのほかのパラメータ
     * @var array $parameters
     */
    protected $parameters;

    public function __construct()
    {
        $this->header = $this->getCustomHeaders();
        $this->parameters = [
            'get' => $_GET,
            'post' => $_POST
        ];
    }

    public function getCustomHeaders()
    {
        $headers = [];
        $servers = $_SERVER;
        foreach ($servers as $key => $value) {
            if(preg_match("/^HTTP_X_/", $key)) {
                $headers[$key] = $value;
            }
        }
        return $headers;
    }

    public function getModuleName()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $moduleIndex = strpos($requestUri, '/', 1);
        $uri = substr($requestUri, $moduleIndex + 1);
        return substr($uri, 0, strpos(substr($requestUri, $moduleIndex + 1), '/', 1));
    }

    public function getHeader(string $name)
    {
        return isset($this->header[$name]) ? $this->header[$name] : '';
    }

    public function all()
    {
        return $this->parameters;
    }

    public function getAll()
    {
        return $this->parameters['get'];
    }

    public function get($key)
    {
        return $this->getAll()[$key] ?? null;
    }

    public function postAll()
    {
        return $this->parameters['post'];
    }

    public function post($key)
    {
        return $this->postAll()[$key] ?? null;
    }
}
