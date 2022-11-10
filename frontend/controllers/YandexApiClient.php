<?php

namespace frontend\controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class YandexApiClient
{
    /**
     * @var Client
     */
    private Client $client;

    private string $uri = 'https://geocode-maps.yandex.ru/1.x/';
    private string $apiKey = 'e666f398-c983-4bde-8f14-e3fec900592a';

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getAddressData(string $address): string
    {
        $url = $this->getGeoUrl($address);

        try {
            $response = $this->client->get($url);

            return $response->getBody()->getContents();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    private function getGeoUrl(string $address): string
    {
        $addressEncode = urlencode($address);
        return "{$this->uri}?apikey={$this->apiKey}&format=json&results=5&geocode={$addressEncode}";
    }
}