<?php

namespace core\src\Http\Validation;

use core\src\Exception\ValidationException;

abstract class Validation
{
    /**
     * 'name' => ['type' => 'string', 'min-length' => 10,'max-length' => 10]
     */
    public function validate(array $parameters)
    {
        $allTypeRules = $this->rules();
        $countEmptyArr = array_diff_key($parameters, $allTypeRules);
        if (count($countEmptyArr) > 0) {
            throw new ValidationException("Validate Error");
        }

        // required, nullable
        foreach ($allTypeRules as $key => $typeRules) {
            $parameter = $parameters[$key];
            $newTypeRule = explode(',', $typeRules);
            $this->checkValidate($parameter, $newTypeRule);
        }
    }

    private function checkValidate($parameter, array $newTypeRule)
    {
        foreach ($newTypeRule as $type => $data) {
            if ($type !== 'nullable' && is_null($data)) {
                throw new ValidationException("Validate Error: Not nullable");
            }
            $this->checkNullable($type, $data);
            match ($type) {
                'type' => $this->whatIsType($type, $data),
                'min-length' => is_int($data) && ($data >= $parameter),
                'max-length' => is_int($data) && ($data < $parameter),
            };
        }
    }

    private function checkNullable($key, $data): void
    {
        if ($key !== 'nullable' && $data == null) {
            throw new ValidationException("Validate Error: Not nullable key:{$key} value:{$data}");
        }
    }
    abstract public function rules(): array;

    protected function whatIsType($type, $data)
    {
        return match ($type) {
            
            'string' => is_string($data),
            'int' => is_numeric($data),
            'bool' => is_bool($data),
            'array' => is_array($data),
            'double' => is_double($data),
            'file' => is_file($data),
            'float' => is_float($data),
            'callable' => is_callable($data),
        };
    }
}
