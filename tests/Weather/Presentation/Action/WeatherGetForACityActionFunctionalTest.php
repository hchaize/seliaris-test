<?php

declare(strict_types=1);

namespace App\Test\Weather\Presentation\Action;

use App\Test\Common\Presentation\Action\AbstractActionFunctionalTest;
use App\Test\Weather\Infrastructure\Broker\WeatherBrokerMock;
use Symfony\Component\HttpFoundation\Response;

final class WeatherGetForACityActionFunctionalTest extends AbstractActionFunctionalTest
{
    public function testInvokeShouldSucceed(): void
    {
        static::getContainer()->get(WeatherBrokerMock::class)->setWeatherData([
            'id' => 123456,
            'name' => 'Test City',
            'coord' => [
                'lat' => 12.34,
                'lon' => 56.78,
            ],
        ]);

        $this->client->request('GET', $this->router->generate('weather_get_for_a_city', ['city_id' => 123456, 'city_name' => 'Test City', 'city_lat' => 12.34, 'city_lon' => 56.78]));

        $this->assertResponseIsSuccessful();
    }

    public function testInvokeWithEmptyParametersShouldThrowException(): void
    {
        $this->client->request('GET', $this->router->generate('weather_get_for_a_city'));

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    public function testInvokeWithWrongParametersShouldThrowException(): void
    {
        static::getContainer()->get(WeatherBrokerMock::class)->setWeatherData([
            'id' => 123456,
            'name' => 'Test City',
            'coord' => [
                'lat' => 12.34,
                'lon' => 56.78,
            ],
        ]);

        $this->client->request('GET', $this->router->generate('weather_get_for_a_city', ['city_name' => 'Wrong City']));

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}
