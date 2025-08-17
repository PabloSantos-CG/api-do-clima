<?php

namespace App\Domain\Weather;

interface WeatherInterface
{
    public function getFullUrl(): string;
}
