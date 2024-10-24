<?php

namespace App\Services;

use GuzzleHttp\Client;

class OpenCageService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('OPENCAGE_API_KEY');
    }

    public function getCoordinates($city)
    {
        $response = $this->client->get('https://api.opencagedata.com/geocode/v1/json', [
            'query' => [
                'q' => $city,
                'key' => $this->apiKey,
                'limit' => 1 // Limitar a un resultado
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        if (!empty($data['results'])) {
            return [
                'lat' => $data['results'][0]['geometry']['lat'],
                'lng' => $data['results'][0]['geometry']['lng'],
            ];
        }

        return null; // Retorna null si no se encuentran resultados
    }
}
