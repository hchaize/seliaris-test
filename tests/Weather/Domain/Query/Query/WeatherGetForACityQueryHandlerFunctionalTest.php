<?php

declare(strict_types=1);

namespace App\Test\Weather\Domain\Query\Query;

use App\Test\Weather\Infrastructure\Broker\WeatherBrokerMock;
use App\Weather\Domain\Query\Query\WeatherGetForACityQuery;
use App\Weather\Domain\Query\Query\WeatherGetForACityQueryHandler;
use App\Weather\Domain\Query\Query\WeatherGetForACityQueryResult;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class WeatherGetForACityQueryHandlerFunctionalTest extends KernelTestCase
{
    private WeatherGetForACityQueryHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = static::getContainer()->get(WeatherGetForACityQueryHandler::class);
    }

    public function testHandleShouldSucceed(): void
    {
        static::getContainer()->get(WeatherBrokerMock::class)->setWeatherData([
            'id' => 123456,
            'name' => 'Test City',
            'coord' => [
                'lat' => 12.34,
                'lon' => 56.78,
            ],
        ]);

        $query = (new WeatherGetForACityQuery())
            ->setCityName('Test City')
            ->setCityId(123456)
            ->setCityLat(12.34)
            ->setCityLon(56.78);

        $result = $this->handler->handle($query);

        $this->assertInstanceOf(WeatherGetForACityQueryResult::class, $result);
        $this->assertSame(123456, $result->getData()['id']);
        $this->assertSame('Test City', $result->getData()['name']);
        $this->assertSame(12.34, $result->getData()['coord']['lat']);
        $this->assertSame(56.78, $result->getData()['coord']['lon']);
    }

    public function testHandleWithWrongParametersShouldThrowException(): void
    {
        $this->expectException(BadRequestHttpException::class);

        $query = new WeatherGetForACityQuery();

        $this->handler->handle($query);
    }
}
