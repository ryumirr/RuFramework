<?php

namespace core\src\Http\Response;

class JsonResponse
{
    public function isValidateJson(string $string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    public static function encodeJson(array $arr, $option = JSON_UNESCAPED_UNICODE)
    {   
        $json = json_encode($arr, $option);
        if (!$json) {
            throw new \JsonException('json encodingに失敗 : ' . json_last_error());
        }
        return $json;
    }

    public function decodeJson(string $json, $option = false)
    {
        $arr = json_decode($json, $option);
        if (!$arr) {
            throw new \JsonException('Last error: ' . json_last_error_msg() . PHP_EOL, PHP_EOL);
        }
        return $arr;
    }
}