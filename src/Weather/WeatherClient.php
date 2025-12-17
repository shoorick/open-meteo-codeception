<?php

declare(strict_types=1);

namespace App\Weather;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

final class WeatherClient
{
    private ClientInterface $httpClient;

    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function validateInput(string|int|float $latitude, string|int|float $longitude): bool
    {
        if ($latitude === '' || $longitude === '') {
            return false;
        }

        if (!is_numeric($latitude) || !is_numeric($longitude)) {
            return false;
        }

        $lat = (float)$latitude;
        $lon = (float)$longitude;

        return $lat >= -90 && $lat <= 90 && $lon >= -180 && $lon <= 180;
    }

    /**
     * @return array<string, mixed>
     * @throws GuzzleException
     */
    public function sendRequest(float $latitude, float $longitude): array
    {
        $response = $this->httpClient->request('GET', 'https://api.open-meteo.com/v1/forecast', [
            'query' => [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'daily' => 'sunrise,sunset',
                'current' => 'temperature_2m,relative_humidity_2m,wind_speed_10m,wind_direction_10m,wind_gusts_10m,surface_pressure',
                'timezone' => 'Europe/Berlin',
                'forecast_days' => 1,
                'wind_speed_unit' => 'ms',
            ],
        ]);

        $body = (string)$response->getBody();
        $decoded = json_decode($body, true);

        if (!\is_array($decoded)) {
            throw new \RuntimeException('Invalid JSON response from API');
        }

        return $decoded;
    }
}
