<?php

declare(strict_types=1);

namespace App\Weather\Domain\Query\Query;

final class WeatherGetForACityQueryResult
{
    /** @var array<mixed> */
    private array $data;

    /** @return array<mixed> */
    public function getData(): array
    {
        return $this->data;
    }

    /** @param array<mixed> $data */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }
}
