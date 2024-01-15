<?php

namespace Exchange\Exceptions;

class MinimumValueException extends \Exception
{
    public function __construct($min)
    {
        parent::__construct();
        $this->message = "minimum from currency value is $min";
    }
}
