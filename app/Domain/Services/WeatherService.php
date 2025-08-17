<?php

namespace App\Domain\Services;

use App\Domain\Weather\WeatherFactory;

class WeatherService
{
    public function __construct(
        private WeatherFactory $weatherFactory,
    ) {}

    /** @param string[] $coordinates */
    public function getCurrentWeather(array $coordinates)
    {
        $url = $this->weatherFactory->make($coordinates)->getFullUrl();
    }
}
