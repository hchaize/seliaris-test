<?php

declare(strict_types=1);

namespace App\Test\Weather\Infrastructure\OpenWeatherMap\Broker;

use App\Weather\Infrastructure\OpenWeatherMap\Broker\WeatherOpenWeatherMapBroker;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class WeatherOpenWeatherMapBrokerFunctionalTest extends TestCase
{
    private const WEATHER_DATA = [
        'id' => 123456,
        'name' => 'Test City',
        'coord' => [
            'lat' => 12.34,
            'lon' => 56.78,
        ],
    ];

    public function testGetWeatherByCityNameShouldSucceed(): void
    {
        $response = new MockResponse(json_encode(self::WEATHER_DATA));
        $httpClient = new MockHttpClient([$response]);

        $weatherBroker = new WeatherOpenWeatherMapBroker('api_key', $httpClient);

        $result = $weatherBroker->getWeatherByCityName('Test City');

        $this->assertSame(self::WEATHER_DATA['id'], $result['id']);
        $this->assertSame(self::WEATHER_DATA['name'], $result['name']);
        $this->assertSame(self::WEATHER_DATA['coord']['lat'], $result['coord']['lat']);
        $this->assertSame(self::WEATHER_DATA['coord']['lon'], $result['coord']['lon']);
    }

    public function testGetWeatherByCityNameShouldThrowException(): void
    {
        $response = new MockResponse(json_encode([]), ['http_code' => 404]);
        $httpClient = new MockHttpClient([$response]);

        $weatherBroker = new WeatherOpenWeatherMapBroker('api_key', $httpClient);

        $this->expectException(NotFoundHttpException::class);
        $weatherBroker->getWeatherByCityName('Nonexistent City');
    }

    public function testGetWeatherByCityIdShouldSucceed(): void
    {
        $response = new MockResponse(json_encode(self::WEATHER_DATA));
        $httpClient = new MockHttpClient([$response]);

        $weatherBroker = new WeatherOpenWeatherMapBroker('api_key', $httpClient);

        $result = $weatherBroker->getWeatherByCityId(123456);

        $this->assertSame(self::WEATHER_DATA['id'], $result['id']);
        $this->assertSame(self::WEATHER_DATA['name'], $result['name']);
        $this->assertSame(self::WEATHER_DATA['coord']['lat'], $result['coord']['lat']);
        $this->assertSame(self::WEATHER_DATA['coord']['lon'], $result['coord']['lon']);
    }

    public function testGetWeatherByCityIdShouldThrowException(): void
    {
        $response = new MockResponse(json_encode([]), ['http_code' => 404]);
        $httpClient = new MockHttpClient([$response]);

        $weatherBroker = new WeatherOpenWeatherMapBroker('api_key', $httpClient);

        $this->expectException(NotFoundHttpException::class);
        $weatherBroker->getWeatherByCityId(999999);
    }

    public function testGetWeatherByCoordinatesShouldSucceed(): void
    {
        $response = new MockResponse(json_encode(self::WEATHER_DATA));
        $httpClient = new MockHttpClient([$response]);

        $weatherBroker = new WeatherOpenWeatherMapBroker('api_key', $httpClient);

        $result = $weatherBroker->getWeatherByCoordinates(12.34, 56.78);

        $this->assertSame(self::WEATHER_DATA['id'], $result['id']);
        $this->assertSame(self::WEATHER_DATA['name'], $result['name']);
        $this->assertSame(self::WEATHER_DATA['coord']['lat'], $result['coord']['lat']);
        $this->assertSame(self::WEATHER_DATA['coord']['lon'], $result['coord']['lon']);
    }

    public function testGetWeatherByCoordinatesShouldThrowException(): void
    {
        $response = new MockResponse(json_encode([]), ['http_code' => 404]);
        $httpClient = new MockHttpClient([$response]);

        $weatherBroker = new WeatherOpenWeatherMapBroker('api_key', $httpClient);

        $this->expectException(NotFoundHttpException::class);
        $weatherBroker->getWeatherByCoordinates(99.99, 99.99);
    }
}
