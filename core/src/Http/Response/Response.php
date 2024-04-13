<?php

namespace core\src\Http\Response;

class Response
{
    private mixed $_data;
    private mixed $_statusCode;

    public function __construct(mixed $response, int $statusCode)
    {
        $this->_data = $response;
        $this->_statusCode = $statusCode;
    }

    public function getBody()
    {
        if (!isset($this->_data)) {
            throw new \RuntimeException('レスポンスデータが空');
        }
        return $this->_data;
    }

    public function getErrMessage()
    {
        $error = isset($this->_data['error']) ? $this->_data['error'] : '';
        return isset($error['message']) ? $error['message'] : '';
    }

    public function getCode()
    {
        return $this->_statusCode;
    }
}
