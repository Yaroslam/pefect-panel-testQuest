<?php

namespace Token;

class TokenSaver
{
    protected static ?self $instance = null;

    private $token;

    final public function __construct()
    {
    }

    final protected function __clone()
    {
    }

    final public function __wakeup()
    {
    }

    public static function getInstance(): static
    {
        if (static::$instance === null) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    public function set($token)
    {
        $this->token = $token;
    }

    public function get()
    {
        return $this->token;
    }
}
