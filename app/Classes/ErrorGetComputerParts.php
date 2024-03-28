<?php

namespace App\Classes;

class ErrorGetComputerParts
{
    private string $textError;
    public function __construct($textError)
    {
        $this->textError = $textError;
    }
    public function getTextError(): string
    {
        return $this->textError;
    }
}
