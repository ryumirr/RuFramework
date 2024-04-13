<?php

namespace core\src\Http;
/**
 * HTTPリクエストからのパラメータを取得し、
 * Get(String Parameters), そのほか(Postなどのやつ)のパラメーターをメソッドで分けて返す
 * 1つずつ取り出せるようにww
 * んーん
 * こいつを持って、リクエストクラスに組み込んで取り出すかも
 */
 
class ParameterBag {
    protected $header;
    protected $body;
    /**
     * 全てのパラメータ
     * getパラメータのみ
     * そのほかのパラメータ
     *
     * @var array $parameters
     */
    protected $parameters;
    
    public function __construct()
    {
        $this->body = [
            'body' => $_SERVER 
        ];
        $this->parameters = [
            'get' => $_GET,
            'post' => $_POST
        ];
    }

    public function getBody()
    {
        return $this->body;
    }

    public function all()
    {
        return $this->parameters;
    }
    public function getAll(array $postParameters = [])
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