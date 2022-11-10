<?php

namespace frontend\controllers;

class YandexService
{
    private YandexApiClient $yandexApiClient;

    public function __construct()
    {
        $this->yandexApiClient = new YandexApiClient();
    }

    public function getAddresses(string $address): array
    {
        if (strlen(trim($address)) < 3) {
            return [];
        }

        $responseJson = $this->yandexApiClient->getAddressData($address);

        return $this->getAddressList($responseJson);
    }

    public function getGeoPoint(string $address): string
    {
        if (strlen(trim($address)) < 3) {
            return '';
        }

        $responseJson = $this->yandexApiClient->getAddressData($address);

        return $this->getPoint($address, $responseJson);
    }

    private function parseResponse(string $responseJson): array
    {
        if (($response = json_decode($responseJson)) === null) {
            return [];
        }

        return $response->response->GeoObjectCollection->featureMember;

    }

    private function getAddressList(string $responseJson): array
    {
        $contents = $this->parseResponse($responseJson);

        $result = [];
        foreach ($contents as $content) {
            $result[] = $content->GeoObject->metaDataProperty->GeocoderMetaData->Address->formatted;
        }

        return $result;
    }

    private function getPoint(string $address, string $responseJson): string
    {
        $contents = $this->parseResponse($responseJson);

        $result = '';
        foreach ($contents as $content) {
            if ($address === $content->GeoObject->metaDataProperty->GeocoderMetaData->Address->formatted) {
                $result = $this->reverseGeoPoint($content->GeoObject->Point->pos);
                break;
            }
        }

        return $result;
    }

    private function reverseGeoPoint(string $geoPoint): string
    {
        $geoPointArray = explode(' ', $geoPoint);

        return implode(', ', array_reverse($geoPointArray));
    }
}