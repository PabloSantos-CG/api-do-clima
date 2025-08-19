<?php

namespace App\Domain\Weather;

interface WeatherInterface
{
    // get url of all data
    public function getUrlForAllData(): string;
}
