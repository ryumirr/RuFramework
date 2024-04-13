<?php

namespace core\src\Http\Validation;

use core\src\Exception\ValidationException;

abstract class Validation
{
    public function validate(array $parameters): void
    {
        $allTypeRules = $this->rules();
        $countEmptyArr = array_diff_key($parameters, $allTypeRules);
        if (count($countEmptyArr) > 0) {
            throw new ValidationException("Validate Error Not matches Parameters Rule:(  count: " . implode($countEmptyArr));
        }

        foreach ($allTypeRules as $key => $typeRules) {
            $this->checkUniqueValue($key, $parameters);
            $newTypeRule = explode(',', $typeRules);
            $parameter = $parameters[$key];
            if (!$this->checkValidate($parameter, $newTypeRule)) {
                throw new ValidationException("Validate Error type:{$key} rules:{$typeRules}");
            }
        }
    }

    /**
     * 'name' => ['type' => 'string', 'min-length' => 10,'max-length' => 10]
     */
    abstract public function rules(): array;
    private function checkValidate($parameter, array $newTypeRule)
    {
        foreach ($newTypeRule as $type => $data) {
            $this->checkRequiredValue($type, $data);
            $this->checkNullable($type, $data);
            return match ($type) {
                'type' => $this->isCorrectType($type, $data),
                'min-length' => is_int($data) && ($data >= $parameter),
                'max-length' => is_int($data) && ($data < $parameter),
            };
        }
    }

    private function checkRequiredValue($key, $data): void
    {
        if ($key === 'required' && !$data) {
            throw new ValidationException("Validate Error: This is Required Value, key:{$key} value:{$data}");
        }
    }

    private function checkUniqueValue($key, $parameters): void
    {
        if ($key === 'unique' &&
           count(array_map($key, $parameters)) > 1) {
            throw new ValidationException("Validate Error Unique KEY :{$key} parameter's count :{count($parameters)}");
        }
    }

    private function checkNullable($key, $data): void
    {
        if ($key !== 'nullable' && is_null($data)) {
            throw new ValidationException("Validate Error: Not nullable key:{$key} value:{$data}");
        }
    }

    protected function isCorrectType($type, $data)
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
