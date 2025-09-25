<?php

namespace Validators;
use Src\Validator\AbstractValidator;

class RegexValidator extends AbstractValidator
{
    protected string $message = 'Поле :field имеет неверный формат';

    public function rule(): bool
    {
        if(empty($this->args[0])){
            return true;
        }
        return (bool)preg_match($this->args[0], (string)$this->value);
    }
}