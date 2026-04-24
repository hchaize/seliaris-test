<?php

declare(strict_types=1);

namespace App\Weather\Domain\Query\Broker;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

interface WeatherBrokerInterface
{
    /**
     * @return array<mixed>
     *
     * @throws NotFoundHttpException
     */
    public function getWeatherByCityName(string $cityName): array;

    /**
     * @return array<mixed>
     *
     * @throws NotFoundHttpException
     */
    public function getWeatherByCityId(int $cityId): array;

    /**
     * @return array<mixed>
     *
     * @throws NotFoundHttpException
     */
    public function getWeatherByCoordinates(float $lat, float $lon): array;
}
