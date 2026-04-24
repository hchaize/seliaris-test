<?php

declare(strict_types=1);

namespace App\Weather\Presentation\Action;

use App\Weather\Domain\Query\Query\WeatherGetForACityQuery;
use App\Weather\Domain\Query\Query\WeatherGetForACityQueryHandler;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/weather', name: 'weather_get_for_a_city', methods: ['GET'])]
#[OA\QueryParameter(name: 'city_name', description: 'city name', required: false, example: 'Paris')]
#[OA\QueryParameter(name: 'city_id', description: 'city ID', required: false, example: '2988507')]
#[OA\QueryParameter(name: 'city_lat', description: 'city latitude', required: false, example: '48.8534')]
#[OA\QueryParameter(name: 'city_lon', description: 'city longitude', required: false, example: '2.3488')]
#[OA\Response(response: 200, description: 'Successful response')]
#[OA\Response(response: 400, description: 'Bad request')]
#[OA\Response(response: 404, description: 'City not found')]
#[OA\Response(response: 500, description: 'Internal server error')]
#[OA\Tag('Weather')]
final class WeatherGetForACityAction extends AbstractController
{
    private WeatherGetForACityQueryHandler $handler;

    public function __construct(WeatherGetForACityQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Request $request): Response
    {
        $query = new WeatherGetForACityQuery();

        if ($request->query->has('city_name')) {
            $query->setCityName($request->query->get('city_name'));
        }

        if ($request->query->has('city_id')) {
            $query->setCityId((int) $request->query->get('city_id'));
        }

        if ($request->query->has('city_lat')) {
            $query->setCityLat((float) $request->query->get('city_lat'));
        }

        if ($request->query->has('city_lon')) {
            $query->setCityLon((float) $request->query->get('city_lon'));
        }

        $response = $this->handler->handle($query);

        return $this->json($response->getData());
    }
}
