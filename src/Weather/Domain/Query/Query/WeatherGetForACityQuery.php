<?php

declare(strict_types=1);

namespace App\Weather\Domain\Query\Query;

final class WeatherGetForACityQuery
{
    private ?string $cityName;

    private ?int $cityId;

    private ?float $cityLat;

    private ?float $cityLon;

    public function __construct()
    {
        // init values
        $this->cityName = null;
        $this->cityId = null;
        $this->cityLat = null;
        $this->cityLon = null;
    }

    public function getCityName(): ?string
    {
        return $this->cityName;
    }

    public function setCityName(?string $cityName): self
    {
        $this->cityName = $cityName;

        return $this;
    }

    public function getCityId(): ?int
    {
        return $this->cityId;
    }

    public function setCityId(?int $cityId): self
    {
        $this->cityId = $cityId;

        return $this;
    }

    public function getCityLat(): ?float
    {
        return $this->cityLat;
    }

    public function setCityLat(?float $cityLat): self
    {
        $this->cityLat = $cityLat;

        return $this;
    }

    public function getCityLon(): ?float
    {
        return $this->cityLon;
    }

    public function setCityLon(?float $cityLon): self
    {
        $this->cityLon = $cityLon;

        return $this;
    }
}
