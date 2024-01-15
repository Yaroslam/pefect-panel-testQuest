<?php

namespace Exchange\Exceptions;

class CurrencyNotFoundException extends \Exception
{
    public function __construct(string $currency)
    {
        parent::__construct();
        $this->message = "currency $currency not found";
    }
}
