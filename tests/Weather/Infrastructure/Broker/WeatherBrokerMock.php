<?php

declare(strict_types=1);

namespace App\Test\Weather\Infrastructure\Broker;

use App\Weather\Domain\Query\Broker\WeatherBrokerInterface;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[AsAlias(WeatherBrokerInterface::class)]
final class WeatherBrokerMock implements WeatherBrokerInterface
{
    private array $weatherData;

    public function __construct()
    {
        $this->weatherData = [
            'id' => null,
            'name' => null,
            'coord' => [
                'lat' => null,
                'lon' => null,
            ],
        ];
    }

    public function setWeatherData(array $weatherData): void
    {
        $this->weatherData = $weatherData;
    }

    public function getWeatherByCityName(string $cityName): array
    {
        if ($cityName !== $this->weatherData['name']) {
            throw new NotFoundHttpException('This city does\'nt exist');
        }

        return $this->weatherData;
    }

    public function getWeatherByCityId(int $cityId): array
    {
        if ($cityId !== $this->weatherData['id']) {
            throw new NotFoundHttpException('This city does\'nt exist');
        }

        return $this->weatherData;
    }

    public function getWeatherByCoordinates(float $lat, float $lon): array
    {
        if ($lat !== $this->weatherData['coord']['lat'] || $lon !== $this->weatherData['coord']['lon']) {
            throw new NotFoundHttpException('This location does\'nt exist');
        }

        return $this->weatherData;
    }
}
