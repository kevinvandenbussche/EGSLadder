<?php

namespace App\Service;
class HttpClient
{
    private \Symfony\Contracts\HttpClient\HttpClientInterface $client;

    public function __construct()
    {
        $this->client = \Symfony\Component\HttpClient\HttpClient::create();
    }

    protected function getClient(): \Symfony\Contracts\HttpClient\HttpClientInterface
    {
        return $this->client;
    }
}