<?php

declare(strict_types=1);

namespace App\Weather\Domain\Query\Query;

use App\Weather\Domain\Query\Broker\WeatherBrokerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class WeatherGetForACityQueryHandler
{
    private WeatherBrokerInterface $weatherBroker;

    public function __construct(WeatherBrokerInterface $weatherBroker)
    {
        $this->weatherBroker = $weatherBroker;
    }

    public function handle(WeatherGetForACityQuery $query): WeatherGetForACityQueryResult
    {
        if (null === $query->getCityName() && null === $query->getCityId() && (null === $query->getCityLat() || null === $query->getCityLon())) {
            throw new BadRequestHttpException('Bad Request: Please specify city_name, city_id or city_lat/city_lon');
        }

        if (null !== $query->getCityLat() && null !== $query->getCityLon()) {
            $response = $this->weatherBroker->getWeatherByCoordinates($query->getCityLat(), $query->getCityLon());
        } elseif (null !== $query->getCityId()) {
            $response = $this->weatherBroker->getWeatherByCityId($query->getCityId());
        } elseif (null !== $query->getCityName()) {
            $response = $this->weatherBroker->getWeatherByCityName($query->getCityName());
        } else {
            throw new BadRequestHttpException('Bad Request');
        }

        return (new WeatherGetForACityQueryResult())
            ->setData($response);
    }
}
