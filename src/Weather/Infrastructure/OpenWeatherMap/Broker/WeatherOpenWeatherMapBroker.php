<?php

declare(strict_types=1);

namespace App\Weather\Infrastructure\OpenWeatherMap\Broker;

use App\Weather\Domain\Query\Broker\WeatherBrokerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class WeatherOpenWeatherMapBroker implements WeatherBrokerInterface
{
    private const BASE_API_URL = 'https://api.openweathermap.org/data/2.5/weather';

    private string $apiKey;

    private HttpClientInterface $httpClient;

    public function __construct(string $apiKey, HttpClientInterface $httpClient)
    {
        $this->apiKey = $apiKey;
        $this->httpClient = $httpClient;
    }

    public function getWeatherByCityName(string $cityName): array
    {
        $response = $this->httpClient->request(Request::METHOD_GET, $this::BASE_API_URL.'?q='.urlencode($cityName).'&APPID='.urlencode($this->apiKey));

        if (200 !== $response->getStatusCode()) {
            throw new NotFoundHttpException('This city doesn\'t exist');
        }

        return json_decode($response->getContent(), true);
    }

    public function getWeatherByCityId(int $cityId): array
    {
        $response = $this->httpClient->request(Request::METHOD_GET, $this::BASE_API_URL.'?id='.urlencode((string) $cityId).'&APPID='.urlencode($this->apiKey));

        if (200 !== $response->getStatusCode()) {
            throw new NotFoundHttpException('This city doesn\'t exist');
        }

        return json_decode($response->getContent(), true);
    }

    public function getWeatherByCoordinates(float $lat, float $lon): array
    {
        $response = $this->httpClient->request(Request::METHOD_GET, $this::BASE_API_URL.'?lon='.urlencode((string) $lon).'&lat='.urlencode((string) $lat).'&APPID='.urlencode($this->apiKey));

        if (200 !== $response->getStatusCode()) {
            throw new NotFoundHttpException('This city doesn\'t exist');
        }

        return json_decode($response->getContent(), true);
    }
}
