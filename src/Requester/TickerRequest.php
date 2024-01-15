<?php

namespace Requester;

class TickerRequest extends AbstractRequester
{
    public function __construct()
    {
        parent::__construct('https://blockchain.info/ticker');
    }
}
