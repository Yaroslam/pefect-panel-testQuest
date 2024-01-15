<?php

namespace Requester;

use GuzzleHttp\Client;

abstract class AbstractRequester
{
    protected $URL;

    protected $response;

    protected $client;

    protected $headers = [
        'user-agent' => 'PostmanRuntime/7.32.2',
        'accept' => '*/*',
    ];

    public function __construct($url)
    {
        $this->client = new Client();
        $this->URL = $url;
    }

    public function makeGetRequest()
    {
        $this->response = $this->client->request('GET', $this->URL, ['verify' => false,
            'headers' => $this->headers,
            'http_errors' => false,
            'allow_redirects' => ['track_redirects' => true],
        ]);

    }

    public function getResponse()
    {
        return $this->response;
    }
}
