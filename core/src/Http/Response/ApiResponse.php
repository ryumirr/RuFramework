<?php
namespace core\src\Http\Response;

class ApiResponse
{
    protected string $apiResponse;
    protected int $statusCode;

    public function __construct(string $response, int $statusCode)
    {
        $this->apiResponse = $response;
        $this->statusCode = $statusCode;
    }

    public function response() {
        return [
            'data' => $this->apiResponse
        ];
    }

    public function errorResponse($code, $message) {
        return [
            'code' => $code,
            'message' => $message
        ];
    }

    public function getCode(): int
    {
        return $this->statusCode;
    }
}
