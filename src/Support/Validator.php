<?php

declare(strict_types=1);

namespace App\Support;

class Validator
{
    private array $errors = [];
    private array $data;
    public function validate(array $data, array $rules)
    {
        $this->errors = [];

        foreach ($rules as $field => $ruleArray) {
            if (!isset($data[$field])) {
                $this->errors[$field] = "Поле {$field} отсутствует";
                continue;
            }
            $value = $data[$field];
            dump($value);
        }

    }
    public function errors(): array
    {
        return $this->errors;
    }
}
