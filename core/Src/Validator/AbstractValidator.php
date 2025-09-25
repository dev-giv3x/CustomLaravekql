<?php

namespace Src\Validator;

abstract class AbstractValidator
{
    protected string $field = '';
    protected $value;
    protected array $args = [];
    protected array $messageKeys = [];
    protected string $message = '';

    public function __construct(string $fieldName, $value, $args = [], string $message = null)
    {
        $this->field = $fieldName;
        $this->value = $value;
        $this->args = $args;
        $this->message = $message ?? $this->message;

        $this->messageKeys = [
            ":value" => $this->value,
            ":field" => $this->field
        ];
    }

    public function validate()
    {
        if (!$this->rule())
            return $this->messageError();
        return true;
    }

    private function messageError(): string
    {
        foreach ($this->messageKeys as $key => $value) {
            $message = str_replace($key, (string)$value, $this->message);
        }
        return $message;
    }

    abstract public function rule(): bool;
}
