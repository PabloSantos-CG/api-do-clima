<?php

namespace App\Domain\Services;

use App\Domain\Weather\WeatherInterface;

class WeatherService
{
    public function __construct(
        private WeatherInterface $weather,
    ) {}
}
